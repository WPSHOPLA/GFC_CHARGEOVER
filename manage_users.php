<?php
require_once('lib/init.php');

global $session_uid, $userClass, $mailClass, $userDetails, $mainClass, $paymentClass;

if (!empty($_GET['action'])) {

    $action = $_GET['action'];

    if ($action == 'sync_users') {

        ini_set('max_execution_time', 300);

        $users = $userClass->getAllUsersInfo();

        $db = getDB();

        foreach ($users as $user) {
            $customer_id = $user['co_customer_id'];
            $user_id = $user['id'];
            $subscriptions = $paymentClass->getSubscriptions($customer_id);
            if ($subscriptions->status == "success") {

                $subscription = $subscriptions->subscriptions;

                if (isset($subscription[0])) {
                    $current_subscription = $subscription[0];
                    if ($current_subscription) {
                        $package_id = $current_subscription->package_id;
                        $sub_status = $current_subscription->package_status_state;
                        $userClass->updateSubscriptionInfo_with_db($db, $user_id, $sub_status, $package_id);
                    }
                } else {
                    $userClass->updateSubscriptionStatusInfo_with_db($db, $user_id, 'x');
                }
                continue;
            }
        }

        $db = null;

        ini_set('max_execution_time', 30);

        echo "success";

    } else if ($action == 'sync_user') {

        $user_id = $_GET['user_id'];
        $customer_id = $_GET['customer_id'];

        $subscriptions = $paymentClass->getSubscriptions($customer_id);

        if ($subscriptions->status == "success") {

            $subscription = $subscriptions->subscriptions;

            if (isset($subscription[0])) {
                $current_subscription = $subscription[0];

                if ($current_subscription) {
                    $package_id = $current_subscription->package_id;
                    $sub_status = $current_subscription->package_status_state;
                    $userClass->updateSubscriptionInfo($user_id, $sub_status, $package_id);
                    echo "success";
                    return;
                }
            }

            $userClass->updateSubscriptionStatusInfo($user_id, 'x');
            echo 'Subscription does not exist.';

        } else {
            echo 'Could not catch Subscription info for this user.';
        }
    } else if ($action == 'confirm_user') {
        //get code
        $code = $_GET['code'];
        $uid = base64_decode($code);

        $userDetails = $userClass->userDetails($uid);

        $username = $userDetails->username;
        $first_name = $userDetails->first_name;
        $last_name = $userDetails->last_name;
        $email = $userDetails->email;
        $phone = $userDetails->phone;
        $organization = $userDetails->org_name;

        $co_customer_id = $paymentClass->createCustomer($uid, $username, $first_name, $last_name, $email, $phone, $organization);

        if ($co_customer_id != -1) {

            $stmtt = $db->prepare("UPDATE users SET co_customer_id=:co_customer_id WHERE id=:id");
            $stmtt->bindParam("co_customer_id", $co_customer_id, PDO::PARAM_INT);
            $stmtt->bindParam("id", $uid, PDO::PARAM_INT);
            $stmtt->execute();

        }

        $_SESSION['uid'] = $uid;

        $url = BASE_URL . 'subscription_create.php';
        header("Location: $url"); // redirect to subscription create
        exit();
    } else if ($action == 'make_staff_user') {

        $user_id = $_GET['user_id'];
        $result = $userClass->update_as_staff($user_id);
        if ($result == true) {
            echo 'success';
        } else {
            echo $result;
        }

    } else if ($action == 'make_customer_user') {

        $user_id = $_GET['user_id'];
        $result = $userClass->update_as_customer($user_id);
        if ($result == true) {
            echo 'success';
        } else {
            echo $result;
        }

    } else if ($action == 'create_user') {

        $username = $_GET['username'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $password_2 = $_GET['password_2'];
        $first_name = $_GET['first_name'];
        $last_name = $_GET['last_name'];
        $phone = $_GET['phone'];
        $organization = $_GET['organization'];
        $invite_code = $_GET['invite_code'];

        /*$extra_users = $invited ? 0 : $_POST['extra_users'];
            if(isset($_POST['locations']) && is_array($_POST['locations'])) {
                foreach($_POST['locations'] as $location) {
                    $state_check = isset($mainClass->getStates()[$location - 1]);
                    if($state_check)
                        array_push($locations, $location);
                }
            }*/

        /*if(!$extra_users_check)
            $errorMsgExtraUsers = 'Invalid amount of extra users.';

        if(!$locations_check)
            $errorMsgLocation = 'You must select at least one location.';*/


        //if($username_check && $email_check && $password_check && $password == $password_2 && $extra_users_check && $locations_check) {

        if (!$invite_code) {
            //$userRegistration = $userClass->userRegistration($username, $password, $email, $extra_users, '');
            $userRegistration = $userClass->userRegistration($username, $password, $email, $first_name, $last_name, '', $phone, $organization);
        } else {
            //$userRegistration = $userClass->userRegistration($username, $password, $email, $extra_users, $invite_code);
            $userRegistration = $userClass->userRegistration($username, $password, $email, $first_name, $last_name, $invite_code, $phone, $organization);
        }

        if ($userRegistration === 'INVALID_EMAIL_ADDRESS') {
            $err_msg = 'Email is Invalid. Please use Valid Email.';
            echo $err_msg;

        } else if ($userRegistration === 'INVALID_INVITE_CODE') {
            $err_msg = 'Invite code is invalid.';
            echo $err_msg;
        } else if ($userRegistration === 'USERNAME_ALREADY_EXISTS') {
            $err_msg = 'Username is already in use.';
            echo $err_msg;
        } else if ($userRegistration === 'EMAIL_ALREADY_EXISTS') {
            $err_msg = 'Email is already in use.';
            echo $err_msg;

        } else if ($userRegistration) {
            /*
             $uid = $userRegistration;
              if(!$invited)
                $userClass->addSubscriptionLocations($uid, $locations);*/
            echo 'success';
        }

    }
}

?>
