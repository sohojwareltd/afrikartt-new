<?php

namespace App\Data\Country;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CountryStateCity
{

    private $data;

    public function __construct()
    {
        $this->data = Cache::remember('country_state_city_data', 3600, function () {
            $path = public_path('json/countries_states_cities.json');
            if (!$path || !File::exists($path)) {
                Log::warning('countries_states_cities.json not found at expected path', ['path' => $path]);
                return new Collection([]);
            }

            try {
                $json = File::get($path);
            } catch (\Throwable $e) {
                Log::error('Failed to read countries_states_cities.json', ['error' => $e->getMessage()]);
                return new Collection([]);
            }

            $decoded = json_decode($json, true);
            if (!is_array($decoded)) {
                Log::error('Invalid JSON format in countries_states_cities.json');
                return new Collection([]);
            }

            return new Collection($decoded);
        });
    }

    public function countryDetails($country)
    {
        return Cache::remember("country_state_city:country_details:{$country}", 3600, function () use ($country) {
            return $this->data->where('id', $country)->first();
        });
    }
    public function stateDetails($country, $state)
    {
        return Cache::remember("country_state_city:state_details:{$country}:{$state}", 3600, function () use ($country, $state) {
            $countryRow = $this->data->firstWhere('id', (int) $country);
            if (!$countryRow) return null;
            $states = new Collection($countryRow['states'] ?? []);
            return $states->firstWhere('id', (int) $state);
        });
    }
    
    public function cityDetails($country, $state, $city)
    {
        return Cache::remember("country_state_city:city_details:{$country}:{$state}:{$city}", 3600, function () use ($country, $state, $city) {
            $countryRow = $this->data->firstWhere('id', (int) $country);
            if (!$countryRow) return null;
            $states = new Collection($countryRow['states'] ?? []);
            $stateRow = $states->firstWhere('id', (int) $state);
            if (!$stateRow) return null;
            $cities = new Collection($stateRow['cities'] ?? []);
            return $cities->firstWhere('id', (int) $city);
        });
    }

    public function countries()
    {
        return Cache::remember('country_state_city:countries', 3600, function () {
            return $this->data->pluck('name', 'id');
        });
    }

    public function states($country)
    {
        return Cache::remember("country_state_city:states:{$country}", 3600, function () use ($country) {
            $states = new Collection($this->data->where('id', $country)->pluck('states')->first());
            return $states->pluck('name', 'id');
        });
    }

    public function cities($country, $state)
    {
        return Cache::remember("country_state_city:cities:{$country}:{$state}", 3600, function () use ($country, $state) {
            $states = new Collection($this->data->where('id', $country)->pluck('states')->first());
            $cities = new Collection($states->where('id', $state)->pluck('cities')->first());
            return $cities->pluck('name', 'id');
        });
    }

    /**
     * Flexible country finder by id, name, or code (iso2/iso3/code)
     */
    public function findCountry($needle)
    {
        return Cache::remember("country_state_city:find_country:" . md5((string)$needle), 3600, function () use ($needle) {
            // Direct ID match
            if (is_numeric($needle)) {
                $row = $this->data->firstWhere('id', (int) $needle);
                if ($row) return $row;
            }

            $q = strtolower(trim((string) $needle));
            return $this->data->first(function ($row) use ($q) {
                $name = strtolower((string)($row['name'] ?? ''));
                $iso2 = strtolower((string)($row['iso2'] ?? $row['code'] ?? ''));
                $iso3 = strtolower((string)($row['iso3'] ?? ''));
                return $q === $name || $q === $iso2 || $q === $iso3;
            });
        });
    }

    /**
     * Search countries by name substring, returns [id => name]
     */
    public function searchCountries(string $query)
    {
        $q = strtolower(trim($query));
        if ($q === '') return collect();
        return $this->data
            ->filter(function ($row) use ($q) {
                return str_contains(strtolower((string)($row['name'] ?? '')), $q);
            })
            ->pluck('name', 'id');
    }

    /**
     * Flexible state finder by country (id/name/code) and state (id/name/code)
     */
    public function findState($country, $state)
    {
        $countryRow = $this->findCountry($country);
        if (!$countryRow) return null;
        $states = new Collection($countryRow['states'] ?? []);

        // Direct ID
        if (is_numeric($state)) {
            $st = $states->firstWhere('id', (int)$state);
            if ($st) return $st;
        }

        $q = strtolower(trim((string)$state));
        return $states->first(function ($row) use ($q) {
            $name = strtolower((string)($row['name'] ?? ''));
            $code = strtolower((string)($row['code'] ?? $row['iso2'] ?? ''));
            return $q === $name || $q === $code;
        });
    }

    /**
     * Search states within a country by name substring, returns [id => name]
     */
    public function searchStates($country, string $query)
    {
        $countryRow = $this->findCountry($country);
        if (!$countryRow) return collect();
        $states = new Collection($countryRow['states'] ?? []);
        $q = strtolower(trim($query));
        if ($q === '') return collect();
        return $states->filter(function ($row) use ($q) {
                return str_contains(strtolower((string)($row['name'] ?? '')), $q);
            })
            ->pluck('name', 'id');
    }
}
