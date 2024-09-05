<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class UpdateController extends Controller
{
  public function update()
  {
    // Run the migrations
    Artisan::call('migrate', ['--force' => true]);

    // Clear the cache
    Artisan::call('cache:clear');

    // Optional: Clear other caches
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return response()->json(['status' => 'success', 'message' => 'Application updated successfully.']);
  }

  public function clear()
  {

    // Clear the cache
    Artisan::call('cache:clear');

    // Optional: Clear other caches
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return response()->json(['status' => 'success', 'message' => 'Application cache cleared successfully.']);
  }
}
