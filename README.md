# google-places
A wrapper for the Google places API
## API Overview

### Endpoints
- **Search Places**: Allows searching for places based on a query or location.
- **Place Details**: Retrieves detailed information about a specific place.
- **Nearby Search**: Finds places near a given location.
- **Text Search**: Searches for places using a text string.

### Usage
1. **Configuration**: Set up your API key in the configuration file.
2. **Initialization**: Use the provided wrapper class to initialize the API client.
3. **Making Requests**: Call the appropriate methods for the desired endpoint.

### Example
```php
use GooglePlaces\Config\GooglePlacesApiConfig;
use GooglePlaces\Places\GooglePlacesApiClient;

$config = new GooglePlacesApiConfig($apiKey, 'New'); // Use the passed API key
$client = new GooglePlacesApiClient($config);

// Search for places
$data = $client->textSearch($searchQuery, [], 'places.rating,places.id,places.displayName,places.formattedAddress');
print_r($data$);
```

### Error Handling
- Ensure proper error handling for invalid API keys or exceeded quotas.
- Check the response status for each API call.

### Additional Notes
- Refer to the inline comments in each file for detailed implementation guidance.
- Ensure compliance with Google's API usage policies.
