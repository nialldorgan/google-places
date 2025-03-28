<?php

namespace GooglePlaces\Places\Traits;

use GooglePlaces\Config\GooglePlacesApiConfig;
use GooglePlaces\Places\Traits\handleApiCalls;

trait newPlacesApi
{
    use handleApiCalls;

    abstract protected function getSettings(): GooglePlacesApiConfig;

    /**
     * Perform a text search using the New Places API.
     *
     * This function sends a text search query to the New Places API and retrieves
     * a list of places matching the query. The query can include keywords, addresses,
     * or place names. It also allows specifying field masks to control the data returned.
     *
     * @param string $query The search query string.
     * @param array $params Optional additional parameters for the API call.
     * @param string $fieldsMasks A comma-separated list of field masks to specify the data to be returned.
     * @return mixed The response from the API, typically containing a list of places.
     */
    public function newTextSearch(string $query, array $params = [], $fieldsMasks = 'places.displayName,places.formattedAddress,places.priceLevel'): mixed
    {
        // Get the API settings from the configuration
        $settings = $this->getSettings();

        // Build the API endpoint URL
        $url = $settings->getNewPlacesApiUrl() . ':searchText';

        // Merge the query and additional parameters
        $postData = array_merge(['textQuery' => $query], $params);
        $headers = [
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => $settings->getApiKey(),
            'X-Goog-FieldMask' => $fieldsMasks,
        ];
        // Make the API call using the handleApiCalls trait
        $response = $this->makeApiCall('POST', $url, NULL, $postData, $headers);

        // Return the API response
        return json_decode($response);
    }

    /**
     * Perform a nearby search using the New Places API.
     *
     * This function sends a nearby search query to the New Places API and retrieves
     * a list of places within a specified radius of a given location. It allows specifying
     * additional parameters such as keywords, types, and field masks to control the data returned.
     *
     * @param float $latitude The latitude of the location to search around.
     * @param float $longitude The longitude of the location to search around.
     * @param int $radius The radius (in meters) within which to search for places.
     * @param array $params Optional additional parameters for the API call.
     * @param string $fieldsMasks A comma-separated list of field masks to specify the data to be returned.
     * @return mixed The response from the API, typically containing a list of places.
     */
    public function newNearbySearch(float $latitude, float $longitude, int $radius, array $params = [], $fieldsMasks = 'places.displayName,places.formattedAddress,places.priceLevel'): mixed
    {
        // Get the API settings from the configuration
        $settings = $this->getSettings();

        // Build the API endpoint URL
        $url = $settings->getNewPlacesApiUrl() . ':searchNearby';

        // Merge the location, radius, and additional parameters
        $postData = array_merge([
            'locationRestriction' => [
                'circle' => [
                    'center' => ['latitude' => $latitude, 'longitude' => $longitude],
                    'radius' => $radius,
                ]
            ]
        ], $params);

        $headers = [
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => $settings->getApiKey(),
            'X-Goog-FieldMask' => $fieldsMasks,
        ];

        // Make the API call using the handleApiCalls trait
        $response = $this->makeApiCall('POST', $url, NULL, $postData, $headers);
        // Return the API response
        return json_decode($response);
    }

    /**
     * Retrieve detailed information about a specific place using the New Places API.
     *
     * This function sends a request to the New Places API to fetch detailed information
     * about a place identified by its unique place ID. It allows specifying field masks
     * to control the data returned.
     *
     * @param string $placeId The unique identifier of the place to retrieve details for.
     * @param string $fieldsMasks A comma-separated list of field masks to specify the data to be returned.
     * @return mixed The response from the API, typically containing detailed information about the place.
     */
    public function newGetPlaceDetails(string $placeId, $fieldsMasks = 'displayName,formattedAddress,rating,websiteUri,priceLevel,nationalPhoneNumber'): mixed
    {
        // Get the API settings from the configuration
        $settings = $this->getSettings();

        // Build the API endpoint URL
        $url = $settings->getNewPlacesApiUrl() . '/' . $placeId;


        $headers = [
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => $settings->getApiKey(),
            'X-Goog-FieldMask' => $fieldsMasks,
        ];

        // Make the API call using the handleApiCalls trait
        $response = $this->makeApiCall('GET', $url, NULL, NULL, $headers);
        // Return the API response
        return json_decode($response);
    }
}