<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/obem-91c3e-firebase-adminsdk-wuu45-2d135f7814.json');
$apiKey = 'AIzaSyC_vb5G9qs3NJsywbR34el1RaPj2HDhwNg';

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://obem-91c3e.firebaseio.com/')
    ->create();

    $database = $firebase->getDatabase();