<?php
require 'vendor/autoload.php';

require_once 'src/Merchant/IhelaMerchant.php';

use Ihela\Merchant\IhelaMerchant;

$clientID = "4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ";
$clientSecret = "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3";

$myReference = "EXAMPLE" . rand();

$ihela = new IhelaMerchant($clientID, $clientSecret);

$banks = $ihela->getBanks();
print_r($banks);

$bank_slug = $banks->banks[0]->slug;
// $bank_slug = 'MOB-0003';

$lookup = $ihela->customerLookup($bank_slug, "16");
print_r($lookup);

// $bill = $ihela->initBill(2000, $myReference, "description ici", '76077736', $bank_slug = $banks->banks[0]->slug);
// print_r($bill->bill);

// $verification = $ihela->verifyBill($myReference, $bill->bill->code);
// print_r($verification);

// $cashin = $ihela->cashinClient($banks->banks[0]->slug, "000016-01", 3000, "EXAMPLE" . rand(), "cashin description");
// print_r($cashin);
