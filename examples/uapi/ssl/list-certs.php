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
$response = $cpanel->uapi->ssl->listCerts();
if (!$response->status) {
    echo "Errors occurred:\n" . implode("\n", $response->errors) . "\n";
}
echo implode("\n", $response->messages) . "\n";
print_r($response->data);
