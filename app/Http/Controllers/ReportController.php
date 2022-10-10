<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductCategory;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

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
    }

    public function getData(Request $request)
    {

        $request->validate([
            'report_date' => 'required',
        ]);

        $split = explode(':', $request->report_date);
        $reportDate = Carbon::createFromTimestamp($split[1]);

        if ($split[0] === 'year') {
            $monthlySales = $this->generateMonthlySaleByYear($reportDate);
            $storesSales = $this->generateStoresSalesByYear($reportDate);
            $productCategoriesSales = $this->generateProductCategoriesSalesByYear($reportDate);

            return response()->json([
                'message' => 'success',
                'type' => 'year',
                'monthlySales' => $monthlySales,
                'storesSales' => $storesSales,
                'productCategoriesSales' => $productCategoriesSales,
            ]);
        } else {
            $productCategoriesSales = $this->generateProductCategoriesSalesByMonth($reportDate);
            $storesSales = $this->generateStoreSalesByMonth($reportDate);

            return response()->json([
                'message' => 'success',
                'type' => 'month',
                'productCategoriesSales' => $productCategoriesSales,
                'storesSales' => $storesSales,
            ]);
        }
    }

    private function generateMonthlySaleByYear($date)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $tempStart = $date->copy();

        while ($tempStart->month <= 12 && $tempStart->year <= $date->year) {
            $tempEnd = $tempStart->copy();
            $tempEnd->endOfMonth();
            array_push($label, $tempStart->englishMonth);
            $count = \App\Models\Order::whereBetween('created_at', [$tempStart, $tempEnd])->count();
            $sales = \App\Models\Order::whereBetween('created_at', [$tempStart, $tempEnd])->sum('total_price');
            array_push($countData, $count);
            array_push($salesData, $sales);

            $tempStart->addMonth();
        }

        $result = [
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
                    ]
                ]
            ]
        ];

        return $result;
    }

    private function generateStoresSalesByYear($date)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $tempStart = $date->copy();
        $tempEnd = $date->copy();
        $tempEnd->endOfYear();

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
        }

        $result = [
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
                        'text' => 'Stores Sales in ' . $date->format('Y'),
                    ]
                ]
            ]
        ];

        return $result;
    }

    private function generateProductCategoriesSalesByYear($date)
    {
        $label = [];
        $countData = [];
        $backgroundColors = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfYear();

        $productCategories = ProductCategory::all();
    
        foreach($productCategories as $category){
            $count = OrderDetail::whereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count();

            array_push($label, $category->name);
            array_push($countData, $count);

            $color = 'rgb(' . random_int(0, 255) . ', ' . random_int(0, 255) . ', ' . random_int(0, 255) . ')';
            array_push($backgroundColors, $color);
        }

        $result = [
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
                    ]
                ]
            ]
        ];

        return $result;
    }

    private function generateProductCategoriesSalesByMonth($date)
    {
        $label = [];
        $countData = [];
        $backgroundColors = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfMonth();

        $productCategories = ProductCategory::all();

        foreach ($productCategories as $category) {
            $count = OrderDetail::whereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count();

            array_push($label, $category->name);
            array_push($countData, $count);

            $color = 'rgb(' . random_int(0, 255) . ', ' . random_int(0, 255) . ', ' . random_int(0, 255) . ')';
            array_push($backgroundColors, $color);
        }

        $result = [
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
                    ]
                ]
            ]
        ];

        return $result;
    }

    private function generateStoreSalesByMonth($date)
    {
        $label = [];
        $countData = [];
        $salesData = [];
        $startDate = $date->copy();
        $endDate = $startDate->copy();
        $endDate->endOfMonth();

        $stores = Store::all();

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
        }

        $result = [
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
                        'text' => 'Stores Sales in ' . $date->format('Y F'),
                    ]
                ]
            ]
        ];

        return $result;
    }
}
