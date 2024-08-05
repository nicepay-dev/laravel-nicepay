<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\accessToken\GenerateAccessTokenController;
use App\Http\Controllers\api\va\GenerateVirtualAccountController;
use App\Http\Controllers\api\va\DeleteVirtualAccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('template.index');
});


Route::get('/generate-access-token', [GenerateAccessTokenController::class, 'generateAccessToken']);

Route::get('/generate-virtual-account', [GenerateVirtualAccountController::class, 'generateVirtualAccount']);

Route::get('/delete-virtual-account', [DeleteVirtualAccountController::class, 'deleteVirtualAccount']);


Route::prefix('v1.0')->group(function() {
    Route::get('/access-token', 'api\accessToken\GenerateAccessTokenController@generateAccessToken');
});
Route::prefix('api/v1.0')->group(function() {
    // va
    Route::get('/transfer-va/create-va', 'api\va\GenerateVirtualAccountController@generateVirtualAccount');
    Route::get('/transfer-va/delete-va', 'api\va\DeleteVirtualAccountController@deleteVirtualAccount');

    // qris
    Route::prefix('/qr')->group(function() {
        Route::get('/qr-mpm-generate', 'api\qris\GenerateQrisController@generateQris');
        Route::get('/qr-mpm-query', 'api\qris\GenerateQrisController@inquiryQris');
        Route::get('/qr-mpm-refund', 'api\qris\GenerateQrisController@refundQris');
    });

    // ewallet
    Route::prefix('/debit')->group(function() {
        Route::get('/payment-host-to-host', 'api\ewallet\GenerateEwalletController@generateEwallet');
        Route::get('/status', 'api\ewallet\GenerateEwalletController@inquiryEwallet');
        Route::get('/refund', 'api\ewallet\GenerateEwalletController@refundEwallet');
    });

    // payout
    Route::prefix('/transfer')->group(function() {
        Route::get('/registration', 'api\payout\GeneratePayoutController@generatePayout');
        Route::get('/approve', 'api\payout\GeneratePayoutController@approvePayout');
        Route::get('/inquiry', 'api\payout\GeneratePayoutController@inquiryPayout');
        Route::get('/balance-inquiry', 'api\payout\GeneratePayoutController@balanceInquiryPayout');
        Route::get('/cancel', 'api\payout\GeneratePayoutController@cancelPayout');
        Route::get('/reject', 'api\payout\GeneratePayoutController@rejectPayout');
    });
});