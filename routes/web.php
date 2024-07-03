<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('teacher/{tenant}/lesson-plan/{record}/edit', App\Filament\Teacher\Pages\LessonPlan::class)
    ->middleware(['web', 'auth'])
    ->name('filament.teacher.pages.lesson-plan.edit');

    // Route::get('teacher/{tenant}/lesson-plan/{record}/edit', function($tenant, $record){
    //     // Dump record and tenant
    //     dd([
    //         'tenant' => $tenant,
    //         'record' => $record,
    //     ]);
    // })
    // // ->middleware(['web', 'auth'])
    // ->name('filament.teacher.pages.lesson-plan.edit');
