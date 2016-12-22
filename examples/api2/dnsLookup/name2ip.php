<?php

require(dirname(dirname(dirname(__DIR__))) . '/vendor/autoload.php');

use kdn\cpanel\api\Auth;
use kdn\cpanel\api\Cpanel;

$cpanel = new Cpanel(
    [
        'host' => 'localhost',
        'auth' => new Auth(['username' => 'USERNAME', 'password' => 'PASSWORD']),
    ]
);
$response = $cpanel->api2->dnsLookup->setTargetUsername('username')->name2ip('hostname');
if (isset($response->error)) {
    echo "Error occurred:\n$response->error\n";
} else {
    print_r(reset($response->data));
}
