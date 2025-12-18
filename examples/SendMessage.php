<?php

use Heysender\Enums\AnonymizeOptions;
use Heysender\MessageBuilder;
use Heysender\HSException;
use Heysender\HSClient;
use Heysender\Message;

//Build the base client
$client = new HSClient('your-api-key', 'your-api-secret');

//Build the client for the wanted api group
$messageClient = new Message($client);

//Build email message
$message = (new MessageBuilder(
    'sender@yourdomain.com',
    'Your Name',
    'Test Subject',
    '<h1>Hello World!</h1>'
))
    ->addTo('recipient@example.com', 'Recipient Name')
    ->setAnonymizeOptions([
        AnonymizeOptions::CONTENT
    ])
    ->setTracking(true)
    ->build();

try {
    //Send email message and get response in return
    $rawResponse = $messageClient->sendMessage($message);
    //Get the latest response from the base client split in response and status code
    $neatResponse = $client->getLastResponse();
} catch (HSException $e) {
    //Handle exception
    echo print_r($e, true);
}
