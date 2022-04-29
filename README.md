# iHela PHP Client

This is the repository for a Php client for consuming the iHela Crédit Union API for financial services in Burundi. The API documentation can be found on https://docs.ihela.bi/.
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

$client_id = "4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ";
$client_secret = "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3";
$is_prod = false;


// I. get the iHela client
$ihela = new IhelaMerchant($client_id, $client_secret, null, $is_prod)

```

This initializes the client and return a ready to use object with authentication. User `$prod=true` to access to production if you have received production credentials and have set the production VPN.

## Bank Lookup

You will often have to fetch for bank list.

```php
// IV. Banks Lookup
$banks = $ihela->getBanks();
```

## Customer Lookup

You will often have to check the customer information to help the user know if there is no error.

```php
// Customer Lookup
$lookup = $ihela->customerLookup($banks->banks[0]->slug, "jonasnih@gmail.com");

/*
Response sample

{
    "account_number": "000001-01",
    "name": "Niheza Jonas"
} */
```

## Initialize a Bill

Initialize a bill sending the function below

```php
// II. Initialize a bill
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
```

## Verify a Bill

You will often verify bill status to know how to handle them in your application. The function below is used to check the status.

```php
// III. Verify a bill
$ihela->verifyBill("REF1", "BILL20200811439");

/*
Response sample

{
  "bank_reference": <final_payment_reference>,
  "reference": THE_BILL_UNIQUE_CODE,
  "code": YOUR_APP_REFERENCE,
  "status": <Paid|Pending>,
  "message": "Bill waiting for payment"
}
*/
```

Possible statuses are **Pending**, **Paid**, **Expired**, **Error**, **Cancelled** .

## Customer Cashin

Sometimes, you will have to refund money to a customer.
```php
// V. Cashin

$test->cashinClient($banks->banks[0]->slug, $lookup->account_number, 3000, "REF2", "cashin description");
```
# Support

Email : support@ihela.online
