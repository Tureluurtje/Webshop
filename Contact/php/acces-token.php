<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

session_start();

$clientID = 'YOUR_CLIENT_ID';
$clientSecret = 'YOUR_CLIENT_SECRET';
$redirectUri = 'http://abcd1234.ngrok.io';

$provider = new Google([
    'clientId'     => $clientID,
    'clientSecret' => $clientSecret,
    'redirectUri'  => $redirectUri,
    'scopes'       => ['https://mail.google.com/'],
]);

if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Save the token for future use
    $_SESSION['access_token'] = $token->getToken();
    $_SESSION['refresh_token'] = $token->getRefreshToken();
    $_SESSION['expires'] = $token->getExpires();
    echo 'Access Token: ' . $token->getToken();
}
?>
