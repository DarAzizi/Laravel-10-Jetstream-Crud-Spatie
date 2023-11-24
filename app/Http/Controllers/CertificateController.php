<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\City;
use App\Models\Result;
use App\Models\Remark;
use App\Models\Country;
use Illuminate\View\View;
use App\Models\University;
use App\Models\Graduation;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CertificateStoreRequest;
use App\Http\Requests\CertificateUpdateRequest;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Certificate::class);

        $search = $request->get('search', '');

        $certificates = Certificate::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.certificates.index',
            compact('certificates', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Certificate::class);

        $users = User::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $universities = University::pluck('name', 'id');
        $graduations = Graduation::pluck('name', 'id');
        $results = Result::pluck('name', 'id');
        $remarks = Remark::pluck('name', 'id');

        return view(
            'app.certificates.create',
            compact(
                'users',
                'countries',
                'cities',
                'universities',
                'graduations',
                'results',
                'remarks'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CertificateStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Certificate::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $certificate = Certificate::create($validated);

        return redirect()
            ->route('certificates.edit', $certificate)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Certificate $certificate): View
    {
        $this->authorize('view', $certificate);

        return view('app.certificates.show', compact('certificate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Certificate $certificate): View
    {
        $this->authorize('update', $certificate);

        $users = User::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $universities = University::pluck('name', 'id');
        $graduations = Graduation::pluck('name', 'id');
        $results = Result::pluck('name', 'id');
        $remarks = Remark::pluck('name', 'id');

        return view(
            'app.certificates.edit',
            compact(
                'certificate',
                'users',
                'countries',
                'cities',
                'universities',
                'graduations',
                'results',
                'remarks'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CertificateUpdateRequest $request,
        Certificate $certificate
    ): RedirectResponse {
        $this->authorize('update', $certificate);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::delete($certificate->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $certificate->update($validated);

        return redirect()
            ->route('certificates.edit', $certificate)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Certificate $certificate
    ): RedirectResponse {
        $this->authorize('delete', $certificate);

        if ($certificate->image) {
            Storage::delete($certificate->image);
        }

        $certificate->delete();

        return redirect()
            ->route('certificates.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
