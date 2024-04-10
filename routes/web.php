<?php

use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::any('/start', [WordController::class, 'start']);

Route::any('/startmany', [WordController::class, 'startMany']);

Route::any('/startbatch', [WordController::class, 'startBatch']);

Route::get('/jobs', function () {
    return DB::table('jobs')->get();
});
