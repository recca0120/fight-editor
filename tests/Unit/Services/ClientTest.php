<?php

namespace Tests\Unit\Services;

use Mockery as m;
use App\Services\Log;
use App\Services\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as GuzzleClient;

class ClientTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    /** @test */
    public function test_query()
    {
        $key = 'xxx';
        $guzzleClient = m::mock(new GuzzleClient);
        $guzzleClient->shouldReceive('request')->andReturn(
            new Response('200', [], file_get_contents(__DIR__.'/result.txt'))
        )->once();
        $log = m::spy(Log::class);
        $client = new Client($guzzleClient, $log, $key);

        $this->assertArraySubset([
            'price' => 9165.74788036,
            'volume_24h' => 15782991288.054,
            'percent_change_1h' => -0.537992,
            'percent_change_24h' => -1.19578,
            'percent_change_7d' => 16.4927,
            'market_cap' => 162835578819.6922,
            'last_updated' => '2019-06-18T12:14:22.000Z',
        ], $client->query('btC '));

        $log->shouldHaveReceived('info')->with($key)->once();
    }
}
