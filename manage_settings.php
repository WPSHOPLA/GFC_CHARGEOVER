<?php
require_once('lib/init.php');

global $session_uid, $userClass, $mailClass, $userDetails, $mainClass;

if (!empty($_POST['action'])) {

    if ($_POST['action'] == 'activate_state') {
        $state_id = $_POST['state_id'];

        $data = ['status' => 1];

        $result = $mainClass->updateState_status($state_id, $data);

        if ($result)
            echo "success";
        else
            echo $result;

    } else if ($_POST['action'] == 'deactivate_state') {

        $state_id = $_POST['state_id'];

        $data = ['status' => 0];

        $result = $mainClass->updateState_status($state_id, $data);

        if ($result)
            echo "success";
        else
            echo $result;
    } else if ($_POST['action'] == 'remove_state') {

        $state_id = $_POST['state_id'];

        $result = $mainClass->remove_state($state_id);

        if ($result)
            echo "success";
        else
            echo $result;
    } else if ($_POST['action'] == 'update_state') {

        $state_id = $_POST['state_id'];
        $state_name = $_POST['state_name'];
        $state_short_name = $_POST['state_short_name'];
        $team_plan = $_POST['team_plan'];
        $team_price = $_POST['team_price'];
        $personal_plan = $_POST['personal_plan'];
        $personal_price = $_POST['personal_price'];

        $state_status = TRUE;

        if (empty($_POST['state_status'])) {
            $state_status = FALSE;
        }

        $state_data = array(
            'name' => $state_name,
            'short_name' => $state_short_name,
            'team_plan' => $team_plan,
            'team_price' => $team_price,
            'personal_plan' => $personal_plan,
            'personal_price' => $personal_price,
            'status' => $state_status
        );

        $result = $mainClass->updateState($state_id, $state_data);

        if ($result)
            echo "success";
        else
            echo $result;

    } else if ($_POST['action'] == 'create_state') {

        $state_name = $_POST['new_state_name'];
        $state_short_name = $_POST['new_state_short_name'];
        $team_plan = $_POST['new_team_plan'];
        $team_price = $_POST['new_team_price'];
        $personal_plan = $_POST['new_personal_plan'];
        $personal_price = $_POST['new_personal_price'];

        $state_status = TRUE;

        if (empty($_POST['new_state_status'])) {
            $state_status = FALSE;
        }

        $state_data = array(
            'name' => $state_name,
            'short_name' => $state_short_name,
            'team_plan' => $team_plan,
            'team_price' => $team_price,
            'personal_plan' => $personal_plan,
            'personal_price' => $personal_price,
            'status' => $state_status
        );

        $result = $mainClass->createState($state_data);

        if ($result)
            echo "success";
        else
            echo $result;
    }

}

?>
