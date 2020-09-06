# ihela-php-client

PHP Client for iHela API

## Install composer

```sh
curl -sS https://getcomposer.org/installer | php
```

## Install dependencies

```sh
php composer.phar install
```

## Import the class

```php
<?php 
require_once 'ihela_merchant.php';

use Ihela\MerchantClient;

// get the iHela client
$ihela = MerchantClient("4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ", "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3")

// Initialize a bill
$ihela->initBill(2000, "REF1", "description here", 'pierreclaverkoko@gmail.com');

$ihela->verifyBill("REF1", "BILL20200811439");
```