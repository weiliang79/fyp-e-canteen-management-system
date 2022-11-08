<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    /**
     * Show the report page with the specified user role.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {

            if (Order::all()->count() === 0) {
                return redirect()->route('admin.home')->with('swal-warning', 'There are currently no orders records in the system');
            }

            $startDate = Order::orderBy('created_at', 'asc')->first()->created_at->firstOfMonth();
            $endDate = Order::orderBy('created_at', 'desc')->first()->created_at->firstOfMonth();

            $list = (object)[
                'monthly' => [],
                'yearly' => [],
            ];

            while ($endDate->gte($startDate)) {

                if ($endDate->month == 1) {
                    $list->yearly['year:' . strval($endDate->getTimestamp())] = $endDate->format('Y');
                }

                $list->monthly['month:' . strval($endDate->getTimestamp())] = $endDate->format('Y F');
                $endDate->subMonth();
            }

            if ($endDate->month !== 1) {
                $list->yearly['year:' . strval($endDate->getTimestamp())] = $endDate->format('Y');
            }

            return view('admin.reports.index', compact('list'));
        } else {
            $user = User::find(Auth::user()->id);

            if ($user->store === null) {
                return redirect()->route('food_seller.store');
            }

            $productIds = $user->store->products->pluck('id')->toArray();
            $orders = Order::whereHas('orderDetails', function ($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })->get();

            if ($orders->count() === 0) {
                return redirect()->route('food_seller.home')->with('swal-warning', 'There are currently no orders records in the system');
            }

            $startDate = Order::whereHas('orderDetails', function ($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
                ->orderBy('created_at', 'asc')
                ->first()
                ->created_at
                ->firstOfMonth();
            $endDate = Order::orderBy('created_at', 'desc')->first()->created_at->firstOfMonth();

            $list = (object)[
                'monthly' => [],
                'yearly' => [],
            ];

            while ($endDate->gte($startDate)) {

                if ($endDate->month == 1) {
                    $list->yearly['year:' . strval($endDate->getTimestamp())] = $endDate->format('Y');
                }

                $list->monthly['month:' . strval($endDate->getTimestamp())] = $endDate->format('Y F');
                $endDate->subMonth();
            }

            if ($endDate->month !== 1) {
                $list->yearly['year:' . strval($endDate->getTimestamp())] = $endDate->format('Y');
            }

            return view('food_seller.reports.index', compact('list'));
        }
    }

    /**
     * Get the specified month or year report to the specified user role.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        $request->validate([
            'report_date' => 'required',
        ]);

        $split = explode(':', $request->report_date);
        $reportDate = Carbon::createFromTimestamp($split[1]);

        if (Auth::user()->isAdmin()) {

            if ($split[0] === 'year') {
                $monthlySales = $this->generateAdminMonthlySaleByYear($reportDate);
                $storesSales = $this->generateAdminStoresSalesByYear($reportDate);
                $productCategoriesSales = $this->generateAdminProductCategoriesSalesByYear($reportDate);
                $topProductsSales = $this->generateAdminTopProductsSalesByYear($reportDate);

                return response()->json([
                    'message' => 'success',
                    'type' => 'year',
                    'appName' => config('app.name'),
                    'title' => 'Yearly Sales Report in ' . $reportDate->format('Y'),
                    'monthlySales' => $monthlySales,
                    'storesSales' => $storesSales,
                    'productCategoriesSales' => $productCategoriesSales,
                    'topProductsSales' => $topProductsSales,
                ]);
            } else {
                $productCategoriesSales = $this->generateAdminProductCategoriesSalesByMonth($reportDate);
                $storesSales = $this->generateAdminStoreSalesByMonth($reportDate);
                $topProductsSales = $this->generateAdminTopProductsSalesByMonth($reportDate);

                return response()->json([
                    'message' => 'success',
                    'type' => 'month',
                    'appName' => config('app.name'),
                    'title' => 'Monthly Sales Report in ' . $reportDate->format('Y F'),
                    'productCategoriesSales' => $productCategoriesSales,
                    'storesSales' => $storesSales,
                    'topProductsSales' => $topProductsSales,
                ]);
            }
        } else {
            $store = User::find(Auth::user()->id)->store;
            if ($split[0] === 'year') {
                $monthlySales = $this->generateFoodSellerMonthySalesByYear($reportDate, $store);
                $productSales = $this->generateFoodSellerProductsSalesByYear($reportDate, $store);

                return response()->json([
                    'message' => 'success',
                    'type' => 'year',
                    'appName' => config('app.name'),
                    'title' => 'Yearly Sales Report in ' . $reportDate->format('Y'),
                    'monthlySales' => $monthlySales,
                    'productSales' => $productSales,
                ]);
            } else {
                $dailySales = $this->generateFoodSellerDailySalesByMonth($reportDate, $store);
                $productSales = $this->generateFoodSellerProductsSalesByMonth($reportDate, $store);

                return response()->json([
                    'message' => 'success',
                    'type' => 'month',
                    'appName' => config('app.name'),
                    'title' => 'Monthly Sales Report in ' . $reportDate->format('Y F'),
                    'dailySales' => $dailySales,
                    'productSales' => $productSales,
                ]);
            }
        }
    }

    /**
     * Get the yearly report with monthly sales.
     *
     * @param Carbon $date
     * @return array
     */
    private function generateAdminMonthlySaleByYear($date)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $tableRow = [];
        $tempStart = $date->copy();

        array_push($tableRow, ['Month', 'Order Count', 'Order Sales(' . config('payment.currency_symbol') . ')']);

        while ($tempStart->month <= 12 && $tempStart->year <= $date->year) {
            $tempEnd = $tempStart->copy();
            $tempEnd->endOfMonth();
            array_push($label, $tempStart->englishMonth);
            $count = \App\Models\Order::whereBetween('created_at', [$tempStart, $tempEnd])->count();
            $sales = \App\Models\Order::whereBetween('created_at', [$tempStart, $tempEnd])->sum('total_price');
            array_push($countData, $count);
            array_push($salesData, $sales);
            array_push($tableRow, [$tempStart->englishMonth, $count, $sales]);

            $tempStart->addMonth();
        }

        $result = [
            'chart' => [
                'data' => [
                    'datasets' => [[
                        'type' => 'line',
                        'label' => 'Order count',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => $countData,
                    ], [
                        'type' => 'line',
                        'label' => 'Order Sales(' . config('payment.currency_symbol') . ')',
                        'backgroundColor' => 'rgb(11, 94, 215)',
                        'borderColor' => 'rgb(11, 94, 215)',
                        'data' => $salesData,
                    ]],
                    'labels' => $label,
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Monthly Sales in ' . $date->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the yearly report with stores sales.
     *
     * @param Carbon $date
     * @return array
     */
    private function generateAdminStoresSalesByYear($date)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $tableRow = [];
        $tempStart = $date->copy();
        $tempEnd = $date->copy();
        $tempEnd->endOfYear();

        array_push($tableRow, ['Store', 'Order Count', 'Order Sales(' . config('payment.currency_symbol') . ')']);

        $stores = Store::all();

        foreach ($stores as $store) {
            $productIds = $store->products()->pluck('id')->toArray();
            $count = OrderDetail::whereBetween('created_at', [$tempStart, $tempEnd])
                ->whereIn('product_id', $productIds)
                ->count();

            $sales = OrderDetail::whereBetween('created_at', [$tempStart, $tempEnd])
                ->whereIn('product_id', $productIds)
                ->sum('price');

            array_push($countData, $count);
            array_push($salesData, $sales);
            array_push($label, $store->name);
            array_push($tableRow, [$store->name, $count, $sales]);
        }

        $result = [
            'chart' => [
                'data' => [
                    'datasets' => [[
                        'type' => 'bar',
                        'label' => 'Order count',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => $countData,
                    ], [
                        'type' => 'bar',
                        'label' => 'Order Sales(' . config('payment.currency_symbol') . ')',
                        'backgroundColor' => 'rgb(11, 94, 215)',
                        'borderColor' => 'rgb(11, 94, 215)',
                        'data' => $salesData,
                    ]],
                    'labels' => $label,
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Sales Performance by Stores in ' . $date->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the yearly report with product categories sales.
     *
     * @param Carbon $date
     * @return array
     * @throws \Exception
     */
    private function generateAdminProductCategoriesSalesByYear($date)
    {
        $label = [];
        $countData = [];
        $backgroundColors = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfYear();

        array_push($tableRow, ['Product Category', 'Count']);

        $productCategories = ProductCategory::all();

        foreach ($productCategories as $category) {
            $count = OrderDetail::whereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count();

            array_push($label, $category->name);
            array_push($countData, $count);

            $color = 'rgb(' . random_int(0, 255) . ', ' . random_int(0, 255) . ', ' . random_int(0, 255) . ')';
            array_push($backgroundColors, $color);

            array_push($tableRow, [$category->name, $count]);
        }

        $result = [
            'chart' => [
                'type' => 'pie',
                'data' => [
                    'labels' => $label,
                    'datasets' => [
                        [
                            'label' => 'Product Category',
                            'data' => $countData,
                            'backgroundColor' => $backgroundColors,
                            'hoverOffset' => 4,
                        ],
                    ],
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Product Category Sales in ' . $date->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the yearly report with top products sales.
     *
     * @param Carbon $date
     * @return array|null
     */
    private function generateAdminTopProductsSalesByYear($date)
    {
        $label = [];
        $countData = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endDate = $date->copy();
        $endDate->endOfYear();

        if (Product::all()->count() <= 1) {
            return null;
        }

        array_push($tableRow, ['Product', 'Count']);

        $products = Product::withCount(['orderDetails as order_details_count' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->orderBy('order_details_count', 'desc')->take(5)->get();

        foreach ($products as $product) {
            array_push($label, $product->name);
            array_push($countData, $product->order_details_count);
            array_push($tableRow, [$product->name, $product->order_details_count]);
        }

        $result = [
            'chart' => [
                'type' => 'bar',
                'data' => [
                    'labels' => $label,
                    'datasets' => [[
                        'label' => 'Order Count',
                        'data' => $countData,
                        'backgroundColor' => 'rgb(11, 94, 215)',
                        'borderColor' => 'rgb(11, 94, 215)',
                    ]],
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Top ' . $products->count() . ' Products Sales in ' . $startDate->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the monthly report with product categories sales.
     *
     * @param Carbon $date
     * @return array
     * @throws \Exception
     */
    private function generateAdminProductCategoriesSalesByMonth($date)
    {
        $label = [];
        $countData = [];
        $backgroundColors = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfMonth();

        array_push($tableRow, ['Product Category', 'Count']);

        $productCategories = ProductCategory::all();

        foreach ($productCategories as $category) {
            $count = OrderDetail::whereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count();

            array_push($label, $category->name);
            array_push($countData, $count);

            $color = 'rgb(' . random_int(0, 255) . ', ' . random_int(0, 255) . ', ' . random_int(0, 255) . ')';
            array_push($backgroundColors, $color);

            array_push($tableRow, [$category->name, $count]);
        }

        $result = [
            'chart' => [
                'type' => 'pie',
                'data' => [
                    'labels' => $label,
                    'datasets' => [
                        [
                            'label' => 'Product Category',
                            'data' => $countData,
                            'backgroundColor' => $backgroundColors,
                            'hoverOffset' => 4,
                        ],
                    ],
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Product Category Sales in ' . $date->format('Y F'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the monthly report with stores sales.
     *
     * @param Carbon $date
     * @return array
     */
    private function generateAdminStoreSalesByMonth($date)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfMonth();

        $stores = Store::all();

        array_push($tableRow, ['Store', 'Order Count', 'Order Sales(' . config('payment.currency_symbol') . ')']);

        foreach ($stores as $store) {
            $productIds = $store->products()->pluck('id')->toArray();
            $count = OrderDetail::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('product_id', $productIds)
                ->count();

            $sales = OrderDetail::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('product_id', $productIds)
                ->sum('price');

            array_push($countData, $count);
            array_push($salesData, $sales);
            array_push($label, $store->name);

            array_push($tableRow, [$store->name, $count, $sales]);
        }

        $result = [
            'chart' => [
                'data' => [
                    'datasets' => [[
                        'type' => 'bar',
                        'label' => 'Order count',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => $countData,
                    ], [
                        'type' => 'bar',
                        'label' => 'Order Sales(' . config('payment.currency_symbol') . ')',
                        'backgroundColor' => 'rgb(11, 94, 215)',
                        'borderColor' => 'rgb(11, 94, 215)',
                        'data' => $salesData,
                    ]],
                    'labels' => $label,
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Sales Performance by Stores in ' . $date->format('Y F'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the monthly report with top products sales.
     *
     * @param $date
     * @return array|null
     */
    private function generateAdminTopProductsSalesByMonth($date)
    {
        $label = [];
        $countData = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endDate = $date->copy();
        $endDate->endOfMonth();

        if (Product::all()->count() <= 1) {
            return null;
        }

        array_push($tableRow, ['Product', 'Count']);

        $products = Product::withCount(['orderDetails as order_details_count' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->orderBy('order_details_count', 'desc')->take(5)->get();

        foreach ($products as $product) {
            array_push($label, $product->name);
            array_push($countData, $product->order_details_count);
            array_push($tableRow, [$product->name, $product->order_details_count]);
        }

        $result = [
            'chart' => [
                'type' => 'bar',
                'data' => [
                    'labels' => $label,
                    'datasets' => [[
                        'label' => 'Order Count',
                        'data' => $countData,
                        'backgroundColor' => 'rgb(11, 94, 215)',
                        'borderColor' => 'rgb(11, 94, 215)',
                    ]],
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Top ' . $products->count() . ' Products Sales in ' . $startDate->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the store's yearly report with monthly sales.
     *
     * @param Carbon $date
     * @param Store $store
     * @return array
     */
    private function generateFoodSellerMonthySalesByYear($date, $store)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $tableRow = [];
        $startDate = $date->copy();
        $productIds = $store->products()->pluck('id')->toArray();

        array_push($tableRow, ['Month', 'Order Count', 'Order Sales(' . config('payment.currency_symbol') . ')']);

        while ($startDate->month <= 12 && $startDate->year <= $date->year) {
            $endDate = $startDate->copy();
            $endDate->endOfMonth();
            array_push($label, $startDate->englishMonth);
            $count = Order::whereHas('orderDetails', function ($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
                ->whereBetween('created_at', [$startDate, $endDate])->count();

            $sales = Order::whereHas('orderDetails', function ($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
                ->whereBetween('created_at', [$startDate, $endDate])->sum('total_price');

            array_push($countData, $count);
            array_push($salesData, $sales);

            array_push($tableRow, [$startDate->englishMonth, $count, $sales]);

            $startDate->addMonth();
        }

        $result = [
            'chart' => [
                'data' => [
                    'datasets' => [[
                        'type' => 'line',
                        'label' => 'Order count',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => $countData,
                    ], [
                        'type' => 'line',
                        'label' => 'Order Sales(' . config('payment.currency_symbol') . ')',
                        'backgroundColor' => 'rgb(11, 94, 215)',
                        'borderColor' => 'rgb(11, 94, 215)',
                        'data' => $salesData,
                    ]],
                    'labels' => $label,
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Monthly Sales in ' . $date->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the store's yearly report with products sales.
     *
     * @param Carbon $date
     * @param Store $store
     * @return array
     * @throws \Exception
     */
    private function generateFoodSellerProductsSalesByYear($date, $store)
    {
        $label = [];
        $countData = [];
        $backgroundColors = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfYear();

        array_push($tableRow, ['Product', 'Count']);

        $products = $store->products;

        foreach ($products as $product) {
            $count = OrderDetail::whereBetween('created_at', [$startDate, $endDate])
                ->where('product_id', $product->id)
                ->count();

            array_push($label, $product->name);
            array_push($countData, $count);

            array_push($tableRow, [$product->name, $count]);

            $color = 'rgb(' . random_int(0, 255) . ', ' . random_int(0, 255) . ', ' . random_int(0, 255) . ')';
            array_push($backgroundColors, $color);
        }

        $result = [
            'chart' => [
                'type' => 'pie',
                'data' => [
                    'labels' => $label,
                    'datasets' => [
                        [
                            'label' => 'Product Category',
                            'data' => $countData,
                            'backgroundColor' => $backgroundColors,
                            'hoverOffset' => 4,
                        ],
                    ],
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Product Sales in ' . $date->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the store's monthly report with daily sales.
     *
     * @param Carbon $date
     * @param Store $store
     * @return array
     */
    private function generateFoodSellerDailySalesByMonth($date, $store)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endOfDate = $date->copy()->endOfMonth()->day;
        $productIds = $store->products()->pluck('id')->toArray();

        array_push($tableRow, ['Day', 'Order Count', 'Order Sales(' . config('payment.currency_symbol') . ')']);

        while ($startDate->day <= $endOfDate && $startDate->month <= $date->month) {
            $endDate = $startDate->copy();
            $endDate->endOfDay();
            array_push($label, $startDate->day);
            $count = Order::whereHas('orderDetails', function ($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
                ->whereBetween('created_at', [$startDate, $endDate])->count();

            $sales = Order::whereHas('orderDetails', function ($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
                ->whereBetween('created_at', [$startDate, $endDate])->sum('total_price');

            array_push($countData, $count);
            array_push($salesData, $sales);

            array_push($tableRow, [$startDate->day, $count, $sales]);

            $startDate->addDay();
        }

        array_push($label, 'Total');
        array_push($countData, array_sum($countData));
        array_push($salesData, array_sum($salesData));

        $result = [
            'chart' => [
                'data' => [
                    'datasets' => [[
                        'type' => 'line',
                        'label' => 'Order count',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => $countData,
                    ], [
                        'type' => 'line',
                        'label' => 'Order Sales(' . config('payment.currency_symbol') . ')',
                        'backgroundColor' => 'rgb(11, 94, 215)',
                        'borderColor' => 'rgb(11, 94, 215)',
                        'data' => $salesData,
                    ]],
                    'labels' => $label,
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Daily Sales in ' . $date->format('Y'),
                        ],
                    ],
                    'scales' => [
                        'x' => [
                            'ticks' => [
                                'autoSkip' => false,
                            ],
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

    /**
     * Get the store's monthly report with products sales.
     *
     * @param Carbon $date
     * @param Store $store
     * @return array
     * @throws \Exception
     */
    private function generateFoodSellerProductsSalesByMonth($date, $store)
    {
        $label = [];
        $countData = [];
        $backgroundColors = [];
        $tableRow = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfMonth();

        array_push($tableRow, ['Product', 'Count']);

        $products = $store->products;

        foreach ($products as $product) {
            $count = OrderDetail::whereBetween('created_at', [$startDate, $endDate])
                ->where('product_id', $product->id)
                ->count();

            array_push($label, $product->name);
            array_push($countData, $count);

            array_push($tableRow, [$product->name, $count]);

            $color = 'rgb(' . random_int(0, 255) . ', ' . random_int(0, 255) . ', ' . random_int(0, 255) . ')';
            array_push($backgroundColors, $color);
        }

        $result = [
            'chart' => [
                'type' => 'pie',
                'data' => [
                    'labels' => $label,
                    'datasets' => [
                        [
                            'label' => 'Product Category',
                            'data' => $countData,
                            'backgroundColor' => $backgroundColors,
                            'hoverOffset' => 4,
                        ],
                    ],
                ],
                'options' => [
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Product Sales in ' . $date->format('Y'),
                        ],
                    ],
                ],
            ],
            'table' => $tableRow,
        ];

        return $result;
    }

}
