<?php declare(strict_types=1);

use GuzzleHttp\Client;

require_once "../vendor/autoload.php";


$client = new Client(['base_uri' => 'https://funpay.ru/']);

for ($sum = 0; $sum <= 9950; ++$sum)
{
    echo "trying $sum\n\n";

    $response = $client->post("/yandex/emulator", [
        'form_params' => [
            'receiver' => '410012762728229',
            'sum' => $sum,
        ],
        'headers' => [
            'X-Requested-With' => 'XMLHttpRequest',
        ],
    ]);

    echo (string)$response->getBody();
    echo "\n\n";
}
