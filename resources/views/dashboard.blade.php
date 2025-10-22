@extends('layouts.app')

@section('title', 'Dashboard - KPI Management System')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total KPIs
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKpis }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active KPIs
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeKpis }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Completed KPIs
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedKpis }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Completion Rate
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalKpis > 0 ? round(($completedKpis / $totalKpis) * 100, 1) : 0 }}%
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percentage fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- KPI Performance Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">KPI Performance (Last 30 Days)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="kpiChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">KPI Categories</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent KPI Data -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent KPI Data</h6>
            </div>
            <div class="card-body">
                @if($recentData->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>KPI Name</th>
                                    <th>Value</th>
                                    <th>Date</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentData as $data)
                                <tr>
                                    <td>{{ $data->kpi->name }}</td>
                                    <td>{{ $data->value }} {{ $data->kpi->unit }}</td>
                                    <td>{{ $data->recorded_date->format('M d, Y') }}</td>
                                    <td>{{ $data->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No recent data available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('kpis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New KPI
                    </a>
                    <a href="{{ route('kpis.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>View All KPIs
                    </a>
                    <a href="{{ route('categories.create') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-tag me-2"></i>Create Category
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KPI Cards -->
@if($kpis->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your KPIs</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($kpis->take(6) as $kpi)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card kpi-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title">{{ $kpi->name }}</h6>
                                    <span class="badge" style="background-color: {{ $kpi->category->color }}">
                                        {{ $kpi->category->name }}
                                    </span>
                                </div>
                                <p class="card-text text-muted small">{{ $kpi->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Current: {{ $kpi->current_value ?? 0 }} {{ $kpi->unit }}</small><br>
                                        <small class="text-muted">Target: {{ $kpi->target_value ?? 'N/A' }} {{ $kpi->unit }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if($kpi->target_value)
                                            <div class="progress" style="width: 60px; height: 8px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ min($kpi->progress_percentage, 100) }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ round($kpi->progress_percentage, 1) }}%</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('kpis.show', $kpi) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($kpis->count() > 6)
                <div class="text-center mt-3">
                    <a href="{{ route('kpis.index') }}" class="btn btn-outline-primary">
                        View All KPIs
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
// KPI Performance Chart
const ctx1 = document.getElementById('kpiChart').getContext('2d');
const kpiChart = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData->keys()->map(function($date) { return \Carbon\Carbon::parse($date)->format('M d'); })->values()) !!},
        datasets: [{
            label: 'KPI Values',
            data: {!! json_encode($chartData->values()) !!},
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Category Distribution Chart
const ctx2 = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($categoryStats->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($categoryStats->pluck('kpis_count')) !!},
            backgroundColor: {!! json_encode($categoryStats->pluck('color')) !!},
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection
