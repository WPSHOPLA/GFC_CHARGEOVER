<?php
include('lib/config.php');
include('lib/session.php');

include('lib/classes/mailClass.php');
include('lib/classes/mainClass.php');
include('lib/classes/documentClass.php');
include('lib/classes/userClass.php');
include('lib/classes/questionClass.php');
include('lib/classes/searchClass.php');
include('lib/classes/paymentClass.php');
include('lib/classes/logClass.php');

$mailClass = new mailClass();
$mainClass = new mainClass();
$documentClass = new documentClass();
$userClass = new userClass();
$questionClass = new questionClass();
$searchClass = new searchClass();
$paymentClass = new paymentClass();
$logClass = new logClass();

if(isLoggedIn())
	loadUserDetails();



/*----------------------------*/

function loadUserDetails() {
	global $userClass, $session_uid, $userDetails;
	$userDetails = $userClass->userDetails($session_uid);
}

function isLoggedIn() {
	global $session_uid;
	if($session_uid == -1)
		return false;
	else
		return true;
}

function requireLogin() {
	if(!isLoggedIn())	{
		$url = BASE_URL . 'login.php';
		header("Location: $url");
		exit();
	}
}

function isSubscribed() {
	global $userClass, $userDetails;
	
	if(isStaff())
		return true;
	
	if(!isLoggedIn())
		return false;
	
	$dateNow = date('Y-m-d H:i:s');
	$timeStampNow = strtotime($dateNow);
		
	if($userDetails->owner_id > 0)
		$timeStampUntil = strtotime($userClass->userDetails($userDetails->owner_id)->co_subscribed_until);
	else
		$timeStampUntil = strtotime($userDetails->co_subscribed_until);

	return $timeStampUntil > $timeStampNow;
}

function requireSubscription() {
//	return 1;
	requireLogin();
	if(!isSubscribed()) {
		$url = BASE_URL . 'account_billing.php';
		header("Location: $url");
		exit();
	}
}

function isStaff() {
	global $userClass, $userDetails;
	
	if(!isLoggedIn())
		return false;
	
	if(isSubAccount())
		return $userClass->userDetails($userDetails->owner_id)->access == 100;
	
	return $userDetails->access == 100;
}

function requireStaff() {
	requireLogin();
	if(!isStaff()) {
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		exit();
	}
}

function isSubAccount() {
	global $userDetails;
	if(!isLoggedIn())
		return false;
	
	return $userDetails->owner_id > -1;
}

function requireNotSubAccount() {
	requireLogin();
	if(isSubAccount()) {
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		exit();
	}
}
?>