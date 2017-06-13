<?php
$client_id = 'Your client id';
$client_secret = 'Your client secret';
$redirect_uri = 'http://localhost/photoapp';
$scope = 'basic+likes+comments+relationships';

$url = "https://api.instagram.com/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&response_type=code";

if(!isset($_GET['code']))
{
    echo '<a href="'.$url.'">Login With Instagram</a>';
}
else
{
    $code = $_GET['code'];
$apiData = array(
  'client_id'       => $client_id,
  'client_secret'   => $client_secret,
  'grant_type'      => 'authorization_code',
  'redirect_uri'    => $redirect_uri,
  'code'            => $code
);

$apiHost = 'https://api.instagram.com/oauth/access_token';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiHost);
curl_setopt($ch, CURLOPT_POST, count($apiData));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
$jsonData = curl_exec($ch);
curl_close($ch);
echo "<pre>";
$array = json_decode($jsonData, true);
echo $array['access_token'];
echo "<br/>";
$relationships = 'https://api.instagram.com/v1/users/self/followed-by?access_token='.$array['access_token'];
$c = curl_init();
curl_setopt($c, CURLOPT_URL, $relationships);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($c,CURLOPT_SSL_VERIFYHOST, false);
$data = curl_exec($c);
curl_close($c);
print_r($data);
}
?>
