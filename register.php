<?php

require('lib/init.php');

if (isLoggedIn()) {
    $url = BASE_URL . 'index.php';
    header("Location: $url"); // Page redirecting to home.php
    exit();
}

$errorMsgUsername = '';
$errorMsgPassword = '';
$errorMsgPassword2 = '';
$errorMsgEmail = '';
$errorMsgFirstName = '';
$errorMsgLastName = '';
$errorMsgExtraUsers = '';
$errorMsgLocation = '';
$errorMsgPhone = '';
$errorMsgOrg = '';

$notifyMsgRegister = '';

$username = '';
$password = '';
$password_2 = '';
$email = '';
$first_name = '';
$last_name = '';
$phone = '';
$organization = '';
//$locations = [];
//$extra_users = 0;

//$extra_users_tiers = $mainClass->getExtraUsersTiers();

$invite_code = isset($_GET['invite_code']) ? $_GET['invite_code'] : '';
$invited = $invite_code != '' ? true : false;

if ($invited) {
    $invite_info = $userClass->getInviteInfo($invite_code);

    $email = $invite_info->email;
    $first_name = $invite_info->first_name;
    $last_name = $invite_info->last_name;
}

if (!empty($_POST['register_submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_2 = $_POST['password_2'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $organization = $_POST['organization'];

    /*$extra_users = $invited ? 0 : $_POST['extra_users'];

    if(isset($_POST['locations']) && is_array($_POST['locations'])) {
        foreach($_POST['locations'] as $location) {
            $state_check = isset($mainClass->getStates()[$location - 1]);
            if($state_check)
                array_push($locations, $location);
        }
    }*/

    /* Regular expression check */
    $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
    $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,10})$~i', $email);
    $first_name_check = preg_match('~^[A-Za-z0-9_]{2,30}$~i', $first_name);
    $last_name_check = preg_match('~^[A-Za-z0-9_]{1,30}$~i', $last_name);
    $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,10})$~i', $email);
    $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);
    $phone_check = preg_match('~^[0-9-() ]{10,20}$~i', $phone);
    $organization_check = preg_match('~^[A-Za-z0-9_ ]{8,30}$~i', $organization);
    //$extra_users_check = in_array($extra_users, $extra_users_tiers);
    //$locations_check = sizeof($locations) > 0 || $invited;

    if (!$username_check)
        $errorMsgUsername = 'Username must be between 3 and 20 characters.';

    if (!$email_check)
        $errorMsgEmail = 'Invalid Email.';

    if (!$password_check)
        $errorMsgPassword = 'Password must be between 6 and 20 characters.';

    if (!$first_name_check)
        $errorMsgFirstName = 'Must be 2 characters or longer.';

    if (!$last_name_check)
        $errorMsgLastName = 'Must be 1 characters or longer.';

    if ($password != $password_2)
        $errorMsgPassword2 = 'Confirmation password does not match.';

    if (!$phone_check)
        $errorMsgPhone = 'Must be 10 numbers at least.';

    if (!$organization_check)
        $errorMsgOrg = 'Must be 8 characters at least.';


    /*if(!$extra_users_check)
        $errorMsgExtraUsers = 'Invalid amount of extra users.';

    if(!$locations_check)
        $errorMsgLocation = 'You must select at least one location.';*/

    //if($username_check && $email_check && $password_check && $password == $password_2 && $extra_users_check && $locations_check) {
    if ($username_check && $email_check && $password_check && $first_name_check && $last_name_check && $password == $password_2 && $organization_check && $phone_check) {
        if (!$invited) {
            //$userRegistration = $userClass->userRegistration($username, $password, $email, $extra_users, '');
            $userRegistration = $userClass->userRegistration($username, $password, $email, $first_name, $last_name, '', $phone, $organization);
        } else {
            //$userRegistration = $userClass->userRegistration($username, $password, $email, $extra_users, $invite_code);
            $userRegistration = $userClass->userRegistration($username, $password, $email, $first_name, $last_name, $invite_code, $phone, $organization);
        }


        if ($userRegistration === 'INVALID_INVITE_CODE') {
            $notifyMsgRegister = $mainClass->alert('error', 'Invite code is invalid.');
        } else if ($userRegistration === 'USERNAME_ALREADY_EXISTS') {
            $errorMsgUsername = 'Username is already in use.';
        } else if ($userRegistration === 'EMAIL_ALREADY_EXISTS') {
            $errorMsgEmail = 'Email is already in use.';
        } else if ($userRegistration) {
            $uid = $userRegistration;

            /*if(!$invited)
                $userClass->addSubscriptionLocations($uid, $locations);*/

            $url = BASE_URL . 'end_signup.php';
            header("Location: $url"); // Page redirecting to login.php
            exit();
        }
    }
}

include('templates/default/header.php');
?>
    <div class="container-fluid content form-only-content">
        <div class="main-container">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <div class="login-form">
                    <?php echo $notifyMsgRegister; ?>

                    <?php
                    if ($invited && !$invite_info) {
                        echo '<div class="search-examples"><center><p><b>Invalid invite link</b></p></center></div>';
                    } else {
                        if ($invited && $invite_info) {
                            $ownerDetails = $userClass->userDetails($invite_info->user_id);
                            echo '<div class="search-examples"><center><p><b>Join ' . $ownerDetails->first_name . ' ' . $ownerDetails->last_name . '\'s team</b></p></center></div>';
                        }
                        ?>

                        <div class="h1 text-blue">Sign Up</div>

                        <p class="text-info">
                            GoFetchCode provides answers to your Building Code-related questions in a snap.
                            <br>As soon as you fill in the form on this page and subscribe, your free trial account will
                            start.
                            After 7 days, simply subscribe to one of our paid plans and keep using GoFetchCode for
                            your building code needs.
                            <br>Register now and get immediate and free access to the GoFetchCode search engine.
                        </p>

                        <form name="form" method="post">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group<?php if ($errorMsgFirstName != '') echo ' has-error'; ?>">
                                        <?php if ($errorMsgFirstName != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgFirstName . '</li></ul></span>'; ?>
                                        <input type="text" name="first_name"
                                               value="<?php echo htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8'); ?>"
                                               class="form-control" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group<?php if ($errorMsgLastName != '') echo ' has-error'; ?>">
                                        <?php if ($errorMsgLastName != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgLastName . '</li></ul></span>'; ?>
                                        <input type="text" name="last_name"
                                               value="<?php echo htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'); ?>"
                                               class="form-control" placeholder="Last Name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group<?php if ($errorMsgUsername != '') echo ' has-error'; ?>">
                                <?php if ($errorMsgUsername != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgUsername . '</li></ul></span>'; ?>
                                <input type="text" name="username"
                                       value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"
                                       class="form-control" placeholder="Username" required>
                            </div>

                            <div class="form-group<?php if ($errorMsgPassword != '') echo ' has-error'; ?>">
                                <?php if ($errorMsgPassword != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgPassword . '</li></ul></span>'; ?>
                                <input type="password" name="password"
                                       value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>"
                                       class="form-control" placeholder="Password" required>
                            </div>

                            <div class="form-group<?php if ($errorMsgPassword2 != '') echo ' has-error'; ?>">
                                <?php if ($errorMsgPassword2 != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgPassword2 . '</li></ul></span>'; ?>
                                <input type="password" name="password_2"
                                       value="<?php echo htmlspecialchars($password_2, ENT_QUOTES, 'UTF-8'); ?>"
                                       class="form-control" placeholder="Confirm Password" required>
                            </div>

                            <div class="form-group<?php if ($errorMsgEmail != '') echo ' has-error'; ?>">
                                <?php if ($errorMsgEmail != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgEmail . '</li></ul></span>'; ?>
                                <input type="email" name="email"
                                       value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"
                                       class="form-control" placeholder="Email" required>
                            </div>

                            <div class="form-group<?php if ($errorMsgPhone != '') echo ' has-error'; ?>">
                                <?php if ($errorMsgPhone != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgPhone . '</li></ul></span>'; ?>
                                <input type="text" name="phone"
                                       value="<?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?>"
                                       class="form-control" placeholder="Phone" required>
                            </div>

                            <div class="form-group<?php if ($errorMsgOrg != '') echo ' has-error'; ?>">
                                <?php if ($errorMsgOrg != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgOrg . '</li></ul></span>'; ?>
                                <input type="text" name="organization"
                                       value="<?php echo htmlspecialchars($organization, ENT_QUOTES, 'UTF-8'); ?>"
                                       class="form-control" placeholder="Organization" required>
                            </div>

                            <?php if (false && !$invited) { ?>
                                <div class="form-group<?php if ($errorMsgExtraUsers != '') echo ' has-error'; ?>">
                                    <label>Amount of sub-accounts(for teams)</label>
                                    <?php if ($errorMsgExtraUsers != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgExtraUsers . '</li></ul></span>'; ?>
                                    <select name="extra_users" class="form-control">
                                        <?php
                                        foreach ($extra_users_tiers as $tier) {
                                            $selected = $extra_users == $tier ? ' selected' : '';
                                            echo '<option value="' . $tier . '"' . $selected . '>' . $tier . '</option>';
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group<?php if ($errorMsgLocation != '') echo ' has-error'; ?>">
                                    <label>Locations</label>
                                    <?php if ($errorMsgLocation != '') echo '<span class="help-block with-errors"><ul class="list-unstyled"><li>' . $errorMsgLocation . '</li></ul></span>'; ?>
                                    <div class="form-control">
                                        <?php
                                        foreach ($mainClass->getStates() as $state) {
                                            if ($state['id'] != 5 && $state['id'] != 10)
                                                continue;

                                            echo '<label class="col-sm-6 col-md-6"><input type="checkbox" name="locations[]" value="' . $state['id'] . '">' . $state['name'] . '</label>';
                                        }
                                        ?>
                                    </div>
                                </div>

                            <?php } ?>

                            <div class="form-group">
                                <label><input type="checkbox" id="agree">&emsp; I agree to <a href="termsofservice.php"
                                                                                              target="_blank">GofetchCode
                                        Terms and Conditions</a></label>
                            </div>

                            <div class="form-actions form-group ">
                                <input type="submit" name="register_submit" class="pri_button full-width" disabled
                                       id="signup_submit"
                                       value="Sign up for free trial">
                            </div>

                        </form>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        $('#agree').change(function () {

            var checked = $(this).prop('checked');

            if (checked) {
                $('#signup_submit').prop('disabled', false);
            } else {
                $('#signup_submit').prop('disabled', true);
            }
        });
    </script>


<?php include('templates/default/footer.php'); ?>