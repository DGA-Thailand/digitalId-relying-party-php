<?php
require 'vendor/autoload.php';
require_once "Utility.php"; // EGA Utility
require_once "Config.php"; // config

session_start();

if(isset($_SESSION['idToken']) && !empty($_SESSION['idToken'])) {
	echo 'Set and not empty, and no undefined index error!';

	$idToken = $_SESSION['idToken'];
	//print_r($idToken);
	session_destroy();
	
	$issuer = $issuerURL;
	$cid = $clientID;
	$secret = Utility::prepareSecret($clientSecret);
	$oidc = new Jumbojett\OpenIDConnectClient($issuer, $cid, $secret);
	$oidc->setVerifyHost(false); // locally
	$oidc->setVerifyPeer(false); // locally


	$oidc->signOut($idToken, $logoutCallbackURL);

}
else
{
	
	?><a href="index.php">กลับหน้าหลัก</a><?php
}
?>