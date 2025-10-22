@extends('layouts.app')

@section('title', 'KPIs - KPI Management System')
@section('page-title', 'Key Performance Indicators')

@section('page-actions')
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('kpis.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New KPI
        </a>
    </div>
</div>
@endsection

@section('content')
@if($kpis->count() > 0)
    <div class="row">
        @foreach($kpis as $kpi)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title">{{ $kpi->name }}</h5>
                        <span class="badge" style="background-color: {{ $kpi->category->color }}">
                            {{ $kpi->category->name }}
                        </span>
                    </div>
                    
                    @if($kpi->description)
                        <p class="card-text text-muted">{{ Str::limit($kpi->description, 100) }}</p>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Current Value</small>
                            <div class="fw-bold">{{ $kpi->current_value ?? 'N/A' }} {{ $kpi->unit }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Target Value</small>
                            <div class="fw-bold">{{ $kpi->target_value ?? 'N/A' }} {{ $kpi->unit }}</div>
                        </div>
                    </div>
                    
                    @if($kpi->target_value && $kpi->current_value)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progress</small>
                                <small class="text-muted">{{ round($kpi->progress_percentage, 1) }}%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ min($kpi->progress_percentage, 100) }}%"
                                     aria-valuenow="{{ $kpi->progress_percentage }}" 
                                     aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <small class="text-muted">Frequency</small>
                            <div class="fw-bold">{{ ucfirst($kpi->frequency) }}</div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted">Status</small>
                            <div>
                                @if($kpi->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted">Type</small>
                            <div class="fw-bold">{{ ucfirst(str_replace('_', ' ', $kpi->measurement_type)) }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('kpis.show', $kpi) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <a href="{{ route('kpis.edit', $kpi) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('kpis.destroy', $kpi) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this KPI?')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-chart-bar fa-4x text-muted mb-4"></i>
        <h4 class="text-muted">No KPIs Found</h4>
        <p class="text-muted">Get started by creating your first KPI.</p>
        <a href="{{ route('kpis.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Your First KPI
        </a>
    </div>
@endif
@endsection
