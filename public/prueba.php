<?php
/*
  0. https://developers.google.com/google-apps/spreadsheets/
  1. https://github.com/asimlqt/php-google-spreadsheet-client
  2. https://github.com/google/google-api-php-client

  En el 0 esta la documentacion. En php no hay libreria pero especifican un protocolo de comunicacion en XML con
          peticiones autenticadas get, put, post y delete.

  El paquete 1 implementa la libreria para leer de la Excel (segun el protocolo)
               Pero necesita un accessToken obtnido por Oauth 2

  El paquete 2, es el api client que vimos el jueves, que hay que usar para obtener el access token.
                hacer un login y obtener el accessToken.
                �Podemos saltarnos este paso haciendo publico el doc?

  ------------
  Uri de retorno: http://www.timeline-cta.com/oauth2callback?code=4/c-Qu41DASRruuopY9_nU4GMT8o4eZw54Nx7az-bQNPc.ch-hC-iap8MfoiIBeO6P2m8Wt__vkwI
*/

require '../vendor/autoload.php';
require '../modules/Application/src/Application/models/GoogleSheets.php';

session_start();

if (strpos($_SERVER['REQUEST_URI'], 'oauth2callback') !== false) {
    // pr($_SERVER);
    // pr($_GET);
    // pr($_POST);
}

$client_id = '1029901711600-rm1a0nj2noeghdmivv8d15hq1hj0maqv.apps.googleusercontent.com';
$client_secret = 'T8Kde4V0p-7IwHk9-Yek_RjM';
$redirect_uri = 'http://www.timeline-cta.com/oauth2callback';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes('https://spreadsheets.google.com/feeds');

if (isset($_GET['code']) && $_GET['code']) {
    $code = $_GET['code'];
    $client->authenticate($code);
    $accessToken = $client->getAccessToken();
    $_SESSION['accessToken'] = $accessToken;

    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));

} elseif (isset($_SESSION['accessToken'])) {
    $accessToken = $_SESSION['accessToken'];
    $client->setAccessToken($accessToken);
    if ($client->isAccessTokenExpired()) {
        unset($_SESSION['accessToken']);
        unset($accessToken);
    }
}

if (!isset($accessToken)) {
    $authUrl = $client->createAuthUrl();
    echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
    die;
}
$token = json_decode($accessToken);

$googleSheets = new GoogleSheets($token->access_token, 'TimelineSheet', 'Sheet1');

// listado
$rows = $googleSheets->getRows();
pr($rows);

// Insert
$row = array(
    'startdate' => '11/30/2014 10:00:00',
    'enddate'   => '12/15/2014 23:00:00',
    'headline' => 'Lorem ipsum dolor',
    'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent efficitur congue ligula sodales pellentesque.',
    'media' => 'http://www.flickr.com/photos/zachwise/6115056146/in/photostream',
    'mediacredit' => 'Emilio',
    'mediacaption' => 'By CTA',
    'mediathumbnail' => '',
    'type' => 'title',
    'tag' => 'tag1, tag2',
    'id' => null
);
#$row = $googleSheets->insert($row);
die("inserted!");

// Update
$id = '14173470006272';
$row = array(
    'mediacredit' => 'Emilio',
    'mediacaption' => 'By CTA 2',
);
#$row = $googleSheets->update($id, $row);
die("updated!");


// Delete
$id = '14173469977248';
#$googleSheets->delete($id);
die("deleted!");


function pr($data, $die = false) {
    echo("<pre>"); print_r($data); echo("</pre>");
    if ($die) die();
}