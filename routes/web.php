<?php

use GuzzleHttp\Client;

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
    $client = new Client();
    $response = $client->request('GET', 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
        'headers' => ['X-CMC_PRO_API_KEY' => '8fd8b63a-b087-4419-985e-2d37557bde36'],
    ]);
    dump($response->getBody()->getContents());
});
