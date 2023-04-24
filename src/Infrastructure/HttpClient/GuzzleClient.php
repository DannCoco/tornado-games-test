<?php

namespace App\Infrastructure\HttpClient;

use GuzzleHttp\Client;

class GuzzleClient
{
    public function get(string $baseUri, string $endPoint)
    {
        $client = new Client(['base_uri' => $baseUri]);

        $response = $client->request('GET', $endPoint);

        return json_decode($response->getBody(), true);
    }
}
