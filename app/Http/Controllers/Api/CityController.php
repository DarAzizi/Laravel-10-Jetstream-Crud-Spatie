<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CityResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;

class CityController extends Controller
{
    public function index(Request $request): CityCollection
    {
        $this->authorize('view-any', City::class);

        $search = $request->get('search', '');

        $cities = City::search($search)
            ->latest()
            ->paginate();

        return new CityCollection($cities);
    }

    public function store(CityStoreRequest $request): CityResource
    {
        $this->authorize('create', City::class);

        $validated = $request->validated();

        $city = City::create($validated);

        return new CityResource($city);
    }

    public function show(Request $request, City $city): CityResource
    {
        $this->authorize('view', $city);

        return new CityResource($city);
    }

    public function update(CityUpdateRequest $request, City $city): CityResource
    {
        $this->authorize('update', $city);

        $validated = $request->validated();

        $city->update($validated);

        return new CityResource($city);
    }

    public function destroy(Request $request, City $city): Response
    {
        $this->authorize('delete', $city);

        $city->delete();

        return response()->noContent();
    }
}
