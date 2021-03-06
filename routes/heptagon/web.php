<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Heptagon\AdminController;
use App\Http\Controllers\Heptagon\CompanyController;
use App\Http\Controllers\Heptagon\EmployeeController;


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('companies/template-download', [CompanyController::class, 'downloadTemplate'])->name('download.template');
    Route::post('companies/import', [CompanyController::class, 'import'])->name('import');
    Route::resources([
        'companies' => CompanyController::class,
        'employees' => EmployeeController::class,
    ]);
});
