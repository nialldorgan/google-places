<?php

namespace GooglePlaces\Places\Traits;

use GooglePlaces\Config\GooglePlacesApiConfig;
use GooglePlaces\Places\Traits\handleApiCalls;


trait legacyPlacesApi
{
    use handleApiCalls;

    abstract protected function getSettings(): GooglePlacesApiConfig;


    /**
     * Finds a place using the Google Places API's Find Place endpoint.
     *
     * This method sends a GET request to the Google Places API's Find Place endpoint
     * with the provided input and input type. It returns the decoded JSON response.
     *
     * @param string $input The text input to search for (e.g., a name, address, or phone number).
     * @param string $inputType The type of input provided. Must be one of 'textquery' or 'phonenumber'.
     * @param array $fields Optional fields to include in the response. Can be a comma-separated string or an array of field names.
     * @return mixed The decoded JSON response from the API, or null if the response cannot be decoded.
     */
    public function legacyFindPlace($input, $inputType, array $fields = []): mixed
    {
        $settings = $this->getSettings();
        $apiRoot = $settings->getBaseUrl();
        $url = $apiRoot . '/findplacefromtext/json';
        $params = [
            'input' => htmlspecialchars($input),
            'inputtype' => $inputType,
            'key' => $settings->getApiKey(),
        ];

        if (!empty($fields)) {
            $params['fields'] = is_array($fields) ? implode(',', $fields) : $fields;
        }

        $response = $this->makeApiCall('GET', $url, $params);
        return json_decode($response);
    }

    /**
     * Performs a legacy text search using the Google Places API.
     *
     * This method sends a GET request to the Google Places API's text search endpoint
     * with the provided query and API key. It returns the decoded JSON response.
     *
     * @param string $query The search query string to be used in the text search.
     * @return mixed The decoded JSON response from the API, or null if the response cannot be decoded.
     */
    public function legacyTextSearch($query): mixed
    {
        // Implement the logic for the legacy text search here.
        // Example: return a placeholder response for now.
        $settings = $this->getSettings();
        $apiRoot = $settings->getBaseUrl();
        $url = $apiRoot . '/textsearch/json';
        $params = ['query' => htmlspecialchars($query), 'key' => $settings->getApiKey()];
        $response = $this->makeApiCall('GET', $url, $params); 
        return json_decode($response);        
    }

    /**
     * Retrieves detailed information about a place using its unique place ID.
     *
     * This method interacts with the Google Places API to fetch details about a specific place.
     * The fields parameter allows specifying which details to include in the response.
     *
     * @param string $placeId The unique identifier of the place to retrieve details for.
     * @param string|array $fields The fields to include in the response. Can be a comma-separated string or an array of field names.
     * @return mixed The decoded JSON response from the API containing place details, or null on failure.
     */
    public function legacyGetPlaceDetails($placeId, $fields): mixed
    {
        // Implement the logic for retrieving a place by its ID.
        $settings = $this->getSettings();
        $apiRoot = $settings->getBaseUrl();
        $url = $apiRoot . '/details/json';
        $params = ['place_id' => htmlspecialchars($placeId), 'key' => $settings->getApiKey(), 'fields' => $fields];
        $response = $this->makeApiCall('GET', $url, $params);
        return json_decode($response);
    }

    /**
     * Performs a legacy nearby search using the Google Places API.
     *
     * This method sends a GET request to the Google Places API's nearby search endpoint
     * with the provided location, radius, and optional parameters. It returns the decoded JSON response.
     *
     * @param string $location The latitude and longitude of the location around which to search, formatted as "lat,lng".
     * @param int $radius The radius (in meters) within which to search for places.
     * @param array $optionalParams Optional parameters to refine the search (e.g., type, keyword, rankby).
     * @return mixed The decoded JSON response from the API, or null if the response cannot be decoded.
     */
    public function legacyNearBySearch($location, $radius, array $optionalParams = []): mixed
    {
        $settings = $this->getSettings();
        $apiRoot = $settings->getBaseUrl();
        $url = $apiRoot . '/nearbysearch/json';
        $params = array_merge(['location' => htmlspecialchars($location), 'radius' => $radius, 'key' => $settings->getApiKey()], $optionalParams);
        $response = $this->makeApiCall('GET', $url, $params);
        return json_decode($response);
    }
}