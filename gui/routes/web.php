<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplatePreviewController;
use App\Http\Controllers\DashboardController;

Route::get('/', DashboardController::class);

Route::get('/preview/{fileName}', [TemplatePreviewController::class, 'get'])
    ->name('preview.render')
    ->where('fileName', '[a-zA-Z0-9\-_\.]+');
