<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount('documentfilingsystem-dd6c4-firebase-adminsdk-ytdns-e7a85b1103.json')
                        ->withDatabaseUri('https://documentfilingsystem-dd6c4-default-rtdb.firebaseio.com/');
                        
$database = $factory->createDatabase();