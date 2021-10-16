<?php
namespace Ihela\Merchant;

use League\OAuth2\Client\Provider\GenericProvider;
use GuzzleHttp\Client;

class IhelaMerchant
{

    protected $_auth_token_object;
    protected $_request;
    protected $_api_url;

    protected $_client_id;
    protected $_client_secret;
    protected $_provider;
    protected $_http_client;

    const IHELA_TOKEN_URL = "oAuth2/token/";
    const IHELA_AUTH_URL = "oAuth2/authorize/";
    const IHELA_ENDPOINTS = array(
        "USER_INFO"=> "api/v1/connected-user/",
        "BILL_INIT"=> "api/v1/payments/bill/init/",
        "BILL_VERIFY"=> "api/v1/payments/bill/verify/",
        "CASHIN"=> "api/v1/payments/cash-in/",
        "BANKS"=> "api/v1/bank/all",
        "BANKS_ALL"=> "api/v1/bank/all",
        "LOOKUP" => "api/v1/bank/%s/account/lookup/"
    );

    public function __construct($client_id, $client_secret, $prod=false) {
        if ($prod) {
            $this->_api_url = 'https://api.ihela.bi';
        } else {
            $this->_api_url = 'https://testgate.ihela.online';
            //$this->_api_url = 'http://127.0.0.1:8080';
        }

        $this->_client_id = $client_id;
        $this->_client_secret = $client_secret;

        $this->_provider = new GenericProvider([
            'clientId'                => $this->_client_id,    // The client ID assigned to you by the provider
            'clientSecret'            => $this->_client_secret,    // The client password assigned to you by the provider
            'redirectUri'             => '',
            'urlAuthorize'            => $this->getUrl(self::IHELA_AUTH_URL),
            'urlAccessToken'          => $this->getUrl(self::IHELA_TOKEN_URL),
            'urlResourceOwnerDetails' => $this->getUrl(self::IHELA_ENDPOINTS["USER_INFO"])
        ]);
        $this->_http_client = new Client(['base_uri' => $this->_api_url]);

        // Here we get the token for all calls
        $this->authenticate();
    }

    protected function getUrl($url) {
        return $this->_api_url .'/'. $url;
    }

    /**
    Authenticates the merchant application in iHela
    */
    protected function authenticate() {
        $accessToken = $this->_provider->getAccessToken('client_credentials');
        // echo 'Access Token: ' . $accessToken->getToken() . "<br>";
        $this->_auth_token_object =array(
            "access_token" => $accessToken, 
            // "access_token" => "sdhsj73843jedkHyskHM",
            "expires_in" => $accessToken->getExpires(),
            "token_type" => $accessToken->getValues()["token_type"],
            "scope" => $accessToken->getValues()["scope"]
        );
        // print_r($this->_auth_token_object);
    }

    public function initBill($amount, $merchant_reference, $description, $user, $redirect_uri=null) {
        $url = $this->getUrl(self::IHELA_ENDPOINTS["BILL_INIT"]);
        $payload =array(
            'amount' => $amount, 
            'merchant_reference' => $merchant_reference, 
            'description' => $description,
            'user' => $user, 
            "redirect_uri" => $redirect_uri
        );

        $request = $this->_provider->getAuthenticatedRequest(
            'POST',
            $url,
            $this->_auth_token_object["access_token"],
            array(
                "headers" => array('Content-Type' => 'application/json', 'Accept' => 'application/json'),
                "body" => json_encode($payload)
            )
        );

        // print_r($request);

        $response = $this->_provider->getResponse($request);

        // print_r($response);

        return json_decode($response->getBody());
    }

    public function verifyBill($code, $reference) {
        $url = $this->getUrl(self::IHELA_ENDPOINTS["BILL_VERIFY"]);
        $payload =array('reference' => $reference, 'code' => $code);

        $request = $this->_provider->getAuthenticatedRequest(
            'POST',
            $url,
            $this->_auth_token_object["access_token"],
            array(
                "headers" => array('Content-Type' => 'application/json', 'Accept' => 'application/json'),
                "body" => json_encode($payload)
            )
        );

        // print_r($request);

        $response = $this->_provider->getResponse($request);

        // print_r($response);

        return json_decode($response->getBody());

    }

    public function cashinClient($bank_slug, $account, $amount, $merchant_reference, $description) {
        $url = $this->getUrl(self::IHELA_ENDPOINTS["CASHIN"]);
        $payload = array(
            'bank_slug' => $bank_slug,
            'account' => $account,
            'amount' => $amount,
            'merchant_reference' => $merchant_reference,
            'description' => $description
        );

        $request = $this->_provider->getAuthenticatedRequest(
            'POST',
            $url,
            $this->_auth_token_object["access_token"],
            array(
                "headers" => array('Content-Type' => 'application/json', 'Accept' => 'application/json'),
                "body" => json_encode($payload)
            )
        );

        // print_r($request);

        $response = $this->_provider->getResponse($request);

        // print_r($response);

        return json_decode($response->getBody());
    }

    public function getBanksAll() {
        $response = $this->_http_client->request('GET', self::IHELA_ENDPOINTS["BANKS_ALL"]);

        return json_decode($response->getBody());

    }

    public function getBanks() {
        $response = $this->_http_client->request('GET', self::IHELA_ENDPOINTS["BANKS"]);

        return json_decode($response->getBody());
    }

    public function customerLookup($bank_slug, $customer_id) {
        $response = $this->_http_client->request('GET', sprintf(self::IHELA_ENDPOINTS["LOOKUP"], $bank_slug), ['query' => ['customer_id' => $customer_id]]);

        return json_decode($response->getBody());
    }

}
