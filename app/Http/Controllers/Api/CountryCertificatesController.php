<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\CertificateCollection;

class CountryCertificatesController extends Controller
{
    public function index(
        Request $request,
        Country $country
    ): CertificateCollection {
        $this->authorize('view', $country);

        $search = $request->get('search', '');

        $certificates = $country
            ->certificates()
            ->search($search)
            ->latest()
            ->paginate();

        return new CertificateCollection($certificates);
    }

    public function store(
        Request $request,
        Country $country
    ): CertificateResource {
        $this->authorize('create', Certificate::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'year' => ['required', 'date'],
            'university_id' => ['required', 'exists:universities,id'],
            'graduation_id' => ['required', 'exists:graduations,id'],
            'result_id' => ['required', 'exists:results,id'],
            'remark_id' => ['required', 'exists:remarks,id'],
            'image' => ['image', 'max:1024', 'nullable'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $certificate = $country->certificates()->create($validated);

        return new CertificateResource($certificate);
    }
}
