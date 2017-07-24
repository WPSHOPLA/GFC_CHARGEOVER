<?php
require('lib/init.php');
requireLogin();
existSubscription();

$get_subscription = false;

$package_id = $userDetails->sub_id;

if($package_id)
{
    $subscriptions = $paymentClass->getSubscription($package_id);
    if ($subscriptions->status == "success") {

        if (count($subscriptions->subscription) > 0) {

            $currentSubscription = $subscriptions->subscription[0];

            $get_subscription = true;

            /*
            object(ChargeOverAPI_Object_Package)#15 (58) {
                ["terms_id"]=> int(3)
                ["class_id"]=> NULL
                ["admin_id"]=> NULL
                ["currency_id"]=> int(1)
                ["external_key"]=> NULL
                ["token"]=> string(12) "v94c5079od40"
                ["nickname"]=> string(0) ""
                ["paymethod"]=> string(3) "crd"
                ["paycycle"]=> string(3) "mon"
                ["bill_addr1"]=> NULL
                ["bill_addr2"]=> NULL
                ["bill_addr3"]=> NULL
                ["bill_city"]=> NULL
                ["bill_state"]=> NULL
                ["bill_postcode"]=> NULL
                ["bill_country"]=> NULL
                ["bill_notes"]=> NULL
                ["ship_addr1"]=> NULL
                ["ship_addr2"]=> NULL
                ["ship_addr3"]=> NULL
                ["ship_city"]=> NULL
                ["ship_state"]=> NULL
                ["ship_postcode"]=> NULL
                ["ship_country"]=> NULL
                ["ship_notes"]=> NULL
                ["creditcard_id"]=> int(174)
                ["ach_id"]=> NULL
                ["tokenized_id"]=> NULL
                ["custom_1"]=> NULL
                ["custom_2"]=> NULL
                ["custom_3"]=> NULL
                ["custom_4"]=> NULL
                ["custom_5"]=> NULL
                ["write_datetime"]=> string(19) "2017-07-19 10:58:42"
                ["mod_datetime"]=> string(19) "2017-07-19 10:58:42"
                ["start_datetime"]=> string(19) "2017-07-26 17:58:06"
                ["suspendfrom_datetime"]=> NULL
                ["suspendto_datetime"]=> NULL
                ["cancel_datetime"]=> NULL
                ["holduntil_datetime"]=> string(19) "2017-07-26 17:58:06"
                ["terms_name"]=> string(14) "Due on Receipt"
                ["terms_days"]=> int(0) ["currency_symbol"]=> string(1) "$"
                ["currency_iso4217"]=> string(3) "USD"
                ["amount_collected"]=> int(0)
                ["amount_invoiced"]=> int(0)
                ["amount_due"]=> int(0)
                ["is_overdue"]=> bool(false)
                ["days_overdue"]=> int(0)
                ["next_invoice_datetime"]=> string(19) "2017-07-26 17:58:06"
                ["cancel_reason"]=> NULL
                ["url_self"]=> string(59) "https://gofetchcode.chargeover.com/admin/r/package/view/344"
                ["package_id"]=> int(344)
                ["customer_id"]=> int(369)
                ["package_status_id"]=> int(1)
                ["package_status_name"]=> string(12) "Trial Period"
                ["package_status_str"]=> string(12) "active-trial"
                ["package_status_state"]=> string(1) "a" }
        */

            $sub_status_name = $currentSubscription->package_status_name;
            $sub_status_str = $currentSubscription->package_status_str;
            $sub_status_state = $currentSubscription->package_status_state;


// $package_status_state will be one of these 1-character states:
//  "a"      (active)
//  "c"      (cancelled)
//  "e"      (expired)
//  "s"      (suspended)

// $package_status_str will be one of these strings:
//   "active-trial"        (active package, in the free trial period still)
//   "active-current"      (active package, and payment is current)
//   "active-overdue"      (active package, payment is overdue)
//   "canceled-nonpayment" (cancelled, due to non-payment)
//   "canceled-manual"     (cancelled manually)
//   "expired-expired"     (expired)
//   "expired-trial"       (expired free trial)
//   "suspended-suspended" (suspended)


            $cards = $paymentClass->getCardByCustomerId($userDetails->co_customer_id)->card;

            /*
             *  ["creditcard_id"]=> int(176)
             *  ["external_key"]=> NULL
             *  ["type"]=> string(4) "visa"
             *  ["token"]=> string(12) "go1p8h01974m"
             *  ["expdate"]=> string(10) "2017-07-01"
             *  ["write_datetime"]=> string(19) "2017-07-20 12:06:07"
             *  ["write_ipaddr"]=> string(13) "209.95.60.158"
             *  ["mask_number"]=> string(13) "424242xxx4242"
             *  ["name"]=> string(13) "Taylor2 Milne"
             *  ["expdate_month"]=> string(1) "7"
             *  ["expdate_year"]=> string(4) "2017"
             *  ["expdate_formatted"]=> string(8) "Jul 2017"
             *  ["type_name"]=> string(4) "Visa"
             *  ["url_updatelink"]=> string(61) "https://gofetchcode.chargeover.com/r/paymethod/i/sp987t021nc1"
             *  ["customer_id"]=> int(374)
             * */

//$customer = $paymentClass->getCustomerById($userDetails->co_customer_id)->customer;
            /*
             * ["superuser_id"]=> int(372)
             * ["external_key"]=> string(57) "gfc_users_88_taylor2_taylor_milne1@outlook.com_1500570315"
             * ["token"]=> string(12) "sp987t021nc1"
             * ["company"]=> string(11) "HACKEN WORG"
             * ["bill_addr1"]=> NULL
             * ["bill_addr2"]=> NULL
             * ["bill_addr3"]=> NULL
             * ["bill_city"]=> NULL
             * ["bill_state"]=> NULL
             * ["bill_postcode"]=> NULL
             * ["bill_country"]=> NULL
             * ["bill_notes"]=> NULL
             * ["ship_addr1"]=> NULL
             * ["ship_addr2"]=> NULL
             * ["ship_addr3"]=> NULL
             * ["ship_city"]=> NULL
             * ["ship_state"]=> NULL
             * ["ship_postcode"]=> NULL
             * ["ship_country"]=> NULL
             * ["ship_notes"]=> NULL
             * ["terms_id"]=> int(3)
             * ["class_id"]=> NULL
             * ["custom_1"]=> NULL
             * ["custom_2"]=> NULL
             * ["custom_3"]=> NULL
             * ["custom_4"]=> NULL
             * ["custom_5"]=> NULL
             * ["custom_6"]=> NULL
             * ["admin_id"]=> NULL
             * ["campaign_id"]=> NULL
             * ["custtype_id"]=> NULL
             * ["currency_id"]=> int(1)
             * ["language_id"]=> int(1)
             * ["brand_id"]=> int(1)
             * ["no_taxes"]=> bool(false)
             * ["no_dunning"]=> bool(false)
             * ["write_datetime"]=> string(19) "2017-07-20 12:05:36"
             * ["write_ipaddr"]=> string(13) "209.95.60.158"
             * ["mod_datetime"]=> string(19) "2017-07-20 12:05:36"
             * ["mod_ipaddr"]=> string(13) "209.95.60.158"
             * ["terms_name"]=> string(14) "Due on Receipt"
             * ["terms_days"]=> int(0)
             * ["paid"]=> int(0)
             * ["total"]=> int(0)
             * ["balance"]=> int(0)
             * ["url_paymethodlink"]=> string(61) "https://gofetchcode.chargeover.com/r/paymethod/i/sp987t021nc1"
             * ["url_self"]=> string(60) "https://gofetchcode.chargeover.com/admin/r/customer/view/374"
             * ["admin_name"]=> string(0) ""
             * ["admin_email"]=> string(0) ""
             * ["currency_symbol"]=> string(1) "$"
             * ["currency_iso4217"]=> string(3) "USD"
             * ["display_as"]=> string(11) "HACKEN WORG"
             * ["ship_block"]=> string(0) ""
             * ["bill_block"]=> string(0) ""
             * ["superuser_name"]=> string(7) "taylor2"
             * ["superuser_first_name"]=> string(7) "taylor2"
             * ["superuser_last_name"]=> string(0) ""
             * ["superuser_phone"]=> string(0) ""
             * ["superuser_email"]=> string(25) "taylor_milne1@outlook.com"
             * ["superuser_token"]=> string(12) "b04t5iysu044"
             * ["customer_id"]=> int(374)
             * ["invoice_delivery"]=> string(5) "email"
             * ["dunning_delivery"]=> string(5) "email"
             * ["customer_status_id"]=> int(1)
             * ["customer_status_name"]=> string(7) "Current"
             * ["customer_status_str"]=> string(14) "active-current"
             * ["customer_status_state"]=> string(1) "a"
             * ["superuser_username"]=> string(12) "morzj51tn8ka"
             * ["tags"]=> array(0) { }
             * */

            if (count($cards) > 0) {
                $card = $cards[0];
                $card_type = $card->type_name;
                $card_number = $card->mask_number;
            }

            if ($sub_status_state == "a" || $sub_status_state == "s") {
                //show subscription Details
                $user_count = $userDetails->extra_users;
                $sub_type = ($user_count > 1) ? "Team" : "Individual";
                $billing_period = $paymentClass->getPayCycleName($currentSubscription->paycycle);

                $trial_start_date = date('F j, Y', strtotime($currentSubscription->write_datetime));
                $trial_end_date = date('F j, Y', strtotime($currentSubscription->start_datetime . '-1 day'));

                $bill_start_date = date('F j, Y', strtotime($currentSubscription->start_datetime));
                $bill_amount = $currentSubscription->amount_invoiced;

                $sub_suspended_date = date('F j,Y', strtotime($currentSubscription->suspendfrom_datetime));

                $customer_email = $userDetails->email;
                $next_billing_date = date('F j, Y', strtotime($currentSubscription->next_invoice_datetime));
                $currency = $currentSubscription->currency_iso4217;
                $package_id = $currentSubscription->package_id;

            } else if ($sub_status_state == "c") {
                $cancel_date_time = date('F j, Y', strtotime($currentSubscription->cancel_datetime));
            }


        }

    }
}

include('templates/default/header.php');

?>

    <div class="container-fluid content">
        <div class="main-container">
            <div class="row">

                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-12 sub_status">

                    <?php
                    if ($get_subscription) {
                        ?>
                        <div class="h1 highlight">Subscription Details</div>

                        <h4 class="mt50">Status: <?php echo $sub_status_name; ?></h4>

                        <?php if ($sub_status_state == "c") {
                            ?>

                            <?php
                            if (isset($_SESSION['first_cancel_sub']) && $_SESSION['first_cancel_sub'] == true) {
                                $_SESSION['first_cancel_sub'] = false;
                                ?>
                                <h5>Hello <?php echo $userDetails->username; ?></h5>
                                <h5>You are successfully unsubscribed.</h5>
                                <h5>We are continually working to improve our service. We would appreciate your feedback
                                    about
                                    why you have decided
                                    to end your subscription. Send us an email at info@gofetchcode.com</h5>

                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="feedback">Feedback:</label>
                                        <textarea rows="3" name="feedback" id="feedback_area"
                                                  title="feedback"></textarea>
                                        <button class="btn pri_button" id="feedback_bt">Send Feedback</button>
                                        <a href="subscription_create.php" class="btn pri_button">Reactivate
                                            Subscription</a>
                                    </div>
                                </div>
                                <div class="mt50">
                                    <div id="err_msg" class="text-warning"></div>
                                </div>
                            <?php } else { ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Cancelled At</label>
                                    </div>
                                    <div class="col-md-8 text-info">
                                        <?php echo $cancel_date_time; ?>
                                    </div>
                                </div>
                                <br>
                                <br>

                                <a href="subscription_create.php" class="btn pri_button pull-left">Reactivate
                                    Subscription</a>

                            <?php }

                        } else { ?>

                            <div class="sub_info mt50">


                                <?php if ($sub_status_state == 's') { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Suspended From</label>
                                        </div>
                                        <div class="col-md-8 text-info">
                                            <?php echo $sub_suspended_date; ?>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                <?php } ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Subscription Type</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $sub_type; ?>
                                    </div>
                                </div>

                                <input type="hidden" name="package_id" value="<?php echo $package_id; ?>"
                                       id="package_id">

                                <?php
                                if ($user_count > 1) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Team Size</label>
                                        </div>
                                        <div class="col-md-8">
                                            <?php echo $user_count; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Billing Period</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $billing_period; ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <?php if ($sub_status_str == "active-trial") { ?>
                                            <label>Trial Period Starts On</label>
                                        <?php } else { ?>
                                            <label>Trial Period Started On</label>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $trial_start_date; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php if ($sub_status_str == "active-trial") { ?>
                                            <label>Trial Period Ends On</label>
                                        <?php } else { ?>
                                            <label>Trial Period Ended On</label>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $trial_end_date; ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Billing Starts On</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $bill_start_date; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Monthly Billing Amount</label>
                                    </div>
                                    <div
                                        class="col-md-8 text-uppercase"><?php echo $currency . ' ' . $bill_amount; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Card Type</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $card_type; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Card Number</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $card_number; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Customer Email</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $customer_email; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Next Billing Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $next_billing_date; ?>
                                    </div>
                                </div>


                            </div>
                            <div class="mt50">
                                <?php if ($sub_status_state == "a" || $sub_status_state == "e") { ?>
                                    <a href="subscription_update.php" class="btn pri_button"
                                       id="update_sub_bt">Update</a>
                                <?php } ?>
                                <?php if ($sub_status_state == "a") { ?>
                                    <button class="btn sec_button" id="suspend_sub_bt">Suspend</button>
                                <?php } ?>
                                <?php if ($sub_status_state == "a" || $sub_status_state == "s" || $sub_status_state == "e") { ?>
                                    <button class="btn thr_button" id="cancel_sub_bt">Cancel</button>
                                <?php } ?>
                            </div>

                            <div class="mt50">
                                <div id="err_msg" class="text-warning"></div>
                            </div>

                        <?php } ?>

                    <?php } else { ?>

                        <div class="text-center">
                            <div class="h1 highlight"> OOPS</div>
                            <p>While getting your subscription Info, Error Occurred.<br> Please try again Later.</p>
                        </div>

                    <?php } ?>
                </div>

            </div>
        </div>
    </div>


    <script>


        $('#suspend_sub_bt').click(function () {

            var package_id = $('#package_id').val();

            var data = "suspend_subscription=1&package_id=" + package_id;

            $.ajax({
                url: 'subscription_manage.php',
                method: "POST",
                data: data,
                success: function (response) {

                    if (response == "success") {
                        location.reload();
                    } else {
                        $('#err_msg').text(response).fadeIn(1000).delay(2000).fadeOut(2000);
                    }
                },
                error: function () {
                    console.log(response);
                    var err_msg = "Problem Occurred. Please try again later.";
                    $('#err_msg').text(response).fadeIn(1000).delay(2000).fadeOut(2000);
                }
            });
        });


        $('#cancel_sub_bt').click(function () {

            $.confirm({
                title: 'Cancel Subscription',
                content: 'Are you sure you want to cancel the subscription?',
                buttons: {
                    Continue: {
                        text: "Yes",
                        btnClass: "btn-primary pri-button",
                        action: function () {
                            var package_id = $('#package_id').val();

                            var data = "cancel_subscription=1&package_id=" + package_id;

                            $.ajax({
                                url: 'subscription_manage.php',
                                method: "POST",
                                data: data,
                                success: function (response) {

                                    if (response == "success") {
                                        location.reload();
                                    } else {
                                        $('#err_msg').text(response).fadeIn(1000).delay(2000).fadeOut(2000);
                                    }
                                },
                                error: function () {
                                    console.log(response);
                                    var err_msg = "Problem Occurred. Please try again later.";
                                    $('#err_msg').text(response).fadeIn(1000).delay(2000).fadeOut(2000);
                                }
                            });
                        }
                    },
                    Cancel: {
                        text: "No",
                        btnClass: "btn-dark",
                        action: function () {
                            window.location = "search.php";
                        }
                    }
                }
            });
        });

        $('#feedback_bt').click(function () {
            var feed_text = $("#feedback_area").val();
            if (!feed_text) {
                $('#feedback_area').focus();
                return;
            }

            var data = new FormData();
            data.append('send_feedback', '1');
            data.append('feedback', feed_text);

            $.ajax({
                url: 'subscription_manage.php',
                type: "POST",
                processData: false,
                contentType: false,
                data: data,
                success: function (response) {
                    if (response == "success") {
                        var err_msg = "Thanks for your feedback.";
                        $('#err_msg').text(err_msg).fadeIn(1000).delay(2000).fadeOut(2000);
                        //window.location = "search.php";
                    } else {
                        $('#err_msg').text(response).fadeIn(1000).delay(2000).fadeOut(2000);
                    }
                },
                error: function () {
                    var err_msg = "Problem Occurred. Please try again later.";
                    $('#err_msg').text(err_msg).fadeIn(1000).delay(2000).fadeOut(2000);
                }
            })

        })
    </script>


<?php include('templates/default/footer.php'); ?>