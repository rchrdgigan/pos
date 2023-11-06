<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Charts\ReportChart;

class ReportChartController extends Controller
{
    public function index(){
        $inputFilter = request('filter');

                if($inputFilter == 'last_30_days'){

                    $endDate = Carbon::now();
                    $startDate = $endDate->copy()->subDays(29);
            
                    $days = [];
                    $salesCounts = [];
            
                    $currentDate = $startDate;
                    while ($currentDate <= $endDate) {
                        $formattedDate = $currentDate->format('Y-m-d');
                        
                        $totalSales = DB::table('transaction_sales')
                            ->whereDate('created_at', $formattedDate)
                            ->selectRaw('SUM(total_price) as total_sales')
                        ->value('total_sales') ?? 0;
            
                        $days[] = $currentDate->format('M d');
                        $salesCounts[] = $totalSales;
            
                        $currentDate->addDay();
                    }
            
                    $chart = new ReportChart;
                    $chart->dataset('Sales', 'bar', $salesCounts);
                    $chart->labels($days);

                }elseif($inputFilter == 'this_mo'){
                    $currentMonth = Carbon::now();

                    $totalSales = DB::table('transaction_sales')
                        ->whereYear('created_at', $currentMonth->year)
                        ->whereMonth('created_at', $currentMonth->month)
                        ->selectRaw('SUM(total_price) as total_sales')
                        ->value('total_sales') ?? 0;

                    $chart = new ReportChart;
                    $chart->dataset('Sales', 'bar', [$totalSales]);
                    $chart->labels([$currentMonth->format('M')]);

                }elseif($inputFilter == 'last_mo'){
                    $previousMonth = Carbon::now()->subMonth();

                    $totalSales = DB::table('transaction_sales')
                        ->whereYear('created_at', $previousMonth->year)
                        ->whereMonth('created_at', $previousMonth->month)
                        ->selectRaw('SUM(total_price) as total_sales')
                        ->value('total_sales') ?? 0;

                    $chart = new ReportChart;
                    $chart->dataset('Sales', 'bar', [$totalSales]);
                    $chart->labels([$previousMonth->format('M')]);

                }elseif($inputFilter == 'annual'){
                    $currentYear = Carbon::now()->format('Y');
                    $years = [];
                    $salesCounts = [];
                    
                    $numberOfYears = 5;
                    
                    for ($i = 0; $i < $numberOfYears; $i++) {
                        $year = $currentYear - $i;
                        
                        $totalSales = DB::table('transaction_sales')
                            ->whereYear('created_at', $year)
                            ->selectRaw('SUM(total_price) as total_sales')
                        ->value('total_sales') ?? 0;
                    
                        $years[] = $year;
                        $salesCounts[] = $totalSales;
                    }
                    
                    $chart = new ReportChart;
                    $chart->dataset('Sales', 'bar', $salesCounts);
                    $chart->labels($years);
                    
                }elseif($inputFilter == 'weekly'){
                    $endDate = Carbon::now();
                    $startDate = $endDate->copy()->subDays(7);
            
                    $days = [];
                    $salesCounts = [];
            
                    $currentDate = $startDate;
                    while ($currentDate <= $endDate) {
                        $formattedDate = $currentDate->format('Y-m-d');
                        
                        $totalSales = DB::table('transaction_sales')
                            ->whereDate('created_at', $formattedDate)
                            ->selectRaw('SUM(total_price) as total_sales')
                            ->value('total_sales') ?? 0;
            
                        $days[] = $currentDate->format('M d');
                        $salesCounts[] = $totalSales;
            
                        $currentDate->addDay();
                    }
            
                    $chart = new ReportChart;
                    $chart->dataset('Sales', 'bar', $salesCounts);
                    $chart->labels($days);
                }elseif($inputFilter == 'yesterday'){
                    $yesterday = Carbon::yesterday();

                    $totalSales = DB::table('transaction_sales')
                        ->whereDate('created_at', $yesterday->toDateString())
                        ->selectRaw('SUM(total_price) as total_sales')
                        ->value('total_sales') ?? 0;
                    
                    $chart = new ReportChart;
                    $chart->dataset('Sales', 'bar', [$totalSales]);
                    $chart->labels([$yesterday->format('M d, Y')]);
                }else{
                    $endDate = Carbon::now();
                    $startDate = $endDate->copy()->subDays(0);
            
                    $days = [];
                    $salesCounts = [];
            
                    $currentDate = $startDate;
                    while ($currentDate <= $endDate) {
                        $formattedDate = $currentDate->format('Y-m-d');
                        
                        $totalSales = DB::table('transaction_sales')
                            ->whereDate('created_at', $formattedDate)
                            ->selectRaw('SUM(total_price) as total_sales')
                            ->value('total_sales') ?? 0;
            
                        $days[] = $currentDate->format('M d');
                        $salesCounts[] = $totalSales;
            
                        $currentDate->addDay();
                    }
            
                    $chart = new ReportChart;
                    $chart->dataset('Sales', 'bar', $salesCounts);
                    $chart->labels($days);
                }
                return view('pages.report.index',[
                    'chart' => $chart,
                ]);
    }
}
