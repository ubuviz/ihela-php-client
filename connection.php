<?php 
use GuzzleHttp\Client;

class IhelaConnection
{
    protected $_token;
    protected $_client;
    protected $_api_url;

    public function __construct($client_id, $client_secret, $test) {
		if ($test) {
			$this->_api_url = 'https://testgate.ihela.online';
		} else {
			$this->_api_url = 'https://api.ihela.online';
		}

		// Here we get the token for all calls
	    $this->setClient();
	    $this->setToken($client_id, $client_secret);
	}

	protected function setClient() {
    	$this->_client = new Client('base_uri' => $this->_api_url);
    }

    protected function getClient() {
    	return $this->_client;
    }

    protected function setToken($client_id, $client_secret) {
		$client = $this->getClient();

		$headers = array('Content-Type' => 'application/json')
		$res = $client->post("oAuth2/token", [
		    'auth' => [$client_id, $client_secret], 'headers' => $headers, 'json': ['grant_type' => 'client_credentials']
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

	    $data = array('amount' => $amount, 'merchant_reference' => $merchant_reference, 'description', $description, 'user': $user, "redirect_uri", $redirect_uri);
	    $url = "api/v1/payments/bill/init";
	    $headers = array('Content-Type' => 'application/json','Authorization'=> "Bearer $this->getToken()");

	    $response = $client->post($url, $headers, [
	    	'headers' => $headers,
    		'json' => $data
		]);
	}


}

