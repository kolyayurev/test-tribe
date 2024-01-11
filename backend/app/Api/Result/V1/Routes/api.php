<?php

use App\Api\Result\V1\Actions\AddAction;
use App\Api\Result\V1\Actions\GetTopAction;
use Illuminate\Support\Facades\Route;

Route::post('/add', [AddAction::class, 'handle'])->name('add');
Route::get('/get-top-ten', [GetTopAction::class, 'handle'])->name('get-top-ten');
