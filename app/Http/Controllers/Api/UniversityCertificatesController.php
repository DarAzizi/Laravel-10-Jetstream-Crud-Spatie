<?php

namespace App\Http\Controllers\Api;

use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\CertificateCollection;

class UniversityCertificatesController extends Controller
{
    public function index(
        Request $request,
        University $university
    ): CertificateCollection {
        $this->authorize('view', $university);

        $search = $request->get('search', '');

        $certificates = $university
            ->certificates()
            ->search($search)
            ->latest()
            ->paginate();

        return new CertificateCollection($certificates);
    }

    public function store(
        Request $request,
        University $university
    ): CertificateResource {
        $this->authorize('create', Certificate::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'year' => ['required', 'date'],
            'graduation_id' => ['required', 'exists:graduations,id'],
            'result_id' => ['required', 'exists:results,id'],
            'remark_id' => ['required', 'exists:remarks,id'],
            'image' => ['image', 'max:1024', 'nullable'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $certificate = $university->certificates()->create($validated);

        return new CertificateResource($certificate);
    }
}
