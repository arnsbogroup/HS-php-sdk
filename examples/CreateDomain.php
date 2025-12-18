<?php

use Heysender\HSException;
use Heysender\HSClient;
use Heysender\Domain;

//Build the base client
$client = new HSClient('your-api-key', 'your-api-secret');

//Build the client for the wanted api group
$domainClient = new Domain($client);

try {
    //create domain
    $rawResponse = $domainClient->createDomain('example.heysender.com');

    //Get the latest response from the base client split in response and status code
    $neatResponse = $client->getLastResponse();

    //Get all domains
    $allDomains = $domainClient->getDomains();
} catch (HSException $e) {
    //Handle exception thrown
    echo print_r($e, true);
}
