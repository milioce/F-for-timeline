<?php

$client_id = '1029901711600-rm1a0nj2noeghdmivv8d15hq1hj0maqv.apps.googleusercontent.com';
$client_secret = 'T8Kde4V0p-7IwHk9-Yek_RjM';
$redirect_uri = 'http://www.timeline-cta.com/google/callback';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes('https://spreadsheets.google.com/feeds');

$token = null;

if (isset($_GET['code']) && $_GET['code']) {
    try {
        $client->authenticate($_GET['code']);
        $accessToken = $client->getAccessToken();
        $_SESSION['accessToken'] = $accessToken;
        
        $redirect = 'http://' . $_SERVER['HTTP_HOST'];
        header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    } catch (Exception $e) {
    }    
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
