<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    DB::enableQueryLog();
        // This closure will be executed if the value doesn't exist in the cache
        // Run your query here to retrieve the value
    $data = \App\Models\Component::whereNotNull('panel_id')->where('id',1)->get();
//    $query = DB::getQueryLog();
    return $data;
});
