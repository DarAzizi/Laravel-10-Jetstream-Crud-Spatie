<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\CertificateCollection;
use App\Http\Requests\CertificateStoreRequest;
use App\Http\Requests\CertificateUpdateRequest;

class CertificateController extends Controller
{
    public function index(Request $request): CertificateCollection
    {
        $this->authorize('view-any', Certificate::class);

        $search = $request->get('search', '');

        $certificates = Certificate::search($search)
            ->latest()
            ->paginate();

        return new CertificateCollection($certificates);
    }

    public function store(CertificateStoreRequest $request): CertificateResource
    {
        $this->authorize('create', Certificate::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $certificate = Certificate::create($validated);

        return new CertificateResource($certificate);
    }

    public function show(
        Request $request,
        Certificate $certificate
    ): CertificateResource {
        $this->authorize('view', $certificate);

        return new CertificateResource($certificate);
    }

    public function update(
        CertificateUpdateRequest $request,
        Certificate $certificate
    ): CertificateResource {
        $this->authorize('update', $certificate);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::delete($certificate->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $certificate->update($validated);

        return new CertificateResource($certificate);
    }

    public function destroy(
        Request $request,
        Certificate $certificate
    ): Response {
        $this->authorize('delete', $certificate);

        if ($certificate->image) {
            Storage::delete($certificate->image);
        }

        $certificate->delete();

        return response()->noContent();
    }
}
