<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kpi;
use App\Models\KpiData;
use App\Models\KpiCategory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get KPIs for the current user
        $kpis = $user->kpis()->with('category')->get();
        
        // Get recent KPI data entries
        $recentData = KpiData::where('user_id', $user->id)
            ->with('kpi')
            ->orderBy('recorded_date', 'desc')
            ->limit(10)
            ->get();
        
        // Get KPI statistics
        $totalKpis = $kpis->count();
        $activeKpis = $kpis->where('is_active', true)->count();
        $completedKpis = $kpis->where('current_value', '>=', 'target_value')->count();
        
        // Get chart data for the last 30 days
        $chartData = $this->getChartData($user);
        
        // Get category distribution
        $categoryStats = $this->getCategoryStats($user);
        
        return view('dashboard', compact(
            'kpis',
            'recentData',
            'totalKpis',
            'activeKpis',
            'completedKpis',
            'chartData',
            'categoryStats'
        ));
    }
    
    private function getChartData($user)
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        
        $data = KpiData::where('user_id', $user->id)
            ->whereBetween('recorded_date', [$startDate, $endDate])
            ->with('kpi')
            ->get()
            ->groupBy('recorded_date')
            ->map(function ($items) {
                return $items->sum('value');
            });
        
        return $data;
    }
    
    private function getCategoryStats($user)
    {
        return KpiCategory::withCount(['kpis' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();
    }
}
