<?php

namespace Places\Traits;

use GooglePlacesApi\Config\Config;

trait LegacyPlacesApi
{
    abstract protected function getSettings(): Config;
    // Add your methods and properties here for the legacy Places API functionality.
    public function legacyTextSearch($query): array
    {
        // Implement the logic for the legacy text search here.
        // Example: return a placeholder response for now.
        return [];
    }
}