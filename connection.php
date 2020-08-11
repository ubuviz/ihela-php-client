<?php 
class Ihela_connection
{
    public $amount;
   $token
get_token(){
 $client = new GuzzleHttp\Client();
$res = $client->request('GET', 'https://testgate.ihela.online/oAuth2/token', [
    'auth' => ['4sS7OWlf8pqm04j1ZDtvUrEVSZjlLwtfGUMs2XWZ','HN7osYwSJuEOO4MEth6iNlBS8oHm7LBhC8fejkZkqDJUrvVQodKtO55bMr845kmplSlfK3nxFcEk2ryiXzs1UW1YfVP5Ed6Yw0RR6QmnwsQ7iNJfzTgeehZ2XM9mmhC3']
]);
echo $res->getStatusCode();
// "200"
echo $res->getHeader('content-type')[0];
// 'application/json; charset=utf8'
echo $res->getBody();
 token->$res;
 print('le token:'token);
 echo 'le token:'token;
}


init_bill(){

    $data = array('montant' => '$amount', 'key2' => 'value2');
    $url = 'https://testgate.ihela.online/api/v1/payments/bill/init';
     $headers = array('Content-Type' => 'application/json','Authorization'=> 'Bearer'token );

     $response = Requests::post($url, $headers, json_encode($data));
}


}
 ?>