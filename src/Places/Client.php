<?php

namespace GooglePlacesApi\Places;

use GooglePlacesApi\Config\Config;
use Places\Traits\newPlacesApi;
use Places\Traits\LegacyPlacesApi;

class Client
{
    use newPlacesApi, LegacyPlacesApi;

    private $settings;

    public function __construct(Config $settings)
    {
        $this->settings = $settings;
    }    

    public function textSearch(string $query): array
    {
        // Implement the logic to search places using Google Places API
        switch ($this->settings->getversion()) {
            case 'Legacy':
                return $this->legacyTextSearch($query);
            
            default:
                return $this->newTextSearch($query);
        }
    }

    public function nearbySearch(float $latitude, float $longitude, int $radius, string $keyword = NULL, string $type = null, array $includedTypes = [], array $excludedTypes = []): array
    {
        // Implement the logic to search nearby places using Google Places API
        switch ($this->settings->getversion()) {
            case 'Legacy':
                # code...
                break;
            
            default:
                # code...
                break;
        }
        return [];
    }

    public function getPlaceDetails(string $placeId, string $apiKey): array
    {
        // Implement the logic to get place details using Google Places API
        switch ($this->settings->getversion()) {
            case 'Legacy':
                # code...
                break;
            
            default:
                # code...
                break;
        }
        return [];
    }

    protected function getSettings(): Config
    {
        return $this->settings;
    }
}