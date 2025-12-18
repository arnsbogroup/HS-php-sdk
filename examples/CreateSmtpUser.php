<?php

use Heysender\Enums\AnonymizeOptions;
use Heysender\HSException;
use Heysender\HSClient;
use Heysender\SmtpUser;
use Heysender\Domain;

//Build the base client
$client = new HSClient('your-api-key', 'your-api-secret');

//Build the client for the wanted api group
$smtpUserClient = new SmtpUser($client);

//Build the client for the wanted api group
$domainClient = new Domain($client);

try {
    //Get all domains
    $allDomains = $domainClient->getDomains();
    echo print_r($allDomains, true);

    //create smtp user on domain
    $rawResponse = $smtpUserClient->createSMTPUser(
        $allDomains[0]['id'],
        'example@' . $allDomains[0]['url'],
        [AnonymizeOptions::CONTENT, AnonymizeOptions::SUBJECT]
    );

    //Get the latest response from the base client split in response and status code
    $neatResponse = $client->getLastResponse();

    $smtpUserClient->getSMTPUsers($allDomains[0]['id']);
} catch (HSException $e) {
    //Handle exception thrown
    echo print_r($e, true);
}
