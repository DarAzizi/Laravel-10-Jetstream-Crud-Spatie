<?php

namespace App\Http\Controllers\Api;

use App\Models\Graduation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GraduationResource;
use App\Http\Resources\GraduationCollection;
use App\Http\Requests\GraduationStoreRequest;
use App\Http\Requests\GraduationUpdateRequest;

class GraduationController extends Controller
{
    public function index(Request $request): GraduationCollection
    {
        $this->authorize('view-any', Graduation::class);

        $search = $request->get('search', '');

        $graduations = Graduation::search($search)
            ->latest()
            ->paginate();

        return new GraduationCollection($graduations);
    }

    public function store(GraduationStoreRequest $request): GraduationResource
    {
        $this->authorize('create', Graduation::class);

        $validated = $request->validated();

        $graduation = Graduation::create($validated);

        return new GraduationResource($graduation);
    }

    public function show(
        Request $request,
        Graduation $graduation
    ): GraduationResource {
        $this->authorize('view', $graduation);

        return new GraduationResource($graduation);
    }

    public function update(
        GraduationUpdateRequest $request,
        Graduation $graduation
    ): GraduationResource {
        $this->authorize('update', $graduation);

        $validated = $request->validated();

        $graduation->update($validated);

        return new GraduationResource($graduation);
    }

    public function destroy(Request $request, Graduation $graduation): Response
    {
        $this->authorize('delete', $graduation);

        $graduation->delete();

        return response()->noContent();
    }
}
