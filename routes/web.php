<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ShowProfileController;
use App\Http\Controllers\HomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
    });


Route::resource('/companies',CompaniesController::class);



