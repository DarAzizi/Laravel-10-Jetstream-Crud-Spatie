<?php

namespace App\Http\Controllers\Api;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UniversityResource;
use App\Http\Resources\UniversityCollection;
use App\Http\Requests\UniversityStoreRequest;
use App\Http\Requests\UniversityUpdateRequest;

class UniversityController extends Controller
{
    public function index(Request $request): UniversityCollection
    {
        $this->authorize('view-any', University::class);

        $search = $request->get('search', '');

        $universities = University::search($search)
            ->latest()
            ->paginate();

        return new UniversityCollection($universities);
    }

    public function store(UniversityStoreRequest $request): UniversityResource
    {
        $this->authorize('create', University::class);

        $validated = $request->validated();

        $university = University::create($validated);

        return new UniversityResource($university);
    }

    public function show(
        Request $request,
        University $university
    ): UniversityResource {
        $this->authorize('view', $university);

        return new UniversityResource($university);
    }

    public function update(
        UniversityUpdateRequest $request,
        University $university
    ): UniversityResource {
        $this->authorize('update', $university);

        $validated = $request->validated();

        $university->update($validated);

        return new UniversityResource($university);
    }

    public function destroy(Request $request, University $university): Response
    {
        $this->authorize('delete', $university);

        $university->delete();

        return response()->noContent();
    }
}
