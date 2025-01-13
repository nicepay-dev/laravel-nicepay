<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Http;

// use App\Http\Controllers\api\accessToken\GenerateAccessTokenController;
// use App\Http\Controllers\api\accessToken\GenerateAccessTokenController;
use Nicepay\NicepayLaravel\Http\Controllers\api\accessToken\GenerateAccessTokenController;


// use App\Http\Controllers\api\va\GenerateVirtualAccountController;
// use App\Http\Controllers\api\va\InquiryVirtualAccountController;
// use App\Http\Controllers\api\va\DeleteVirtualAccountController;
use Nicepay\NicepayLaravel\Http\Controllers\api\va\GenerateVirtualAccountController;
use Nicepay\NicepayLaravel\Http\Controllers\api\va\InquiryVirtualAccountController;
use Nicepay\NicepayLaravel\Http\Controllers\api\va\DeleteVirtualAccountController;

// use App\Http\Controllers\api\vaDirect\GenerateVirtualAccountDirectController;
// use App\Http\Controllers\api\vaDirect\InquiryStatusVirtualAccountDirectController;
// use App\Http\Controllers\api\vaDirect\CancelVirtualAccountDirectController;
use Nicepay\NicepayLaravel\Http\Controllers\api\vaDirect\GenerateVirtualAccountDirectController;
use Nicepay\NicepayLaravel\Http\Controllers\api\vaDirect\InquiryStatusVirtualAccountDirectController;
use Nicepay\NicepayLaravel\Http\Controllers\api\vaDirect\CancelVirtualAccountDirectController;

// use App\Http\Controllers\api\ccDirect\GenerateCreditCardController;
// use App\Http\Controllers\api\ccDirect\PaymentCreditCardController;
// use App\Http\Controllers\api\ccDirect\InquiryStatusCreditCardController;
use Nicepay\NicepayLaravel\Http\Controllers\api\ccDirect\GenerateCreditCardController;
use Nicepay\NicepayLaravel\Http\Controllers\api\ccDirect\PaymentCreditCardController;
use Nicepay\NicepayLaravel\Http\Controllers\api\ccDirect\InquiryStatusCreditCardController;


// use App\Http\Controllers\api\ewallet\GenerateEwalletController;
// use App\Http\Controllers\api\ewallet\InquiryEwalletController;
// use App\Http\Controllers\api\ewallet\RefundEwalletController;
use Nicepay\NicepayLaravel\Http\Controllers\api\ewallet\GenerateEwalletController;
use Nicepay\NicepayLaravel\Http\Controllers\api\ccDirect\InquiryEwalletController;
use Nicepay\NicepayLaravel\Http\Controllers\api\ewallet\RefundEwalletController;


// use App\Http\Controllers\api\qris\GenerateQrisController;
// use App\Http\Controllers\api\qris\InquiryQrisController;
// use App\Http\Controllers\api\qris\RefundQrisController;
use Nicepay\NicepayLaravel\Http\Controllers\api\qris\GenerateQrisController;
use Nicepay\NicepayLaravel\Http\Controllers\api\qris\InquiryQrisController;
use Nicepay\NicepayLaravel\Http\Controllers\api\qris\RefundQrisController;



// use App\Http\Controllers\api\payout\GeneratePayoutController;
// use App\Http\Controllers\api\payout\ApprovePayoutController;
// use App\Http\Controllers\api\payout\InquiryBalancePayoutController;
// use App\Http\Controllers\api\payout\InquiryPayoutController;
// use App\Http\Controllers\api\payout\RejectPayoutController;
// use App\Http\Controllers\api\payout\CancelPayoutController;
use Nicepay\NicepayLaravel\Http\Controllers\api\payout\GeneratePayoutController;
use Nicepay\NicepayLaravel\Http\Controllers\api\payout\ApprovePayoutController;
use Nicepay\NicepayLaravel\Http\Controllers\api\payout\InquiryBalancePayoutController;
use Nicepay\NicepayLaravel\Http\Controllers\api\payout\InquiryPayoutController;
use Nicepay\NicepayLaravel\Http\Controllers\api\payout\RejectPayoutController;
use Nicepay\NicepayLaravel\Http\Controllers\api\payout\CancelPayoutController;



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
Route::get('/inquiry-virtual-account', [InquiryVirtualAccountController::class, 'inquiryVirtualAccount']);


//VA DIRECT
Route::get('/generate-va-direct', [GenerateVirtualAccountDirectController::class, 'generateVirtualAccountDirect']);
Route::get('/inquiry-va-direct', [InquiryStatusVirtualAccountDirectController::class, 'inquiryVirtualAccountStatusDirect']);
Route::get('/cancel-va-direct', [CancelVirtualAccountDirectController::class, 'cancelVirtualAccountStatusDirect']);

//CreditCard
Route::get('/generate-credit-card', [GenerateCreditCardController::class, 'generateCreditCard']);
Route::get('/payment-credit-card', [PaymentCreditCardController::class, 'paymentCreditCard']);
Route::get('/inquiry-credit-card', [InquiryStatusCreditCardController::class, 'inquiryStatusCreditCard']);



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


