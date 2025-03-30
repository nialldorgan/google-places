<?php

use GooglePlaces\Places\GooglePlacesApiClient;
use GooglePlaces\Config\GooglePlacesApiConfig;
use PHPUnit\Framework\TestCase;

class LibraryUnitTest extends TestCase
{

    public function testFindPlace()
    {
        // Load API key from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_PLACES_API_KEY'];

        // Initialize the Google Places API client
        $config = new GooglePlacesApiConfig($apiKey);
        $client = new GooglePlacesApiClient($config);

        // Call the findPlace method and assert the result
        $response = $client->findPlace('Eiffel Tower', 'textquery');
        $this->assertEquals('OK', $response->status, 'The response status code should be OK.');
        $this->assertNotEmpty($response, 'The response should not be empty.');
    }

    public function testTextSearch()
    {
        // Load API key from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_PLACES_API_KEY'];

        // Initialize the Google Places API client
        $config = new GooglePlacesApiConfig($apiKey);
        $client = new GooglePlacesApiClient($config);

        // Call the textSearch method and assert the result
        $response = $client->textSearch('restaurants in Paris');
        $this->assertEquals('OK', $response->status, 'The response status code should be OK.');
        $this->assertNotEmpty($response->results, 'The response results should not be empty.');
        $this->assertGreaterThan(0, count($response->results), 'The response should contain at least one result.');
    }

    public function testNearbySearch()
    {
        // Load API key from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_PLACES_API_KEY'];

        // Initialize the Google Places API client
        $config = new GooglePlacesApiConfig($apiKey);
        $client = new GooglePlacesApiClient($config);

        // Call the nearbySearch method and assert the result
        $location = ['lat' => 48.858844, 'lng' => 2.294351]; // Coordinates for Eiffel Tower
        $radius = 1000; // 1 km radius
        $response = $client->nearbySearch($location['lat'], $location['lng'], $radius, 'pizza restaurants');

        $this->assertEquals('OK', $response->status, 'The response status code should be OK.');
        $this->assertNotEmpty($response->results, 'The response results should not be empty.');
        $this->assertGreaterThan(0, count($response->results), 'The response should contain at least one result.');
    }

    public function testTextSearchWithNewApi()
    {
        // Load API key from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_PLACES_API_KEY'];

        // Initialize the Google Places API client
        $config = new GooglePlacesApiConfig($apiKey, 'New');
        $client = new GooglePlacesApiClient($config);

        // Call the textSearch method using the new API and assert the result
        $query = 'museums in New York';
        $response = $client->textSearch($query, ['regionCode' => 'us']);
        $this->assertNotEmpty($response->places, 'The response results should not be empty.');
        $this->assertGreaterThan(0, count($response->places), 'The response should contain at least one result.');
        $this->assertNotEmpty($response->places[0]->displayName, 'Each result should have a displayName.');
    }

    public function testNearbySearchWithNewApi()
    {
        // Load API key from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_PLACES_API_KEY'];

        // Initialize the Google Places API client with the new API
        $config = new GooglePlacesApiConfig($apiKey, 'New');
        $client = new GooglePlacesApiClient($config);

        // Call the nearbySearch method using the new API and assert the result
        $location = ['lat' => 40.712776, 'lng' => -74.005974]; // Coordinates for New York City
        $radius = 1500; // 1.5 km radius
        $response = $client->nearbySearch($location['lat'], $location['lng'], $radius, NULL, NULL, ['regionCode' => 'us']);

        $this->assertNotEmpty($response->places, 'The response results should not be empty.');
        $this->assertGreaterThan(0, count($response->places), 'The response should contain at least one result.');
        $this->assertNotEmpty($response->places[0]->displayName, 'Each result should have a displayName.');
    }

    public function testGetPlaceDetailsWithLegacyApi()
    {
        // Load API key from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_PLACES_API_KEY'];

        // Initialize the Google Places API client with the legacy API
        $config = new GooglePlacesApiConfig($apiKey);
        $client = new GooglePlacesApiClient($config);

        // Call the getPlaceDetails method and assert the result
        $placeId = 'ChIJN1t_tDeuEmsRUsoyG83frY4'; // Example Place ID
        $response = $client->getPlaceDetails($placeId, 'address_components,name');

        $this->assertEquals('OK', $response->status, 'The response status code should be OK.');
        $this->assertNotEmpty($response->result, 'The response result should not be empty.');
        $this->assertNotEmpty($response->result->name, 'The place details should include a name.');
        $this->assertNotEmpty($response->result->address_components, 'The place details should include a address components.');
    }

    public function testGetPlaceDetailsWithNewApi()
    {
        // Load API key from .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_PLACES_API_KEY'];

        // Initialize the Google Places API client with the new API
        $config = new GooglePlacesApiConfig($apiKey, 'New');
        $client = new GooglePlacesApiClient($config);

        // Call the getPlaceDetails method using the new API and assert the result
        $placeId = 'ChIJN1t_tDeuEmsRUsoyG83frY4'; // Example Place ID
        $response = $client->getPlaceDetails($placeId, 'formattedAddress,displayName');
        $this->assertNotEmpty($response, 'The response result should not be empty.');
        $this->assertNotEmpty($response->displayName, 'The place details should include a displayName.');
        $this->assertNotEmpty($response->formattedAddress, 'The place details should include a formatted address.');
    }
}