@extends('layouts.app')

@section('title', 'Edit ' . $kpi->name . ' - KPI Management System')
@section('page-title', 'Edit KPI: ' . $kpi->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('kpis.update', $kpi) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">KPI Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $kpi->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kpi_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('kpi_category_id') is-invalid @enderror" 
                                    id="kpi_category_id" name="kpi_category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('kpi_category_id', $kpi->kpi_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kpi_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $kpi->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="unit" class="form-label">Unit of Measurement</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" 
                                   id="unit" name="unit" value="{{ old('unit', $kpi->unit) }}" 
                                   placeholder="e.g., percentage, count, currency">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="measurement_type" class="form-label">Measurement Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('measurement_type') is-invalid @enderror" 
                                    id="measurement_type" name="measurement_type" required>
                                <option value="">Select type</option>
                                <option value="higher_is_better" {{ old('measurement_type', $kpi->measurement_type) == 'higher_is_better' ? 'selected' : '' }}>
                                    Higher is Better
                                </option>
                                <option value="lower_is_better" {{ old('measurement_type', $kpi->measurement_type) == 'lower_is_better' ? 'selected' : '' }}>
                                    Lower is Better
                                </option>
                                <option value="target_value" {{ old('measurement_type', $kpi->measurement_type) == 'target_value' ? 'selected' : '' }}>
                                    Target Value
                                </option>
                            </select>
                            @error('measurement_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="frequency" class="form-label">Frequency <span class="text-danger">*</span></label>
                            <select class="form-select @error('frequency') is-invalid @enderror" 
                                    id="frequency" name="frequency" required>
                                <option value="">Select frequency</option>
                                <option value="daily" {{ old('frequency', $kpi->frequency) == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ old('frequency', $kpi->frequency) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ old('frequency', $kpi->frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ old('frequency', $kpi->frequency) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="yearly" {{ old('frequency', $kpi->frequency) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                            @error('frequency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="target_value" class="form-label">Target Value</label>
                            <input type="number" step="0.01" class="form-control @error('target_value') is-invalid @enderror" 
                                   id="target_value" name="target_value" value="{{ old('target_value', $kpi->target_value) }}">
                            @error('target_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="current_value" class="form-label">Current Value</label>
                            <input type="number" step="0.01" class="form-control @error('current_value') is-invalid @enderror" 
                                   id="current_value" name="current_value" value="{{ old('current_value', $kpi->current_value) }}">
                            @error('current_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" value="{{ old('start_date', $kpi->start_date->format('Y-m-d')) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" value="{{ old('end_date', $kpi->end_date ? $kpi->end_date->format('Y-m-d') : '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $kpi->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active KPI
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kpis.show', $kpi) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update KPI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    // Update end date minimum when start date changes
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
    });
});
</script>
@endsection
