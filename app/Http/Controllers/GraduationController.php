<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Graduation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GraduationStoreRequest;
use App\Http\Requests\GraduationUpdateRequest;

class GraduationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Graduation::class);

        $search = $request->get('search', '');

        $graduations = Graduation::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.graduations.index', compact('graduations', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Graduation::class);

        return view('app.graduations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GraduationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Graduation::class);

        $validated = $request->validated();

        $graduation = Graduation::create($validated);

        return redirect()
            ->route('graduations.edit', $graduation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Graduation $graduation): View
    {
        $this->authorize('view', $graduation);

        return view('app.graduations.show', compact('graduation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Graduation $graduation): View
    {
        $this->authorize('update', $graduation);

        return view('app.graduations.edit', compact('graduation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        GraduationUpdateRequest $request,
        Graduation $graduation
    ): RedirectResponse {
        $this->authorize('update', $graduation);

        $validated = $request->validated();

        $graduation->update($validated);

        return redirect()
            ->route('graduations.edit', $graduation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Graduation $graduation
    ): RedirectResponse {
        $this->authorize('delete', $graduation);

        $graduation->delete();

        return redirect()
            ->route('graduations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
