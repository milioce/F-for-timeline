<?php
session_start();

$client_id = '1029901711600-rm1a0nj2noeghdmivv8d15hq1hj0maqv.apps.googleusercontent.com';
$client_secret = 'T8Kde4V0p-7IwHk9-Yek_RjM';
$redirect_uri = 'http://www.timeline-cta.com/oauth2callback';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes('https://spreadsheets.google.com/feeds');

$code = $_GET['code'];
var_dump($code); die;

$client->authenticate($code);
$accessToken = $client->getAccessToken();
$_SESSION['accessToken'] = $accessToken;

$redirect = 'http://' . $_SERVER['HTTP_HOST'];
header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
break;
    
