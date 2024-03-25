<?php

use App\Models;
use App\Models\Component;
use App\Models\Panel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/panel', function () {
    $id = Component::insertGetId([
        'parentId' => null,
        'type' => 'panel',
        'page' => 1,
    ]);
    $cmp = Component::find($id);
    $model = new Panel();
    $model->title = "panel1";
    $model->cols = 1;
    $model->span = 1;
    $cmp->{$cmp->type}()->save($model);
});
Route::get('/title', function () {
    $id = Component::insertGetId([
        'parentId' => null,
        'type' => 'text',
        'page' => 1,
    ]);
    $cmp = Component::find($id);
    $model = new Models\Text();
    $model->title = "panel1";
    $cmp->{$cmp->type}()->save($model);
});
Route::get('/', function () {
    DB::enableQueryLog();
    $value = Component::limit(20)->with('panel')->get();
    $query = DB::getQueryLog();
    return [$value,$query];
});
