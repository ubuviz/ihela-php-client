<?php 
namespace iHela\Merchant;


class IhelaMerchant
{

    protected $_auth_token_object;
    protected $_request;
    protected $_api_url;

    protected $_client_id;
    protected $_client_secret;

    const IHELA_TOKEN_URL = "oAuth2/token/";
    const IHELA_AUTH_URL = "oAuth2/authorize/";
    const IHELA_ENDPOINTS = array(
        "USER_INFO"=> "api/v1/connected-user/",
        "BILL_INIT"=> "api/v1/payments/bill/init/",
        "BILL_VERIFY"=> "api/v1/payments/bill/verify/",
        "CASHIN"=> "api/v1/payments/cash-in/",
        "BANKS_ALL"=> "api/v1/bank/all",
    );

    public function __construct($client_id, $client_secret, $prod=false) {
        if ($prod) {
            $this->_api_url = 'https://api.ihela.online';
        } else {
            // $this->_api_url = 'https://testgate.ihela.online';
            $this->_api_url = 'http://127.0.0.1:8080';
        }

        $this->_client_id = $client_id;
        $this->_client_secret = $client_secret;

        // Here we get the token for all calls
        $this->authenticate();
    }

    /**
    Authenticates the merchant application in iHela
    */
    public function authenticate() {
        $url = $this->_api_url .'/'. self::IHELA_TOKEN_URL;
        // $url = $this->_api_url .'/api/v1/users/login/';
        $payload = json_encode( array( "grant_type"=> "client_credentials" ) );
        // $payload = json_encode( array( "user"=> array("email" => "pierreclaverkoko@gmail.com", "password" => "pass123456", "profile_type"=> "I") ) );

        $curl = \curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'User-Agent:jd'),
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_HTTPAUTH => CURLAUTH_ANY,
          CURLOPT_USERPWD => "$this->_client_id:$this->_client_secret",
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $payload,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    // protected function setClient() {
    //     $this->_client = new Client(["base_uri"=> $this->_api_url]);
    // }

    // protected function getClient() {
    //     return $this->_client;
    // }

    // protected function setToken($client_id, $client_secret) {
    //     $client = $this->getClient();

    //     $headers = array('Content-Type' => 'application/json');
    //     $res = $client->post("oAuth2/token/", [
    //         'auth' => [$client_id, $client_secret], 'headers' => $headers, 'json' => array('grant_type' => 'client_credentials')
    //     ]);
    //     // $res = $client->post("api/v1/users/login/", [
    //     //     'headers' => $headers, 'json' => array('user' => ["email" => "pierreclaverkoko@gmail.com", "password" => "pass123456", "profile_type" => "I"])
    //     // ]);

    //     // echo $res->getStatusCode();
    //     // "200"
    //     // echo $res->getHeader('content-type')[0];
    //     // 'application/json; charset=utf8'
    //     $body = $res->getBody();

    //     $this->_token = $body;
    // }

    // protected function getToken() {
    //     return $this->_token;
    // }

    // protected function getAuthHeader() {
    //     $token = $this->getToken();

    //     return array('Content-Type' => 'application/json', 'Authorization' => "Bearer $token");
    // }

    // public function initBill($amount, $merchant_reference, $description, $user, $redirect_uri=null) {
    //     $client = $this->getClient();

    //     $data = array(
    //         'amount' => $amount, 
    //         'merchant_reference' => $merchant_reference, 
    //         'description', $description, 
    //         'user' => $user, 
    //         "redirect_uri", $redirect_uri
    //     );
    //     $url = "api/v1/payments/bill/init/";
    //     $headers = $this->getAuthHeader();

    //     return $headers["Authorization"];

    //     $response = $client->post($url, [
    //         'headers' => $headers,
    //         'json' => $data
    //     ]);

    //     return $response->getBody();
    // }

    // public function verifyBill($code, $reference) {
    //     $client = $this->getClient();

    //     $data = array('reference' => $reference, 'code' => $code);
    //     $url = "api/v1/payments/bill/verify/";
    //     $headers = $this->getAuthHeader();

    //     $response = $client->post($url, [
    //         'headers' => $headers,
    //         'json' => $data
    //     ]);

    //     return $response->getBody();
    // }

    // public function cashinClient($bank_slug, $account, $amount, $merchant_reference, $description) {
    //     $client = $this->getClient();

    //     $data = array(
    //         'bank_slug' => $bank_slug, 
    //         'account' => $account, 
    //         'amount' => $amount, 
    //         'merchant_reference' => $merchant_reference, 
    //         'description' => $description
    //     );
    //     $url = "api/v1/payments/cash-in/";
    //     $headers = $this->getAuthHeader();

    //     $response = $client->post($url, [
    //         'headers' => $headers,
    //         'json' => $data
    //     ]);

    //     return $response->getBody();
    // }

    // public function getBanks() {
    //     $client = $this->getClient();
    //     $headers = array('Content-Type' => 'application/json');

    //     $url = "api/v1/bank/all";

    //     $response = $client->get($url, [
    //         'headers' => $headers,
    //     ]);

    //     return $response->getBody()->getContents();
    // }

}
