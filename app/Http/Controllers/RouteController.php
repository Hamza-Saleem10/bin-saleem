<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $routes = Route::query();
            return DataTables::of($routes)

                ->addColumn('is_active', function ($route) {
                    return getStatusBadge($route->is_active);
                })
                ->addColumn('action', function ($route) {
                    $actions = '<div class="overlay-edit d-flex">';

                    if (auth()->user()->can('Update Routes')) {
                        $actions .= '<a href="' . route('routes.edit', $route->uuid) . '" class="btn btn-icon btn-secondary me-1" title="Edit"><i class="feather icon-edit-2"></i></a>';
                    }
                    if (auth()->user()->can('Update Routes Status')) {
                        $actions .= '<a href="' . route('routes.updateStatus', $route->uuid) . '" class="btn btn-icon ' . ($route->is_active == 1 ? 'btn-danger' : 'btn-success') . ' btn-status me-1">' . '<i class="feather ' . ($route->is_active == 1 ? 'icon-eye-off' : 'icon-eye') . '"></i></a>';
                    }
                    if (auth()->user()->can('Delete Routes')) {
                        $actions .= '<a href="' . route('routes.destroy', $route->uuid) . '" class="btn btn-icon btn-danger btn-delete" title="Delete"><i class="feather icon-trash-2"></i></a>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }
        return view('routes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('routes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
        ]);

        // Ensure from and to are not the same
        if ($validated['from_location'] === $validated['to_location']) {
            return back()->withErrors(['to_location' => 'From and To locations cannot be the same'])->withInput();
        }

        // Check for duplicate route (same from and to)
        $existingRoute = Route::where('from_location', $validated['from_location'])
            ->where('to_location', $validated['to_location'])
            ->first();

        if ($existingRoute) {
            return back()->withErrors(['to_location' => 'This route already exists'])->withInput();
        }

        Route::create($validated);

        return redirect()->route('routes.index')
            ->with('success', 'Route created successfully.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Route $route)
    // {
    //     return view('routes.show', get_defined_vars());
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        return view('routes.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
        ]);

        // Ensure from and to are not the same
        if ($validated['from_location'] === $validated['to_location']) {
            return back()->withErrors(['to_location' => 'From and To locations cannot be the same'])->withInput();
        }

        // Check for duplicate route (same from and to, excluding current route)
        $existingRoute = Route::where('from_location', $validated['from_location'])
            ->where('to_location', $validated['to_location'])
            ->where('id', '!=', $route->id)
            ->first();

        if ($existingRoute) {
            return back()->withErrors(['to_location' => 'This route already exists'])->withInput();
        }

        $route->update($validated);

        return redirect()->route('routes.index')
            ->with('success', 'Route updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('routes.index')
            ->with('success', 'Route deleted successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Route $route
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Route $route) {

        if($route) {

            $route->is_active = !$route->is_active;
            $route->save();

            return $this->sendResponse(true, __('messages.route_updated'));
        }

        return $this->sendResponse(false, __('messages.route_not_found'), [], 404);
    }

}