# ihela-php-client

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

/*
Response example :
{
    "bill": {
        "code": "BILL-20200101-N7EKDYOU6R",
        "amount": "<AMOUNT_IN_DECIMAL>",
        "currency": 108,
        "merchant": {
            "title": "Your App Merchant Name",
        },
        "description": "DESCRIPTION",
        "redirect_uri": "YOUR_BILL_CONFIRM_REDIRECT_URI",
        "currency_info": {
            "title": "BURUNDIAN FRANC",
            "iso_code": 108,
            "abbreviation": "BIF",
            "iso_alpha_code": "BIF",
        },
        "confirmation_uri": "https://testgate.ihela.online/banking/bill/BILL-20200101-N7EKDYOU6R/confirm/",
        "payment_reference": None,
        "merchant_reference": "YOUR_APP_REFERENCE",
    }
}


*/

// Verify a bill
$ihela->verifyBill("REF1", "BILL20200811439");

/*
Response sample

{
  "bank_reference": <final_payment_reference>, 
  "reference": THE_BILL_UNIQUE_CODE, 
  "code": YOUR_APP_REFERENCE, 
  "status": <Paid|Pending>
}
*/
```