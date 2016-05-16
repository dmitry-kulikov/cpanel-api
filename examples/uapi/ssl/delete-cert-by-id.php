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
$response = $cpanel->uapi->ssl->deleteCertById('example_com_cb497_a394d_1397249671_d1272da8f13a1fd837493a5ad1f0a0f3');
if (!$response->status) {
    echo "Errors occurred:\n" . implode("\n", $response->errors) . "\n";
}
echo implode("\n", $response->messages) . "\n";
print_r($response->data);
