@extends('layouts.app')

@section('title', 'Categories - KPI Management System')
@section('page-title', 'KPI Categories')

@section('page-actions')
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Category
        </a>
    </div>
</div>
@endsection

@section('content')
@if($categories->count() > 0)
    <div class="row">
        @foreach($categories as $category)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <span class="badge" style="background-color: {{ $category->color }}">
                            <i class="fas fa-circle me-1"></i>
                        </span>
                    </div>
                    
                    @if($category->description)
                        <p class="card-text text-muted">{{ $category->description }}</p>
                    @endif
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <small class="text-muted">KPIs</small>
                            <div class="fw-bold">{{ $category->kpis_count ?? 0 }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Status</small>
                            <div>
                                @if($category->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this category? This will also delete all associated KPIs.')">
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
        <i class="fas fa-tags fa-4x text-muted mb-4"></i>
        <h4 class="text-muted">No Categories Found</h4>
        <p class="text-muted">Get started by creating your first category.</p>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Your First Category
        </a>
    </div>
@endif
@endsection
