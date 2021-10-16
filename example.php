<?php
require 'vendor/autoload.php';

require_once 'src/Merchant/IhelaMerchant.php';

use Ihela\Merchant\IhelaMerchant;

// $test = new IhelaMerchant("4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZr", "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3");
$clientID = "4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ";
$clientSecret = "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3";
$test = new IhelaMerchant($clientID, $clientSecret);

$bill = $test->initBill(2000, "EXAMPLE".rand(), "description ici", 'pierreclaverkoko@gmail.com');
print_r($bill->bill);


$verification = $test->verifyBill($bill->bill->merchant_reference, $bill->bill->code);
print_r($verification);

$banks = $test->getBanks();
print_r($banks);

$lookup = $test->customerLookup($banks->banks[0]->slug, "16");
print_r($lookup);

$cashin = $test->cashinClient($banks->banks[0]->slug, "000016-01", 3000, "EXAMPLE".rand(), "cashin description");
print_r($cashin);
