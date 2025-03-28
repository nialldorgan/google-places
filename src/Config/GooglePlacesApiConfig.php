<?php

namespace GooglePlaces\Config;

class GooglePlacesApiConfig
{
    private string $apiKey;
    private string $apiRoot;
    private string $version;
    private const BASE_URL = 'https://maps.googleapis.com/maps/api/place';
    private const NEW_PLACES_API_URL = 'https://places.googleapis.com/v1/places';

    /**
     * Constructor for the GooglePlacesApiConfig class.
     *
     * Initializes the configuration with the provided API key and version.
     * Sets the API root URL based on the specified version.
     *
     * @param string $apiKey The API key used to authenticate requests to the Google Places API.
     * @param string $version The version of the API to use New or Legacy. Defaults to Legacy.
     */
    public function __construct(string $apiKey, $version = 'Legacy')
    {
        $this->apiKey = $apiKey;
        $this->version = $version;
        if ($version == 'Legacy')
        {
            $this->apiRoot = $this->getBaseUrl();
        } else {
            $this->apiRoot = $this->getNewPlacesApiUrl();
        }
    }

    /**
     * Retrieves the API key used for authenticating requests to the Google Places API.
     *
     * @return string The API key.
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
    
    /**
     * Retrieves the version of the Google Places API being used.
     *
     * @return string The API version.
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Retrieves the root URL for the Google Places API.
     *
     * @return string The API root URL.
     */
    public function getApiRoot(): string
    {
        return $this->apiRoot;
    }

    /**
     * Retrieves the base URL for the legacy Google Places API.
     *
     * @return string The base URL.
     */
    protected function getBaseUrl(): string
    {
        return self::BASE_URL;
    }

    /**
     * Retrieves the URL for the new Google Places API.
     *
     * @return string The new API URL.
     */
    protected function getNewPlacesApiUrl(): string
    {
        return self::NEW_PLACES_API_URL;
    }
}