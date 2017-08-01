<?php
require('lib/init.php');
requireLogin();

if (!isStaff()) {
    $url = BASE_URL . 'index.php';
    header("Location: $url");
    exit();
}

global $userClass;

$users = $userClass->getAllUsersInfo_first_staff();
$user_count = count($users);

include('templates/default/header.php');
?>
    <div class="container-fluid content">
        <div class="main-container">
            <div class="row-fluid">
                <div class="col-md-6 col-md-offset-3">

                    <form id="create_form" class="sub_form" method="POST" action="manage_settings.php"
                          style="display: none">

                        <input type="hidden" name="action" value="create_state">

                        <div class="h3 text-blue">Add New State</div>

                        <div class="panel-body">

                            <div class="row form-group">
                                <label class="col-md-4" for="new_state_name">STATE NAME*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="new_state_name" value="" required
                                           placeholder="Florida"
                                           id="new_state_name"/>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4" for="new_state_short_name">STATE SHORT NAME*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="new_state_short_name" value=""
                                           placeholder="FL"
                                           required id="new_state_short_name"/>
                                </div>
                            </div>


                            <div class="row form-group">
                                <label class="col-md-4" for="new_team_price">TEAM PRICE*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="number" step="0.01" name="new_team_price" value=""
                                           placeholder="20.00"
                                           required id="new_team_price"/>
                                </div>
                            </div>


                            <div class="row form-group">
                                <label class="col-md-4" for="new_personal_price">PERSONAL PRICE*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="number" step="0.01" name="new_personal_price"
                                           placeholder="20.00"
                                           value="" required id="new_personal_price"/>
                                </div>
                            </div>


                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="new_state_status">STATUS*</label>

                                </div>
                                <div class="col-md-6">
                                    <div class="squaredOne">
                                        <input class="location_check location" id="new_state_status"
                                               name="new_state_status" type="checkbox" checked>
                                        <label for="new_state_status"></label>
                                    </div>
                                    <p class="text-info  location_label">
                                        Only Active State can be used for Subscription
                                    </p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="form-control pri_button" type="submit">ADD</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="form-control sec_button" type="button"
                                                    onclick="hide_form(this)">CANCEL
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>

                    <form id="edit_form" class="sub_form" method="POST" action="manage_settings.php"
                          style="display: none">

                        <input type="hidden" name="action" value="update_state">

                        <div class="h3 text-blue">Edit State</div>

                        <div class="panel-body">

                            <div class="row form-group">
                                <label class="col-md-4" for="state_id">ID</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" required name="state_id" readonly value=""
                                           id="state_id"/>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4" for="state_name">STATE NAME*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="state_name" value="" required
                                           placeholder="Florida"
                                           id="state_name"/>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4" for="state_short_name">STATE SHORT NAME*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="state_short_name" value=""
                                           placeholder="FL"
                                           required id="state_short_name"/>
                                </div>
                            </div>


                            <div class="row form-group">
                                <label class="col-md-4" for="team_price">TEAM PRICE*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="number" step="0.01" name="team_price" value=""
                                           placeholder="20.00"
                                           required id="team_price"/>
                                </div>
                            </div>


                            <div class="row form-group">
                                <label class="col-md-4" for="personal_price">PERSONAL PRICE*</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="number" step="0.01" name="personal_price"
                                           placeholder="20.00"
                                           value="" required id="personal_price"/>
                                </div>
                            </div>


                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="new_state_status">STATUS*</label>

                                </div>
                                <div class="col-md-6">
                                    <div class="squaredOne">
                                        <input class="location_check location" id="state_status"
                                               name="state_status" type="checkbox" checked>
                                        <label for="state_status"></label>
                                    </div>
                                    <p class="text-info location_label">
                                        Only Active State can be used for Subscription
                                    </p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="form-control pri_button" type="submit">UPDATE</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="form-control sec_button" type="button"
                                                    onclick="hide_form(this)">CANCEL
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

            <div class="row-fluid" style="padding-top: 30px;">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="h2 text-blue">USER LIST</div>
                        </div>
                        <div class="col-md-4">
                            <button class="pri_button pull-right" style="font-size: 14px" onclick="sync_users()">
                                <i class="fa fa-download"></i> Synchronize Users
                            </button>
                            <div class="loading">Updating...
                                <span class="loader"></span>
                            </div>
                        </div>
                    </div>


                    <table class="user_table">
                        <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Username</th>
                            <!--th>First Name</th>
                            <th>Last Name</th-->
                            <th>Email</th>
                            <th>User Type</th>
                            <th>CO_ID</th>
                            <th>Used Trial</th>
                            <th>Team (Size)</th>
                            <th>Owner ID</th>
                            <th>Phone</th>
                            <th>Organization</th>
                            <th>Sub_Status</th>
                            <!--th>Sub_ID</th-->
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($user_count > 0) {
                            $i = 1;
                            foreach ($users as $user) {
                                ?>
                                <tr data-userid="<?php echo $user['id']; ?>">
                                    <td class="no"><?php echo $i; ?></td>
                                    <td data-name="username"><?php echo $user['username']; ?></td>
                                    <!--td data-name="first_name"><?php echo $user['first_name']; ?></td>
                                    <td data-name="last_name"><?php echo $user['last_name']; ?></td-->
                                    <td data-name="email"><?php echo $user['email']; ?></td>
                                    <td data-name="user_type">
                                        <?php if ($user['access'] == '100') {
                                            echo "Staff";
                                        } else {
                                            echo "Customer";
                                        } ?>
                                    </td>
                                    <td data-name="customer_id"><?php echo $user['co_customer_id']; ?></td>
                                    <td data-name="used_trial"><?php if ($user['used_trial'] == 0) {
                                            echo 'NO';
                                        } else {
                                            echo "Yes";
                                        } ?></td>
                                    <td data-name="team_ind"><?php if ($user['extra_users'] == 0 || $user['extra_users'] == 1) {
                                            echo "";
                                        } else {
                                            echo $user['extra_users'];
                                        }; ?></td>
                                    <td data-name="owner_id"><?php if ($user['owner_id'] != -1) {
                                            echo $user['owner_id'];
                                        } ?></td>
                                    <td data-name="phone"><?php echo $user['phone']; ?></td>
                                    <td data-name="org_name"><?php echo $user['org_name']; ?></td>
                                    <td data-name="sub_status">
                                        <?php
                                        $sub_status = $user['sub_status'];
                                        if ($sub_status == 'a') {
                                            echo "Active";
                                        } else if ($sub_status == 'c') {
                                            echo "Cancelled";
                                        } else if ($sub_status == 's') {
                                            echo "Suspended";
                                        } else if ($sub_status == 'e') {
                                            echo "Expired";
                                        } else {
                                            echo "Inactive";
                                        }
                                        ?>
                                    </td>
                                    <!--td data-name="sub_id"><?php echo $user['sub_id']; ?></td-->
                                    <td data-stateid="<?php echo $user['id']; ?>" class="actions">
                                        <i class="fa fa-download fa-wx sync_user action"
                                           data-coid="<?php echo $user['co_customer_id']; ?>"
                                           data-uid="<?php echo $user['id']; ?>"
                                        ></i>

                                        <!--                                        <i class="fa fa-edit fa-2x edit_state"></i>-->
                                        <!--                                        <i class="fa fa-trash fa-2x remove_state"></i>-->
                                        <!--                                        <i class="fa fa-check-square fa-2x deactivate_state -->
                                        <?php //if (!$state['status']) echo 'hidden' ?><!--"></i>-->
                                        <!--                                        <i class="fa fa-square-o fa-2x activate_state -->
                                        <?php //if ($state['status']) echo 'hidden' ?><!--"></i>-->

                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else { ?>
                            <tr>
                                <td colspan="100%">There are no users to manage.</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script>

        var loading = false;

        function show_loading() {
            $('.loading').css('visibility', 'visible');
            loading = true;
        }

        function hide_loading() {
            $('.loading').css('visibility', 'hidden');
            loading = false;
        }

        function sync_users() {

            show_loading();

            var data = "action=sync_users";

            $.ajax({
                url: 'manage_users.php',
                type: 'POST',
                data: data,
                success: function (response) {

                    hide_loading();
                    if (response == "success") {

                        alert('All Subscription Info Synchronized');
                        window.location.reload();
                    } else {
                        alert(response);
                    }

                },
                error: function () {
                    hide_loading();
                    alert("While Syncing Users, Error Occurred, Please try again later.");
                }
            })
        }


        $('.sync_user').click(function () {

            if (loading) {
                alert('Please wait until Syncing Subscription Info would be finished.')
                return;
            }


            var user_id = $(this).data('uid');
            var customer_id = $(this).data('coid');
            var data = "user_id=" + user_id + "&customer_id=" + customer_id + "&action=sync_user";

            $.ajax({
                url: 'manage_users.php',
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log(response);

                    if (response == "success") {
                        //alert('State Removed');
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function () {
                    alert("While Syncing Users, Error Occurred, Please try again later.");
                }
            })
        })

    </script>
<?php include('templates/default/footer.php'); ?>