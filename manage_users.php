<?php
require_once('lib/init.php');

global $session_uid, $userClass, $mailClass, $userDetails, $mainClass, $paymentClass;

if (!empty($_POST['action'])) {

    if ($_POST['action'] == 'sync_users') {

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

    } else if ($_POST['action'] == 'sync_user') {

        $user_id = $_POST['user_id'];
        $customer_id = $_POST['customer_id'];

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
    }
}

?>
