<?php

namespace GooglePlaces\Places\Traits;
use GuzzleHttp;
use JsonException;

trait handleApiCalls
{
    // Add your methods and logic here

    public function makeApiCall($method, $url, $getParams = null, $postData = null, $headers = null)
    {
        $client = new GuzzleHttp\Client();

        $options = [];
        if (!empty($getParams)) {
            $options['query'] = $getParams;
        }
        if (!empty($postData)) {
            $options['json'] = $postData;
        }
        if (!empty($headers)) {
            $options['headers'] = $headers;
        }

        try {
            $response = $client->request($method, $url, $options);
            return $response->getBody()->getContents();
        } catch (GuzzleHttp\Exception\RequestException $e) {
            return $e->getMessage();
        }
    }
}