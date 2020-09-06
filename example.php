<?php
require_once 'src/ihelaMerchant.php';

use ihela\Merchant\IhelaMerchant;

// $test = new IhelaMerchant("4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZr", "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3");
$test = new IhelaMerchant("gC8GTZ0lEZKgQKkeygxPoyTdNIEwpWmBptWSZMMv", "OEnTNo1puZAxLtMBsAn3LUSVwDBs0lR2XtHtWhdtpERglkuODds54rzFt28RMw8SkyhB56UVDPFARdPBkoIb4OqggxGgPIEQZkEVavUQjAc1ltCmZJ4Qnw43hICyeUxw");

$h = $test->authenticate();
print_r($h);
// echo $test->initBill(2000, 2, "description ici", 'pierreclaverkoko@gmail.com');
// echo $test->getBanks();