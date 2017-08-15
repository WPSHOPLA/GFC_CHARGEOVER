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

    }
}

?>
