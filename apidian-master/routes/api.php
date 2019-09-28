<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// UBL 2.1
Route::prefix('/ubl2.1')->group(function () {
    // Configuration
    Route::prefix('/config')->group(function () {
        Route::post('/{nit}/{dv?}', 'Api\ConfigurationController@store');
    });
});

Route::middleware('auth:api')->group(function () {
    // UBL 2.1
    Route::prefix('/ubl2.1')->group(function () {
        // Configuration
        Route::prefix('/config')->group(function () {
            Route::put('/software', 'Api\ConfigurationController@storeSoftware');
            Route::put('/certificate', 'Api\ConfigurationController@storeCertificate');
            Route::put('/resolution', 'Api\ConfigurationController@storeResolution');
            Route::put('/environment', 'Api\ConfigurationController@storeEnvironment');
        });

        // Invoice
        Route::prefix('/invoice')->group(function () {
            Route::post('/{testSetId}', 'Api\InvoiceController@testSetStore');
            Route::post('/', 'Api\InvoiceController@store');
        });

        // Credit Notes
        Route::prefix('/credit-note')->group(function () {
            Route::post('/{testSetId}', 'Api\CreditNoteController@testSetStore');
            Route::post('/', 'Api\CreditNoteController@store');
        });

        // Debit Notes
        Route::prefix('/debit-note')->group(function () {
            Route::post('/{testSetId}', 'Api\DebitNoteController@testSetStore');
            Route::post('/', 'Api\DebitNoteController@store');
        });

        // Status
        Route::prefix('/status')->group(function () {
            Route::post('/zip/{trackId}/{GuardarEn?}', 'Api\StateController@zip');
            Route::post('/document/{trackId}/{GuardarEn?}', 'Api\StateController@document');
        });

        // Numbering Ranges
        Route::prefix('/numbering-range')->group(function () {
            Route::post('/', 'Api\NumberingRangeController@NumberingRange');
        });
    });
});


Route::get('invoice/xml/{filename}', function($fisicroute)
{
    $path = storage_path($fisicroute);
    return response(file_get_contents($path), 200, [
        'Content-Type' => 'application/xml'
    ]);
});
Route::get('invoice/pdf/{filename}', function($fisicroute)
{
    $path = storage_path("app/".$fisicroute);
    return response(file_get_contents($path), 200, [
        'Content-Type' => 'application/pdf'
    ]);
});

