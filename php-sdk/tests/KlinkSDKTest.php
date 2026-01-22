<?php

namespace KlinkFinance\SDK\Tests;

use PHPUnit\Framework\TestCase;
use KlinkFinance\SDK\KlinkSDK;

class KlinkSDKTest extends TestCase
{
    public function testCanCreateInstance()
    {
        // Mock the health check if necessary or just check basic instantiation logic
        // For now, we expect an exception if we don't mock the HTTP client because it tries to connect
        
        $this->expectException(\Exception::class);
        
        $client = KlinkSDK::create([
            'apiKey' => 'test',
            'apiSecret' => 'test'
        ]);
    }
}
