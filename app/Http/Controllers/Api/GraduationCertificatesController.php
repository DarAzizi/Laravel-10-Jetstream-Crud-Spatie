<?php

namespace App\Http\Controllers\Api;

use App\Models\Graduation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\CertificateCollection;

class GraduationCertificatesController extends Controller
{
    public function index(
        Request $request,
        Graduation $graduation
    ): CertificateCollection {
        $this->authorize('view', $graduation);

        $search = $request->get('search', '');

        $certificates = $graduation
            ->certificates()
            ->search($search)
            ->latest()
            ->paginate();

        return new CertificateCollection($certificates);
    }

    public function store(
        Request $request,
        Graduation $graduation
    ): CertificateResource {
        $this->authorize('create', Certificate::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'year' => ['required', 'date'],
            'university_id' => ['required', 'exists:universities,id'],
            'result_id' => ['required', 'exists:results,id'],
            'remark_id' => ['required', 'exists:remarks,id'],
            'image' => ['image', 'max:1024', 'nullable'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $certificate = $graduation->certificates()->create($validated);

        return new CertificateResource($certificate);
    }
}
