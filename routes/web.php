<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CampAccessController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\CodeResetController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Google\Service\PubsubLite\Resource\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/camp_portal', [CampAccessController::class, 'campPortal'])->name('camp_portal');
    Route::get('/goto_camp/{camp_id}', [CampAccessController::class, 'gotoCamp'])->name('gotoCamp');

    Route::middleware('camp')->group(function(){
        //dashboard
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/getAreaChartData', [HomeController::class, 'getAreaChartData']);

        //sheets
        Route::get('/sheets', [SheetController::class, 'index'])->name('sheets.index');
        Route::get('/fetchGoogleSheets', [SheetController::class, 'fetchGoogleSheets']);
        Route::post('/saveSheetNames', [SheetController::class, 'saveSheetNames']);
        Route::get('/getSheetByID', [SheetController::class, 'getSheetByID']);
        Route::put('/updateSheet', [SheetController::class, 'update'])->name("update.sheet");
        Route::get('/deleteSheet', [SheetController::class, 'destroy']);
        Route::get('/getSheetByCampID', [SheetController::class, 'getSheetByCampID']);
        Route::get('/getActiveSheetByCampID', [SheetController::class, 'getActiveSheetByCampID']);

         //codes
        Route::get('/codes', [CodeController::class, 'index'])->name('codes.index');
        Route::get('/code_upload_view', [CodeController::class, 'codeUploadView'])->name('codeUpload.view');
        Route::get('/getCodes', [CodeController::class, 'getCodes']);
        Route::get('/getCodesByDate', [CodeController::class, 'getCodesByDate']);
        Route::get('/codeUpload', [CodeController::class, 'codeUpload']);
        Route::get('/codeSearch', [CodeController::class, 'codeSearch']);
        Route::get('/getOneCode', [CodeController::class, 'getOneCode']);
        Route::put('/update_code',[CodeController::class, 'update'])->name('codes.update');
        Route::get('/delete_code', [CodeController::class, 'destroy'])->name('codes.destroy');

        //codes
        Route::get('/codes', [CodeController::class, 'index'])->name('codes.index');
        Route::get('/code_upload_view', [CodeController::class, 'codeUploadView'])->name('codeUpload.view');
        Route::get('/getCodes', [CodeController::class, 'getCodes']);
        Route::get('/getCodesByDate', [CodeController::class, 'getCodesByDate']);
        Route::get('/codeUpload', [CodeController::class, 'codeUpload']);
        Route::get('/codeSearch', [CodeController::class, 'codeSearch']);
        Route::get('/getOneCode', [CodeController::class, 'getOneCode']);
        Route::put('/update_code',[CodeController::class, 'update'])->name('codes.update');
        Route::get('/delete_code', [CodeController::class, 'destroy'])->name('codes.destroy');

        //code reset
        Route::get('/code_reset', [CodeResetController::class, 'index'])->name('codeReset.index');
        Route::get('/getIdentity', [CodeResetController::class, 'getIdentity']);
        Route::get('/getUserManagerUsers', [CodeResetController::class, 'getUserManagerUsers']);
        Route::get('/getOneUser', [CodeResetController::class, 'getOneUser']);
        Route::get('/getSessionByUsername', [CodeResetController::class, "getSessionByUsername"]);

        //camps
        Route::get('/camps', [CampController::class, 'index'])->name('camps.index');
        Route::post('/store-camp', [CampController::class, 'store'])->name('camps.store');
        Route::put('/update-camp', [CampController::class, 'update'])->name('camps.update');
        Route::get('/getOneCamp', [CampController::class, 'getOneCamp']);

        //camp access
        Route::get('/camp_access', [CampAccessController::class, 'index'])->name('campAccess.index');
        Route::post('/store-camp_access', [CampAccessController::class, 'store'])->name('campAccess.store');
        Route::delete('/remove-camp_access', [CampAccessController::class, 'remove'])->name('campAccess.remove');

        //permissions
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index');
        Route::post('/store-permission', [PermissionController::class, 'store'])->name('permission.store');
        Route::put('/update-permission', [PermissionController::class, 'update'])->name('permission.update');
        Route::get('/delete-permission', [PermissionController::class, 'destroy']);
        Route::get('/getOnePermission', [PermissionController::class, 'getOnePermission']);

        //users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/store-user', [UserController::class, 'store'])->name('users.store');
        Route::put('/update-user', [UserController::class, 'update'])->name('users.update');
        Route::put('/updatePassword', [UserController::class, 'updatePassword'])->name('users.updatePassword');
        Route::get('/getUser', [UserController::class, 'getUser']);

        //profile
        Route::get('/user-profile', [UserController::class, 'profile'])->name('profile.view');
        Route::put('/changePassword', [UserController::class, 'changePassword'])->name('profile.change-password');

        //reports
        Route::get('/sales-reports', [ReportsController::class, 'index'])->name('sales.reports');
        Route::get('/salesDetailReport', [ReportsController::class, 'salesDetailReport']);
        Route::get('/rptSalesDetail', [ReportsController::class, 'rptSalesDetail'])->name('report.salesDetails');
        Route::get('/saleSummartReport', [ReportsController::class, 'saleSummartReport']);
        Route::get('/rptSaleSummary', [ReportsController::class, 'rptSaleSummary'])->name('report.saleSummary');
    });//camp middleware

    //testing
    Route::get('/testing', [TestController::class, 'index'])->name('test.index');
    Route::post('/getSheetNames', [TestController::class, 'getSheetNames'])->name('test.sheetNames');
    Route::get('/getUsers', [TestController::class, 'getUsers']);
    Route::get('/getAllUsers', [TestController::class, 'getAllUsers']);
    Route::get('/getSession', [TestController::class, 'getSession']);

    //admin middleware
    Route::middleware('admin')->group(function(){
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/general-cli', [AdminController::class, 'generalCli']);
        Route::get('/testing-cli', [AdminController::class, 'testing']);
        Route::get('/getOneUserAdmin', [AdminController::class, 'getOneUser']);

        Route::get('/session', [AdminController::class, 'viewSession'])->name('admin.session');
        Route::get('/fetchSession', [AdminController::class, 'fetchSession']);

        Route::get('/codeCheck', [AdminController::class, 'codeCheck']);

        //generator
        Route::get('/generator', [GeneratorController::class, 'index'])->name('generator.index');
        Route::get('/fetchUserCodes', [GeneratorController::class, 'fetchUserCodes']);
        Route::get('/generateCodes', [GeneratorController::class, 'generateCodes']);

        //restart
        Route::get('/restart', [AdminController::class, 'codeRestartView'])->name('admin.restart');
    });//admin middleware

});//auth middleware

//reset codes
Route::get('/reset', [ResetController::class, 'index'])->name('reset.index');
Route::post('/resetLogin', [ResetController::class, 'resetLogin'])->name('reset.login');

//reset middleware
Route::middleware('reset')->group(function(){
    Route::get('/reset_page', [ResetController::class, 'resetPage'])->name('reset.page');

    //code reset
    Route::get('/code_reset', [CodeResetController::class, 'index'])->name('codeReset.index');
    Route::get('/getIdentity', [CodeResetController::class, 'getIdentity']);
    Route::get('/getUserManagerUsers', [CodeResetController::class, 'getUserManagerUsers']);
    Route::get('/getOneUser', [CodeResetController::class, 'getOneUser']);
    Route::get('/getSessionByUsername', [CodeResetController::class, "getSessionByUsername"]);

    Route::get('/resetCode', [CodeResetController::class, 'resetCode']);
    Route::get('/disableUser', [CodeResetController::class, 'disableUser']);
    Route::get('/enableUser', [CodeResetController::class, 'enableUser']);
});

require __DIR__.'/auth.php';
