<?php
require 'vendor/autoload.php';

require_once 'src/Merchant/IhelaMerchant.php';

use Ihela\Merchant\IhelaMerchant;

$clientID = "4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ";
$clientSecret = "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3";
$pinCode = '1234';

// $clientID = "mhNTwp8PGhgxuXiOTZiJcPOv5km1CUg9Iwb1Iqg4";
// $clientSecret = "E8qYLStKf6zCcLZ3KTR5iBXWXVLEXZHKmLHgQGQugmfyf8CIGhHdg3ny2BZhV6J0nNmatjNlYqLDY30GnA31y3Q3zFtUlJj8pIcjPEkwxNun2eCb5Jk72X6r5xtDmDdW";

$myReference = "EXAMPLE" . rand();

$ihela = new IhelaMerchant($clientID, $clientSecret, $pinCode);
// $ihela = new IhelaMerchant($clientID, $clientSecret, $pinCode, "http://127.0.0.1:8080", "http://127.0.0.1:8080/oAuth2", false);

$banks = $ihela->getBanks();
print_r($banks);

$bank_slug = $banks->objects[0]->slug;
// $bank_slug = 'MOB-0003';

// $lookup = $ihela->customerLookup($bank_slug, "16");
$lookup = $ihela->customerLookup($bank_slug, "30001-01-00-16-01-00");
print_r($lookup);

// for ($i = 0; $i < 50; $i++) {
$myReference = "EXAMPLE" . rand();
// $bill = $ihela->initBill(6000, $myReference, "description ici", '16', $bank_slug = $banks->objects[0]->slug, "https://ihela.bi/");
// print_r($bill->bill);
// }

// $verification = $ihela->verifyBill($myReference, $bill->bill->code);
// print_r($verification);

// $cashin = $ihela->cashinClient($banks->banks[0]->slug, $lookup->account_number, $lookup->name, 1000, "EXAMPLE" . rand(), "cashin description");
$cashin = $ihela->cashinClient("MOB-0003", "76077736", "PIERRE", 1000, "EXAMPLE" . rand(), "cashin description");
print_r($cashin);
