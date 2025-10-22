@extends('layouts.app')

@section('title', $kpi->name . ' - KPI Management System')
@section('page-title', $kpi->name)

@section('page-actions')
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('kpis.edit', $kpi) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-2"></i>Edit KPI
        </a>
        <a href="{{ route('kpis.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to KPIs
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- KPI Details -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">KPI Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Description</h6>
                        <p>{{ $kpi->description ?: 'No description provided.' }}</p>
                        
                        <h6>Category</h6>
                        <span class="badge" style="background-color: {{ $kpi->category->color }}">
                            {{ $kpi->category->name }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <h6>Measurement Details</h6>
                        <ul class="list-unstyled">
                            <li><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $kpi->measurement_type)) }}</li>
                            <li><strong>Unit:</strong> {{ $kpi->unit ?: 'N/A' }}</li>
                            <li><strong>Frequency:</strong> {{ ucfirst($kpi->frequency) }}</li>
                            <li><strong>Status:</strong> 
                                @if($kpi->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-4 text-center">
                        <h6>Current Value</h6>
                        <h4 class="text-primary">{{ $kpi->current_value ?? 'N/A' }} {{ $kpi->unit }}</h4>
                    </div>
                    <div class="col-md-4 text-center">
                        <h6>Target Value</h6>
                        <h4 class="text-info">{{ $kpi->target_value ?? 'N/A' }} {{ $kpi->unit }}</h4>
                    </div>
                    <div class="col-md-4 text-center">
                        <h6>Progress</h6>
                        @if($kpi->target_value && $kpi->current_value)
                            <h4 class="text-success">{{ round($kpi->progress_percentage, 1) }}%</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ min($kpi->progress_percentage, 100) }}%"
                                     aria-valuenow="{{ $kpi->progress_percentage }}" 
                                     aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        @else
                            <h4 class="text-muted">N/A</h4>
                        @endif
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Date Range</h6>
                        <p><strong>Start:</strong> {{ $kpi->start_date->format('M d, Y') }}</p>
                        @if($kpi->end_date)
                            <p><strong>End:</strong> {{ $kpi->end_date->format('M d, Y') }}</p>
                        @else
                            <p><strong>End:</strong> Ongoing</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Timeline</h6>
                        @if($kpi->end_date)
                            @php
                                $totalDays = $kpi->start_date->diffInDays($kpi->end_date);
                                $elapsedDays = $kpi->start_date->diffInDays(now());
                                $remainingDays = $kpi->end_date->diffInDays(now());
                            @endphp
                            <p><strong>Total Duration:</strong> {{ $totalDays }} days</p>
                            <p><strong>Elapsed:</strong> {{ $elapsedDays }} days</p>
                            <p><strong>Remaining:</strong> {{ max(0, $remainingDays) }} days</p>
                        @else
                            <p><strong>Duration:</strong> {{ $kpi->start_date->diffInDays(now()) }} days (ongoing)</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Add Data Form -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Data Point</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kpis.add-data', $kpi) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="value" class="form-label">Value <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror" 
                                   id="value" name="value" value="{{ old('value') }}" required>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="recorded_date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('recorded_date') is-invalid @enderror" 
                                   id="recorded_date" name="recorded_date" value="{{ old('recorded_date', now()->format('Y-m-d')) }}" required>
                            @error('recorded_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <input type="text" class="form-control @error('notes') is-invalid @enderror" 
                                   id="notes" name="notes" value="{{ old('notes') }}" placeholder="Optional notes">
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Data Point
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Data History -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data History</h6>
            </div>
            <div class="card-body">
                @if($kpiData->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Value</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kpiData->take(10) as $data)
                                <tr>
                                    <td>{{ $data->recorded_date->format('M d') }}</td>
                                    <td>{{ $data->value }}</td>
                                    <td>{{ $data->notes ? Str::limit($data->notes, 20) : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($kpiData->count() > 10)
                        <div class="text-center">
                            <small class="text-muted">Showing last 10 entries</small>
                        </div>
                    @endif
                @else
                    <p class="text-center text-muted">No data recorded yet.</p>
                @endif
            </div>
        </div>
        
        <!-- Performance Chart -->
        @if($kpiData->count() > 1)
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Performance Trend</h6>
            </div>
            <div class="card-body">
                <canvas id="performanceChart" height="200"></canvas>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
@if($kpiData->count() > 1)
<script>
const ctx = document.getElementById('performanceChart').getContext('2d');
const performanceChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($kpiData->reverse()->pluck('recorded_date')->map(function($date) { return \Carbon\Carbon::parse($date)->format('M d'); })) !!},
        datasets: [{
            label: '{{ $kpi->name }}',
            data: {!! json_encode($kpiData->reverse()->pluck('value')) !!},
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
</script>
@endif
@endsection
