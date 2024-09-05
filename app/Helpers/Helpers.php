<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class Helpers
{

  public static function appClasses()
  {

    $data = config('custom.custom');


    // default data array
    $DefaultData = [
      'myLayout' => 'vertical',
      'myTheme' => 'theme-default',
      'myStyle' => 'light',
      'myRTLSupport' => true,
      'myRTLMode' => true,
      'hasCustomizer' => true,
      'showDropdownOnHover' => true,
      'displayCustomizer' => true,
      'contentLayout' => 'compact',
      'headerType' => 'fixed',
      'navbarType' => 'fixed',
      'menuFixed' => true,
      'menuCollapsed' => false,
      'footerFixed' => false,
      'customizerControls' => [
        'rtl',
        'style',
        'headerType',
        'contentLayout',
        'layoutCollapsed',
        'showDropdownOnHover',
        'layoutNavbarOptions',
        'themes',
      ],
      //   'defaultLanguage'=>'en',
    ];

    // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
    $data = array_merge($DefaultData, $data);

    // All options available in the template
    $allOptions = [
      'myLayout' => ['vertical', 'horizontal', 'blank', 'front'],
      'menuCollapsed' => [true, false],
      'hasCustomizer' => [true, false],
      'showDropdownOnHover' => [true, false],
      'displayCustomizer' => [true, false],
      'contentLayout' => ['compact', 'wide'],
      'headerType' => ['fixed', 'static'],
      'navbarType' => ['fixed', 'static', 'hidden'],
      'myStyle' => ['light', 'dark', 'system'],
      'myTheme' => ['theme-default', 'theme-bordered', 'theme-semi-dark'],
      'myRTLSupport' => [true, false],
      'myRTLMode' => [true, false],
      'menuFixed' => [true, false],
      'footerFixed' => [true, false],
      'customizerControls' => [],
      // 'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','ar'=>'ar'),
    ];

    //if myLayout value empty or not match with default options in custom.php config file then set a default value
    foreach ($allOptions as $key => $value) {
      if (array_key_exists($key, $DefaultData)) {
        if (gettype($DefaultData[$key]) === gettype($data[$key])) {
          // data key should be string
          if (is_string($data[$key])) {
            // data key should not be empty
            if (isset($data[$key]) && $data[$key] !== null) {
              // data key should not be exist inside allOptions array's sub array
              if (!array_key_exists($data[$key], $value)) {
                // ensure that passed value should be match with any of allOptions array value
                $result = array_search($data[$key], $value, 'strict');
                if (empty($result) && $result !== 0) {
                  $data[$key] = $DefaultData[$key];
                }
              }
            } else {
              // if data key not set or
              $data[$key] = $DefaultData[$key];
            }
          }
        } else {
          $data[$key] = $DefaultData[$key];
        }
      }
    }
    $styleVal = $data['myStyle'] == "dark" ? "dark" : "light";
    $styleUpdatedVal = $data['myStyle'] == "dark" ? "dark" : $data['myStyle'];
    // Determine if the layout is admin or front based on cookies
    $layoutName = $data['myLayout'];
    $isAdmin = Str::contains($layoutName, 'front') ? false : true;

    $modeCookieName = $isAdmin ? 'admin-mode' : 'front-mode';
    $colorPrefCookieName = $isAdmin ? 'admin-colorPref' : 'front-colorPref';

    // Determine style based on cookies, only if not 'blank-layout'
    if ($layoutName !== 'blank') {
      if (isset($_COOKIE[$modeCookieName])) {
        $styleVal = $_COOKIE[$modeCookieName];
        if ($styleVal === 'system') {
          $styleVal = isset($_COOKIE[$colorPrefCookieName]) ? $_COOKIE[$colorPrefCookieName] : 'light';
        }
        $styleUpdatedVal = $_COOKIE[$modeCookieName];
      }
    }

    isset($_COOKIE['theme']) ? $themeVal = $_COOKIE['theme'] : $themeVal = $data['myTheme'];

    $directionVal = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : $data['myRTLMode'];

    //layout classes
    $layoutClasses = [
      'layout' => $data['myLayout'],
      'theme' => $themeVal,
      'themeOpt' => $data['myTheme'],
      'style' => $styleVal,
      'styleOpt' => $data['myStyle'],
      'styleOptVal' => $styleUpdatedVal,
      'rtlSupport' => $data['myRTLSupport'],
      'rtlMode' => $data['myRTLMode'],
      'textDirection' => $directionVal, //$data['myRTLMode'],
      'menuCollapsed' => $data['menuCollapsed'],
      'hasCustomizer' => $data['hasCustomizer'],
      'showDropdownOnHover' => $data['showDropdownOnHover'],
      'displayCustomizer' => $data['displayCustomizer'],
      'contentLayout' => $data['contentLayout'],
      'headerType' => $data['headerType'],
      'navbarType' => $data['navbarType'],
      'menuFixed' => $data['menuFixed'],
      'footerFixed' => $data['footerFixed'],
      'customizerControls' => $data['customizerControls'],
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
      $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Header Type
    if ($layoutClasses['headerType'] == 'fixed') {
      $layoutClasses['headerType'] = 'layout-menu-fixed';
    }
    // Navbar Type
    if ($layoutClasses['navbarType'] == 'fixed') {
      $layoutClasses['navbarType'] = 'layout-navbar-fixed';
    } elseif ($layoutClasses['navbarType'] == 'static') {
      $layoutClasses['navbarType'] = '';
    } else {
      $layoutClasses['navbarType'] = 'layout-navbar-hidden';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
      $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }


    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
      $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
      $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
      $layoutClasses['rtlMode'] = 'rtl';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : 'rtl';
    } else {
      $layoutClasses['rtlMode'] = 'ltr';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) && $_COOKIE['direction'] === "true" ? 'rtl' : 'ltr';
    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
      $layoutClasses['showDropdownOnHover'] = true;
    } else {
      $layoutClasses['showDropdownOnHover'] = false;
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
      $layoutClasses['displayCustomizer'] = true;
    } else {
      $layoutClasses['displayCustomizer'] = false;
    }

    return $layoutClasses;
  }

  public static function updatePageConfig($pageConfigs)
  {
    $demo = 'custom';
    if (isset($pageConfigs)) {
      if (count($pageConfigs) > 0) {
        foreach ($pageConfigs as $config => $val) {
          Config::set('custom.' . $demo . '.' . $config, $val);
        }
      }
    }
  }

  // public static function getLonLag($address)
  // {

  //   // Usage example
  //   // $url = "https://nominatim.openstreetmap.org/search?q=32%20Fleming%20Avenue%20Port%20Harcourt%20&format=json";

  //   $url = 'https://nominatim.openstreetmap.org/search?q=' . $address . '&format=json'; // GPS link
  //   $gpLoc = new LocationHelpers();
  //   $jsonData = $gpLoc->checkUrlResponse($url);
  //   //  $this->checkUrlResponse($url);
  //   // return $url;

  //   // Fetch JSON data from URL

  //   if ($jsonData->successful()) {
  //     // Get the JSON data and decode it to an array
  //     $data = $jsonData->json();
  //     if ($data instanceof \Illuminate\Http\JsonResponse) {
  //       $data = $data->getData(true); // Convert JsonResponse to array
  //       // Now you can access $data as an array

  //     }
  //     // return $data;
  //     if (count($data) === 0) {
  //       return ['error' => 'Invalid Address'];
  //     } else {
  //       return ['lat' => $data[0]['lat'], 'lon' => $data[0]['lon']];
  //     }

  //     // Do something with the data
  //     // return response()->json($data);
  //   } else {
  //     // Handle error
  //     return response()->json(['error' => 'Invalid Address']);
  //   }

  //   // if ($jsonData === false) {
  //   //   // Handle error
  //   //   echo "Failed to fetch data.";
  //   // } else {
  //   //   // Decode JSON data to PHP array or object
  //   //   $data = json_decode($jsonData, true);

  //   //   // Check if JSON decoding was successful
  //   //   if (json_last_error() === JSON_ERROR_NONE) {
  //   //     // Use the data
  //   //     return ['lat' => $data[0]['lat'], 'lon' => $data[0]['lon']];
  //   //     // var_dump($data);
  //   //   } else {
  //   //     // Handle JSON decode error
  //   //     echo "Failed to decode JSON: " . json_last_error_msg();
  //   //   }
  //   // }
  // }


  public static function getCoordinates($address)
  {
    // URL encode the address
    $encodedAddress = urlencode($address);

    // dd($encodedAddress);
    // Nominatim API endpoint
    $url = "https://nominatim.openstreetmap.org/search?q={$encodedAddress}&format=json&addressdetails=1&limit=1";
    // dd($url);

    try {
      // Make the HTTP GET request
      $response = Http::timeout(30)->get($url);
      dd($response);

      // Check if the request was successful
      if ($response->successful()) {
        $data = $response->json();

        // Check if the response contains data
        if (!empty($data)) {
          $latitude = $data[0]['lat'];
          $longitude = $data[0]['lon'];

          return [
            'success' => true,
            'latitude' => $latitude,
            'longitude' => $longitude,
          ];
        } else {

          // return ['error' => 'Invalid Address'];

          return [
            'success' => false,
            'message' => 'No coordinates found for the given address',
          ];
        }
      } else {
        return [
          'success' => false,
          'message' => 'HTTP Error: ' . $response->status(),
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


  private function checkUrlResponse($url)
  {
    try {
      // Make the HTTP GET request
      $response = Http::timeout(30)->get($url);

      // Check the HTTP status code
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
    } catch (RequestException $e) {
      // Handle any errors that occur during the request
      return [
        'success' => false,
        'message' => 'Request Error: ' . $e->getMessage(),
      ];
    } catch (\Exception $e) {
      // Handle any other exceptions
      return [
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage(),
      ];
    }
  }


  public static function getCoordinatesFromMapbox($address, $accessToken = null)
  {
    $accessToken = 'sk.eyJ1Ijoic3VjaHRyZWUiLCJhIjoiY2x5b2p5dXhnMDA4czJxczR3MDd0cTVteCJ9.cZegC0AWCRYdpkTo9UrvoA';

    $encodedAddress = urlencode($address);
    $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/{$encodedAddress}.json?access_token={$accessToken}";

    try {
      $response = Http::get($url);
      // dd($response);

      if ($response->successful()) {
        $data = $response->json();
        // dd($data["features"]);
        if (!empty($data['features'])) {
          return [
            'latitude' => $data['features'][0]['center'][1],
            'longitude' => $data['features'][0]['center'][0],
            'message' => 'Success in get the longitude and latitude'
          ];
        } else {
          return  [

            'message' => 'Invalid Address'
          ];
        }
      } else {
        return ['message' => 'No Network'];
      }
    } catch (\Exception $e) {
      return  [
        'error' => 'No Network',
        'message' => 'No connect with MapBox'
      ];
    }
  }



  // Usage
  // $accessToken = 'sk.eyJ1Ijoic3VjaHRyZWUiLCJhIjoiY2x5b2p5dXhnMDA4czJxczR3MDd0cTVteCJ9.cZegC0AWCRYdpkTo9UrvoA';

  // $address = "32 Fleming Avenue, Port Harcourt";
  // $coordinates = getCoordinatesFromMapbox($address, $accessToken);

  // if ($coordinates) {
  //     echo "Latitude: " . $coordinates['latitude'] . ", Longitude: " . $coordinates['longitude'];
  // } else {
  //     echo "Coordinates not found.";
  // }

  //   $key = 'sk.eyJ1Ijoic3VjaHRyZWUiLCJhIjoiY2x5b2p5dXhnMDA4czJxczR3MDd0cTVteCJ9.cZegC0AWCRYdpkTo9UrvoA';

}
