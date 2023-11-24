<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\CertificateCollection;

class UserCertificatesController extends Controller
{
    public function index(Request $request, User $user): CertificateCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $certificates = $user
            ->certificates()
            ->search($search)
            ->latest()
            ->paginate();

        return new CertificateCollection($certificates);
    }

    public function store(Request $request, User $user): CertificateResource
    {
        $this->authorize('create', Certificate::class);

        $validated = $request->validate([
            'country_id' => ['required', 'exists:countries,id'],
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

        $certificate = $user->certificates()->create($validated);

        return new CertificateResource($certificate);
    }
}
