<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){

        $startDate = Order::orderBy('created_at', 'asc')->first()->created_at->firstOfMonth();
        $endDate = Order::orderBy('created_at', 'desc')->first()->created_at->firstOfMonth();

        $list = (object)[
            'monthly' => [],
            'yearly' => [],
        ];

        while($endDate->gte($startDate)){

            if($endDate->month == 1){
                $list->yearly['year:' . strval($endDate->getTimestamp())] = $endDate->format('Y');
            }

            $list->monthly['month:' . strval($endDate->getTimestamp())] = $endDate->format('Y F');
            $endDate->subMonth();
        }

        if($endDate->month !== 1){
            $list->yearly['year:' . strval($endDate->getTimestamp())] = $endDate->format('Y');
        }

        return view('admin.reports.index', compact('list'));
    }

    public function getData(Request $request){

        $request->validate([
            'report_date' => 'required',
        ]);

        $split = explode(':', $request->report_date);
        $reportDate = Carbon::createFromTimestamp($split[1]);

        if($split[0] === 'year'){
            $monthlySales = $this->generateMonthlySaleByYear($reportDate);

            return response()->json([
                'message' => 'success',
                'type' => 'year',
                'monthlySales' => $monthlySales,
            ]);
        } else {

            return response()->json([
                'message' => 'success',
                'type' => 'month',
        ]);
        }



    }

    private function generateMonthlySaleByYear($date) {
        $label = [];
        $countData = [];
        $salesData = [];
        $config = [];
        $tempStart = $date->copy();

        while($tempStart->month <= 12 && $tempStart->year <= $date->year){
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
                    'label' => 'Order Sales',
                    'backgroundColor' => 'rgb(11, 94, 215)',
                    'borderColor' => 'rgb(11, 94, 215)',
                    'data' => $salesData,
                ]],
                'labels' => $label,
            ],
        ];

        return $result;
    }
}
