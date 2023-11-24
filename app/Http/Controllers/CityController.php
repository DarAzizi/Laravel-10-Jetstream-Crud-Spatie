<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', City::class);

        $search = $request->get('search', '');

        $cities = City::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.cities.index', compact('cities', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', City::class);

        return view('app.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', City::class);

        $validated = $request->validated();

        $city = City::create($validated);

        return redirect()
            ->route('cities.edit', $city)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, City $city): View
    {
        $this->authorize('view', $city);

        return view('app.cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, City $city): View
    {
        $this->authorize('update', $city);

        return view('app.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CityUpdateRequest $request,
        City $city
    ): RedirectResponse {
        $this->authorize('update', $city);

        $validated = $request->validated();

        $city->update($validated);

        return redirect()
            ->route('cities.edit', $city)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, City $city): RedirectResponse
    {
        $this->authorize('delete', $city);

        $city->delete();

        return redirect()
            ->route('cities.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
