<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\api\accessToken\GenerateAccessTokenController;
use App\Http\Controllers\api\va\GenerateVirtualAccountController;
use App\Http\Controllers\api\va\DeleteVirtualAccountController;
use App\Http\Controllers\api\ewallet\GenerateEwalletController;
use App\Http\Controllers\api\ewallet\InquiryEwalletController;
use App\Http\Controllers\api\ewallet\RefundEwalletController;
use App\Http\Controllers\api\qris\GenerateQrisController;
use App\Http\Controllers\api\qris\InquiryQrisController;
use App\Http\Controllers\api\qris\RefundQrisController;

use App\Http\Controllers\api\payout\GeneratePayoutController;
use App\Http\Controllers\api\payout\ApprovePayoutController;
use App\Http\Controllers\api\payout\InquiryBalancePayoutController;
use App\Http\Controllers\api\payout\InquiryPayoutController;
use App\Http\Controllers\api\payout\RejectPayoutController;
use App\Http\Controllers\api\payout\CancelPayoutController;


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

//Generate token
Route::get('/generate-access-token', [GenerateAccessTokenController::class, 'generateAccessToken']);


//VA
Route::get('/generate-virtual-account', [GenerateVirtualAccountController::class, 'generateVirtualAccount']);
Route::get('/delete-virtual-account', [DeleteVirtualAccountController::class, 'deleteVirtualAccount']);



//E-Wallet
Route::get('/generate-ewallet', [GenerateEwalletController::class, 'generateEwallet']);
Route::get('/status-ewallet', [InquiryEwalletController::class, 'inquiryEwallet']);
Route::get('/refund-ewallet', [RefundEwalletController::class, 'refundEwallet']);


//QRIS
Route::get('/generate-qr', [GenerateQrisController::class, 'generateQris']);
Route::get('/status-qr', [InquiryQrisController::class, 'inquiryQris']);
Route::get('/refund-qr', [RefundQrisController::class, 'refundQris']);


//Payout
Route::get('/registration-payout', [GeneratePayoutController::class, 'generatePayout']);
Route::get('/approve-payout', [ApprovePayoutController::class, 'approvePayout']);
Route::get('/cancel-payout', [CancelPayoutController::class, 'cancelPayout']);
Route::get('/inquiry-balance-payout', [InquiryBalancePayoutController::class, 'inquiryBalancePayout']);
Route::get('/inquiry-payout', [InquiryPayoutController::class, 'inquiryPayout']);
Route::get('/reject-payout', [RejectPayoutController::class, 'rejectPayout']);


