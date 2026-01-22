<?php

require 'vendor/autoload.php';

use KlinkFinance\SDK\KlinkSDK;
use KlinkFinance\SDK\Types\KlinkException;

try {
    // Initialize SDK with health check
    // API secret is optional for Advertiser
    $client = KlinkSDK::create([
        'apiKey' => getenv('KLINK_API_KEY'),
        'debug' => true,
    ]);

    // Get advertiser client
    $advertiser = $client->advertiser();

    // Example 1: Health check
    echo "Performing health check...\n";
    $health = $advertiser->healthCheck();
    echo "Health status: " . $health['status'] . "\n\n";

    // Example 2: Send postback
    echo "Sending postback...\n";
    $response = $advertiser->sendPostback([
        'event_name' => 'create_account',
        'offer_id' => 'offer_123',
        'sub1' => 'sub1_value',
        'tx_id' => 'tx_' . uniqid(),
        'isChargeback' => false,
        'chargebackReason' => '',
        'isTest' => true, // Set to true for testing
    ]);
    
    if ($response['success']) {
        echo "Postback sent successfully!\n";
    }

} catch (KlinkException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
