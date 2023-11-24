<?php

namespace App\Http\Livewire\Selects;

use App\Models\City;
use Livewire\Component;
use App\Models\Country;
use Illuminate\View\View;
use App\Models\University;
use App\Models\Certificate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CountryIdCityIdUniversityIdDependentSelect extends Component
{
    use AuthorizesRequests;

    public $allCountries;
    public $allCities;
    public $allUniversities;

    public $selectedCountryId;
    public $selectedCityId;
    public $selectedUniversityId;

    protected $rules = [
        'selectedCountryId' => ['required', 'exists:countries,id'],
        'selectedCityId' => ['required', 'exists:cities,id'],
        'selectedUniversityId' => ['required', 'exists:universities,id'],
    ];

    public function mount($certificate): void
    {
        $this->clearData();
        $this->fillAllCountries();

        if (is_null($certificate)) {
            return;
        }

        $certificate = Certificate::findOrFail($certificate);

        $this->selectedCountryId = $certificate->country_id;

        $this->fillAllCities();
        $this->selectedCityId = $certificate->city_id;

        $this->fillAllUniversities();
        $this->selectedUniversityId = $certificate->university_id;
    }

    public function updatedSelectedCountryId(): void
    {
        $this->selectedCityId = null;
        $this->fillAllCities();
    }

    public function updatedSelectedCityId(): void
    {
        $this->selectedUniversityId = null;
        $this->fillAllUniversities();
    }

    public function fillAllCountries(): void
    {
        $this->allCountries = Country::all()->pluck('name', 'id');
    }

    public function fillAllCities(): void
    {
        if (!$this->selectedCountryId) {
            return;
        }

        $this->allCities = City::where('country_id', $this->selectedCountryId)
            ->get()
            ->pluck('name', 'id');
    }

    public function fillAllUniversities(): void
    {
        if (!$this->selectedCityId) {
            return;
        }

        $this->allUniversities = University::where(
            'city_id',
            $this->selectedCityId
        )
            ->get()
            ->pluck('name', 'id');
    }

    public function clearData(): void
    {
        $this->allCountries = null;
        $this->allCities = null;
        $this->allUniversities = null;

        $this->selectedCountryId = null;
        $this->selectedCityId = null;
        $this->selectedUniversityId = null;
    }

    public function render(): View
    {
        return view(
            'livewire.selects.country-id-city-id-university-id-dependent-select'
        );
    }
}
