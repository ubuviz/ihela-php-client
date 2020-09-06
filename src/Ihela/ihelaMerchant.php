<?php 
namespace Ihela;


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
            $this->_api_url = 'https://testgate.ihela.online';
            // $this->_api_url = 'http://127.0.0.1:8080';
        }

        $this->_client_id = $client_id;
        $this->_client_secret = $client_secret;

        // Here we get the token for all calls
        $this->authenticate();
    }

    /**
    Authenticates the merchant application in iHela
    */
    protected function authenticate() {
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
        $this->_auth_token_object = json_decode($response, true);
    }

    // protected function getAuthHeader() {
    //     $token = $this->getToken();

    //     return array('Content-Type' => 'application/json', 'Authorization' => "Bearer $token");
    // }

    public function initBill($amount, $merchant_reference, $description, $user, $redirect_uri=null) {
        $url = $this->_api_url .'/'. self::IHELA_ENDPOINTS["BILL_INIT"];
        $payload =json_encode( array(
            'amount' => $amount, 
            'merchant_reference' => $merchant_reference, 
            'description', $description, 
            'user' => $user, 
            "redirect_uri", $redirect_uri
        ));

        $curl = \curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization:Token '.$this->_auth_token_object["access_token"]),
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

    public function verifyBill($code, $reference) {

        $url = $this->_api_url .'/'. self::IHELA_ENDPOINTS["BILL_VERIFY"];
        $payload =json_encode( array('reference' => $reference, 'code' => $code));

        $curl = \curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization:Token '.$this->_auth_token_object["access_token"]),
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $payload,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);

    }

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

    public function getBanks() {

        $url = $this->_api_url .'/'. self::IHELA_ENDPOINTS["BANKS_ALL"];

        $curl = \curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization:Token '.$this->_auth_token_object["access_token"]),
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);

    }

}
