<div class="w-full">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="country_id"
            label="Country"
            wire:model="selectedCountryId"
        >
            <option selected>Please select the Country</option>
            @foreach($allCountries as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @if(!empty($selectedCountryId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="city_id"
            label="City"
            wire:model="selectedCityId"
        >
            <option selected>Please select the City</option>
            @foreach($allCities as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif @if(!empty($selectedCityId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="university_id"
            label="University"
            wire:model="selectedUniversityId"
        >
            <option selected>Please select the University</option>
            @foreach($allUniversities as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
