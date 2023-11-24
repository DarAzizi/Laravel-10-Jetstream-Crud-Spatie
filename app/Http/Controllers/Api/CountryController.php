<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CountryCollection;
use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;

class CountryController extends Controller
{
    public function index(Request $request): CountryCollection
    {
        $this->authorize('view-any', Country::class);

        $search = $request->get('search', '');

        $countries = Country::search($search)
            ->latest()
            ->paginate();

        return new CountryCollection($countries);
    }

    public function store(CountryStoreRequest $request): CountryResource
    {
        $this->authorize('create', Country::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $country = Country::create($validated);

        return new CountryResource($country);
    }

    public function show(Request $request, Country $country): CountryResource
    {
        $this->authorize('view', $country);

        return new CountryResource($country);
    }

    public function update(
        CountryUpdateRequest $request,
        Country $country
    ): CountryResource {
        $this->authorize('update', $country);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($country->image) {
                Storage::delete($country->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $country->update($validated);

        return new CountryResource($country);
    }

    public function destroy(Request $request, Country $country): Response
    {
        $this->authorize('delete', $country);

        if ($country->image) {
            Storage::delete($country->image);
        }

        $country->delete();

        return response()->noContent();
    }
}
