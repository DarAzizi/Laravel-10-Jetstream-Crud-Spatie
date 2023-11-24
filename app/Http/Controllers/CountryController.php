<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Country::class);

        $search = $request->get('search', '');

        $countries = Country::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.countries.index', compact('countries', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Country::class);

        return view('app.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Country::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $country = Country::create($validated);

        return redirect()
            ->route('countries.edit', $country)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Country $country): View
    {
        $this->authorize('view', $country);

        return view('app.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Country $country): View
    {
        $this->authorize('update', $country);

        return view('app.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CountryUpdateRequest $request,
        Country $country
    ): RedirectResponse {
        $this->authorize('update', $country);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($country->image) {
                Storage::delete($country->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $country->update($validated);

        return redirect()
            ->route('countries.edit', $country)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Country $country
    ): RedirectResponse {
        $this->authorize('delete', $country);

        if ($country->image) {
            Storage::delete($country->image);
        }

        $country->delete();

        return redirect()
            ->route('countries.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
