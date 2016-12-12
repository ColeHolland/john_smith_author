<?php
$c = curl_init('https://api.amazon.com/auth/o2/tokeninfo?access_token=' . urlencode($_REQUEST['access_token']));
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
 
$r = curl_exec($c);
curl_close($c);
$d = json_decode($r);
 
if ($d->aud != 'amzn1.application-oa2-client.be56c2f0c5e849a5b3c1f8568af7342f 
') {
  header('HTTP/1.1 404 Not Found');
  echo 'Page not found';
  exit;
}
 
// exchange the access token for user profile
$c = curl_init('https://api.amazon.com/user/profile');
curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: bearer ' . $_REQUEST['access_token']));
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
 
$r = curl_exec($c);
curl_close($c);
$d = json_decode($r);
 
echo sprintf('%s %s %s', $d->name, $d->email, $d->user_id);
?>