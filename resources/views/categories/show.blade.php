@extends('layouts.app')

@section('title', $category->name . ' - KPI Management System')
@section('page-title', $category->name)

@section('page-actions')
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-2"></i>Edit Category
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Category Details -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Category Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Description</h6>
                        <p>{{ $category->description ?: 'No description provided.' }}</p>
                        
                        <h6>Color</h6>
                        <div class="d-flex align-items-center">
                            <div class="color-preview me-2" 
                                 style="width: 30px; height: 30px; background-color: {{ $category->color }}; border-radius: 50%;">
                            </div>
                            <span class="text-muted">{{ $category->color }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Status</h6>
                        <p>
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </p>
                        
                        <h6>Created</h6>
                        <p>{{ $category->created_at->format('M d, Y') }}</p>
                        
                        <h6>Last Updated</h6>
                        <p>{{ $category->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- KPIs in this Category -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">KPIs in this Category</h6>
            </div>
            <div class="card-body">
                @if($category->kpis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>KPI Name</th>
                                    <th>Current Value</th>
                                    <th>Target Value</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->kpis as $kpi)
                                <tr>
                                    <td>{{ $kpi->name }}</td>
                                    <td>{{ $kpi->current_value ?? 'N/A' }} {{ $kpi->unit }}</td>
                                    <td>{{ $kpi->target_value ?? 'N/A' }} {{ $kpi->unit }}</td>
                                    <td>
                                        @if($kpi->target_value && $kpi->current_value)
                                            <div class="progress" style="width: 100px; height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ min($kpi->progress_percentage, 100) }}%"
                                                     aria-valuenow="{{ $kpi->progress_percentage }}" 
                                                     aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($kpi->progress_percentage, 1) }}%
                                                </div>
                                            </div>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($kpi->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kpis.show', $kpi) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No KPIs in this category yet.</p>
                    <div class="text-center">
                        <a href="{{ route('kpis.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create KPI in this Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Category Statistics -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $category->kpis->count() }}</h4>
                            <small class="text-muted">Total KPIs</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success">{{ $category->kpis->where('is_active', true)->count() }}</h4>
                        <small class="text-muted">Active KPIs</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-info">{{ $category->kpis->where('current_value', '>=', 'target_value')->count() }}</h4>
                        <small class="text-muted">Completed</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning">{{ $category->kpis->where('current_value', '<', 'target_value')->count() }}</h4>
                        <small class="text-muted">In Progress</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('kpis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create KPI
                    </a>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i>Edit Category
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-2"></i>All Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
