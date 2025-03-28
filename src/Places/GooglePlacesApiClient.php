<?php

namespace GooglePlaces\Places;

use GooglePlaces\Config\GooglePlacesApiConfig;
use GooglePlaces\Places\Traits\newPlacesApi;
use GooglePlaces\Places\Traits\legacyPlacesApi;

class GooglePlacesApiClient
{
    use newPlacesApi, legacyPlacesApi;

    private $settings;

    /**
     * Constructor for the GooglePlacesApiClient class.
     *
     * Initializes the client with the provided configuration settings.
     *
     * @param GooglePlacesApiConfig $settings The configuration settings for the Google Places API client.
     */
    public function __construct(GooglePlacesApiConfig $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Finds a place using the legacy Google Places API.
     *
     * This method uses the legacy implementation to find a place based on the
     * provided input and input type. If the new Places API is being used, the
     * method will return NULL as it is not supported.
     *
     * @param string $input The input text to search for a place (e.g., name, address).
     * @param string $inputType The type of input provided (e.g., 'textquery', 'phonenumber').
     * @return mixed The search results from the legacy API, or NULL if the new API is used.
     */
    public function findPlace(string $input, string $inputType, array $fields = []): mixed
    {
        if ($this->settings->getversion() === 'Legacy') {
            return $this->legacyFindPlace($input, $inputType, $fields);
        }

        return NULL;
    }

    /**
     * Performs a text search for places using the Google Places API.
     *
     * This method searches for places based on a text query. It supports both
     * the legacy and new API implementations, depending on the version specified
     * in the settings. Additional parameters and field masks can be provided for
     * the new API implementation.
     *
     * @param string $query The search query string to look for places.
     * @param array $params (Optional) Additional parameters for the new API implementation.
     * @param string $fieldsMasks (Optional) A comma-separated list of field masks for the new API.
     *                             Defaults to 'places.displayName,places.formattedAddress,places.priceLevel'.
     * @return mixed The search results. The format depends on the API version and implementation.
     */
    public function textSearch(string $query, array $params = [], $fieldsMasks = 'places.displayName,places.formattedAddress,places.priceLevel'): mixed
    {
        // Implement the logic to search places using Google Places API
        switch ($this->settings->getversion()) {
            case 'Legacy':
                return $this->legacyTextSearch($query);
            
            default:
                return $this->newTextSearch($query, $params, $fieldsMasks);
        }
    }

    /**
     * Performs a nearby search for places using the Google Places API.
     *
     * This method searches for places near a specified geographic location
     * (latitude and longitude) within a given radius. Additional filters such
     * as keyword, type, included types, and excluded types can be applied.
     *
     * @param float $latitude The latitude of the location to search around.
     * @param float $longitude The longitude of the location to search around.
     * @param int $radius The radius (in meters) within which to search for places.
     * @param string|null $keyword A keyword to filter the search results.
     * @param string|null $type (Optional) A specific type of place to filter the results.
     * @param array $includedTypes (Optional) A list of place types to include in the search.
     * @param array $excludedTypes (Optional) A list of place types to exclude from the search.
     * @return mixed The search results from the Google Places API, or NULL if the version is unsupported.
     */
    public function nearbySearch(float $latitude, float $longitude, int $radius, ?string $keyword = NULL, ?string $type = NULL, array $includedTypes = [], array $excludedTypes = [], ?string $fieldsMasks='places.rating,places.id,places.displayName,places.formattedAddress'): mixed
    {
        // Implement the logic to search nearby places using Google Places API
        switch ($this->settings->getversion()) {
            case 'Legacy':
                $location = $latitude.','.$longitude;
                $params = [];
                $params['keyword'] = $keyword ?? $params['keyword'] ?? null;
                $params['type'] = $type ?? $params['type'] ?? null;
                $params['included_types'] = !empty($includedTypes) ? implode(',', $includedTypes) : null;
                $params['excluded_types'] = !empty($excludedTypes) ? implode(',', $excludedTypes) : null;
                return $this->legacyNearBySearch($location, $radius, $params);
            
            default:
                $params = [];
                $params['includedTypes'] = !empty($includedTypes) ? $includedTypes : null;
                $params['excludedTypes'] = !empty($excludedTypes) ? $excludedTypes : null;
                return $this->newNearbySearch($latitude, $longitude, $radius, $params, $fieldsMasks);
        }
    }

    
    /**
     * Retrieves the details of a place using the Google Places API.
     *
     * This method fetches information about a specific place based on the provided
     * place ID and requested fields. It supports different API versions, such as
     * the legacy version.
     *
     * @param string $placeId The unique identifier of the place to retrieve details for.
     * @param string $fields  A comma-separated list of fields to include in the response.
     *                        Defaults to 'address_components'.
     * @return mixed The place details retrieved from the Google Places API, or an empty array if no details are found.
     */
    public function getPlaceDetails(string $placeId, string $fields = 'address_components'): mixed
    {
        // Implement the logic to get place details using Google Places API
        switch ($this->settings->getversion()) {
            case 'Legacy':
                return $this->legacyGetPlaceDetails($placeId, $fields);
            
            default:
                return $this->newGetPlaceDetails($placeId, $fields);
        }
        return [];
    }

    protected function getSettings(): GooglePlacesApiConfig
    {
        return $this->settings;
    }
}