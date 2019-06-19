<?php

namespace App\Services;

use Illuminate\Support\Arr;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
    public function __construct(GuzzleClient $client, Log $log, $key = null)
    {
        $this->client = $client;
        $this->log = $log;
        $this->key = $key;
    }

    public function query($symbol = 'BTC')
    {
        $this->log->info($this->key);
        $response = $this->client->request('GET', 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'headers' => [
                'X-CMC_PRO_API_KEY' => $this->key,
            ],
        ]);

        $results = json_decode($response->getBody()->getContents(), true);

        return Arr::get(collect($results['data'])->filter(function ($item) use ($symbol) {
            return $item['symbol'] === trim(strtoupper($symbol));
        })->first(), 'quote.USD');
    }
}
