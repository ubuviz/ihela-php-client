<?php 
namespace Ihela;

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class IhelaMerchant
{

    protected $_token;
    protected $_client;
    protected $_api_url;

    public function __construct($client_id, $client_secret, $prod=false) {
        if ($prod) {
            $this->_api_url = 'https://api.ihela.online';
        } else {
            $this->_api_url = 'https://testgate.ihela.online';
        }

        // Here we get the token for all calls
        $this->setClient();
        $this->setToken($client_id, $client_secret);
    }

    protected function setClient() {
        $this->_client = new Client(["base_uri"=> $this->_api_url]);
    }

    protected function getClient() {
        return $this->_client;
    }

    protected function setToken($client_id, $client_secret) {
        $client = $this->getClient();

        $headers = array('Content-Type' => 'application/json');
        $res = $client->post("oAuth2/token/", [
            'auth' => [$client_id, $client_secret], 'headers' => $headers, 'json' => array('grant_type' => 'client_credentials')
        ]);

        // echo $res->getStatusCode();
        // "200"
        // echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        $body = $res->getBody();

        $this->_token = $body["token"];
    }

    protected function getToken() {
        return $this->_token;
    }

    public function initBill($amount, $merchant_reference, $description, $user, $redirect_uri=null) {
        $client = $this->getClient();

        $data = array('amount' => $amount, 'merchant_reference' => $merchant_reference, 'description', $description, 'user' => $user, "redirect_uri", $redirect_uri);
        $url = "api/v1/payments/bill/init/";
        $headers = array('Content-Type' => 'application/json','Authorization' => "Bearer $this->getToken()");

        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);
    }

    public function verifyBill($code, $reference) {
        $client = $this->getClient();

        $data = array('reference' => $reference, 'code' => $code);
        $url = "api/v1/payments/bill/verify/";
        $headers = array('Content-Type' => 'application/json','Authorization' => "Bearer $this->getToken()");

        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);
    }


}

// $test = new IhelaMerchant("4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ", "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3");
$test = new IhelaMerchant("4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ", "HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3");

echo $test->initBill(2000, 2, "description ici", 'pierreclaverkoko@gmail.com');