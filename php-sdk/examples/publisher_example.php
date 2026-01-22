<?php

require 'vendor/autoload.php';

use KlinkFinance\SDK\KlinkSDK;
use KlinkFinance\SDK\Types\KlinkException;

try {
    // Initialize SDK with health check
    $client = KlinkSDK::create([
        'apiKey' => getenv('KLINK_API_KEY'),
        'apiSecret' => getenv('KLINK_API_SECRET'), // Required for Publisher
        'debug' => true,
    ]);

    // Get publisher client
    $publisher = $client->publisher();

    // Example 1: Fetch offers
    echo "Fetching offers...\n";
    $offers = $publisher->getOffers([
        'page' => 1,
        'limit' => 10,
        'category' => ['gaming'],
        'country' => 'US',
    ]);
    echo "Found " . count($offers['data']) . " offers\n\n";

    // Example 2: Fetch conversions
    echo "Fetching conversions...\n";
    $conversions = $publisher->getConversions([
        'page' => 1,
        'limit' => 5,
        'status' => 'approved',
    ]);
    echo "Found " . count($conversions['data']) . " conversions\n\n";

    // Example 3: Fetch countries
    echo "Fetching countries...\n";
    $countries = $publisher->getCountries();
    echo "Found " . count($countries['data']) . " countries\n\n";

    // Example 4: Fetch categories
    echo "Fetching categories...\n";
    $categories = $publisher->getCategories();
    echo "Found " . count($categories['data']) . " categories\n\n";

    // Example 5: Health check
    echo "Performing health check...\n";
    $health = $publisher->healthCheck();
    echo "Health status: " . $health['status'] . "\n\n";

} catch (KlinkException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
