<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filament\Pages\Reports\ProfitLossReport;

class TestController extends Controller
{
    public function testProfitLoss()
    {
        $report = new ProfitLossReport();
        $report->mount();
        
        return view('test-profit-loss', [
            'reportData' => $report->reportData
        ]);
    }
}
