<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class LocationHelpers
{
  // Function to check URL response
  public function checkUrlResponse($url)
  {
    // Call the makeHttpRequest function within the same class
    $response = $this->makeHttpRequest($url);

    if ($response['success']) {
      echo "Request successful:\n";
      print_r($response['data']);
    } else {
      echo "Request failed: " . $response['message'] . "\n";
    }
  }

  // Function to make HTTP request using Illuminate\Support\Facades\Http
  private function makeHttpRequest($url)
  {
    try {
      $response = \Illuminate\Support\Facades\Http::timeout(30)->get($url);

      if ($response->successful()) {
        return [
          'success' => true,
          'message' => 'Success',
          'data' => $response->json(),
        ];
      } else {
        return [
          'success' => false,
          'message' => 'HTTP Error: ' . $response->status(),
          'data' => $response->body(),
        ];
      }
    } catch (\Illuminate\Http\Client\RequestException $e) {
      return [
        'success' => false,
        'message' => 'Request Error: ' . $e->getMessage(),
      ];
    } catch (\Exception $e) {
      return [
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage(),
      ];
    }
  }
}
