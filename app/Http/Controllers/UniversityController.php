<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UniversityStoreRequest;
use App\Http\Requests\UniversityUpdateRequest;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', University::class);

        $search = $request->get('search', '');

        $universities = University::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.universities.index',
            compact('universities', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', University::class);

        return view('app.universities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UniversityStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', University::class);

        $validated = $request->validated();

        $university = University::create($validated);

        return redirect()
            ->route('universities.edit', $university)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, University $university): View
    {
        $this->authorize('view', $university);

        return view('app.universities.show', compact('university'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, University $university): View
    {
        $this->authorize('update', $university);

        return view('app.universities.edit', compact('university'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UniversityUpdateRequest $request,
        University $university
    ): RedirectResponse {
        $this->authorize('update', $university);

        $validated = $request->validated();

        $university->update($validated);

        return redirect()
            ->route('universities.edit', $university)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        University $university
    ): RedirectResponse {
        $this->authorize('delete', $university);

        $university->delete();

        return redirect()
            ->route('universities.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
