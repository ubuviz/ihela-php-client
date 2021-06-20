<?php
require 'vendor/autoload.php';

require_once 'src/Merchant/IhelaMerchant.php';

use Ihela\Merchant\IhelaMerchant;

// $test = new IhelaMerchant("4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZr", "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3");
$clientID = "4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ";
$clientSecret = "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3";
$test = new IhelaMerchant($clientID, $clientSecret);

print_r($test->initBill(2000, 2, "description ici", 'pierreclaverkoko@gmail.com'));
//print_r($test->getBanks());
