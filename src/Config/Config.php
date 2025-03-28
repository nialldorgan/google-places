<?php

namespace GooglePlacesApi\Config;

class Config
{
    private string $apiKey;
    private string $apiRoot;
    private string $version;
    private const BASE_URL = 'https://maps.googleapis.com/maps/api/place';
    private const NEW_PLACES_API_URL = 'https://places.googleapis.com/v1/places';

    public function getBaseUrl(): string
    {
        return self::BASE_URL;
    }

    public function getNewPlacesApiUrl(): string
    {
        return self::NEW_PLACES_API_URL;
    }

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

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}