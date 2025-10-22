<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kpi;
use App\Models\KpiCategory;
use App\Models\KpiData;

class KpiController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kpis = Auth::user()->kpis()->with('category')->get();
        return view('kpis.index', compact('kpis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = KpiCategory::where('is_active', true)->get();
        return view('kpis.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'kpi_category_id' => 'required|exists:kpi_categories,id',
            'unit' => 'nullable|string|max:50',
            'measurement_type' => 'required|in:higher_is_better,lower_is_better,target_value',
            'target_value' => 'nullable|numeric',
            'current_value' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
        ]);

        $kpi = Auth::user()->kpis()->create($request->all());

        return redirect()->route('kpis.index')->with('success', 'KPI created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kpi $kpi)
    {
        // Check if user owns this KPI
        if (Auth::id() !== $kpi->user_id) {
            abort(403, 'Unauthorized access to this KPI.');
        }
        
        $kpiData = $kpi->kpiData()->orderBy('recorded_date', 'desc')->get();
        
        return view('kpis.show', compact('kpi', 'kpiData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kpi $kpi)
    {
        // Check if user owns this KPI
        if (Auth::id() !== $kpi->user_id) {
            abort(403, 'Unauthorized access to this KPI.');
        }
        
        $categories = KpiCategory::where('is_active', true)->get();
        return view('kpis.edit', compact('kpi', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kpi $kpi)
    {
        // Check if user owns this KPI
        if (Auth::id() !== $kpi->user_id) {
            abort(403, 'Unauthorized access to this KPI.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'kpi_category_id' => 'required|exists:kpi_categories,id',
            'unit' => 'nullable|string|max:50',
            'measurement_type' => 'required|in:higher_is_better,lower_is_better,target_value',
            'target_value' => 'nullable|numeric',
            'current_value' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'is_active' => 'boolean',
        ]);

        $kpi->update($request->all());

        return redirect()->route('kpis.index')->with('success', 'KPI updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kpi $kpi)
    {
        // Check if user owns this KPI
        if (Auth::id() !== $kpi->user_id) {
            abort(403, 'Unauthorized access to this KPI.');
        }
        
        $kpi->delete();

        return redirect()->route('kpis.index')->with('success', 'KPI deleted successfully!');
    }

    /**
     * Add data entry for a KPI
     */
    public function addData(Request $request, Kpi $kpi)
    {
        // Check if user owns this KPI
        if (Auth::id() !== $kpi->user_id) {
            abort(403, 'Unauthorized access to this KPI.');
        }
        
        $request->validate([
            'value' => 'required|numeric',
            'recorded_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $kpi->kpiData()->create([
            'user_id' => Auth::id(),
            'value' => $request->value,
            'recorded_date' => $request->recorded_date,
            'notes' => $request->notes,
        ]);

        // Update current value
        $kpi->update(['current_value' => $request->value]);

        return back()->with('success', 'Data added successfully!');
    }
}
