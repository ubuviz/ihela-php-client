# iHel php client

This is the repository for a Php client for consuming the iHela Crédit Union API for financial services in Burundi. The API gateway can be found on https://testgate.ihela.online/. 
PHP Client for iHela API

## Install composer

```sh
curl -sS https://getcomposer.org/installer | php
```

## Install dependencies

```sh
composer require ihela/api-client
```

For the not-released version, use:

```sh
composer require ihela/api-client:dev-master
```

## Import the class

```php
<?php 
require_once __DIR__ . '/vendor/autoload.php';

use Ihela\Merchant\IhelaMerchant;

// get the iHela client
$ihela = new IhelaMerchant("4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ", "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3")

// Initialize a bill
$ihela->initBill(2000, "REF1", "description here", 'pierreclaverkoko@gmail.com');

$ihela->verifyBill("REF1", "BILL20200811439");
```
