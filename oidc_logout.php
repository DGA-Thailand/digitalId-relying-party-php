<?php
require 'vendor/autoload.php';
require_once "Utility.php"; // EGA Utility

session_start();
if(isset($_SESSION['idToken']) && !empty($_SESSION['idToken'])) {
	echo 'Set and not empty, and no undefined index error!';

	$idToken = $_SESSION['idToken'];
	//print_r($idToken);
	session_destroy();
	
	$issuer = 'https://connect.dga.or.th';
	$cid = '89ee233d-0dbc-4f28-91f3-17772220cd76';
	$secret = Utility::prepareSecret('G7kI60eI2Vr'); //'147b050283319c41ea68d6c6dbd7b003';
	$oidc = new Jumbojett\OpenIDConnectClient($issuer, $cid, $secret);
	$oidc->setRedirectURL('http://localhost:8090/oidc_client/oidc_login.php');
	$oidc->setVerifyHost(false); // locally
	$oidc->setVerifyPeer(false); // locally


	$oidc->signOut($idToken, "http://localhost:8090/oidc_client/oidc_logout.php");

}
else
{
	
	?>ออกจากระบบเรียบร้อย <a href="http://localhost:8090/oidc_client/index.php">กลับหน้าหลัก</a><?php
}
?>