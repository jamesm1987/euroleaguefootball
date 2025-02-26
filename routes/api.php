<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\League;
use App\Http\Resources\LeagueResource;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('leagues', function(){
    return LeagueResource::collection(League::all());
});