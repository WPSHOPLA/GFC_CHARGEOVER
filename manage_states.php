<?php
require('lib/init.php');
requireLogin();

if (!isStaff()) {
    $url = BASE_URL . 'index.php';
    header("Location: $url");
    exit();
}

global $mainClass, $paymentClass;

$states = $mainClass->getStates();
$state_count = count($states);

//get plan, plan_price
$plan_price_array = [];

$items = $paymentClass->getCOPlans();
if ($items->status == "success") {
    $plans = $items->plans;

    $plan_count = count($plans);

    //plan id - price array
    foreach ($plans as $plan) {
        $plan_id = $plan->item_id;

        $plan_name = $plan->name;

        $plan_price = 0;

        if ($plan->tiersets[0]->pricemodel == "uni") {
            $plan_price = $plan->tiersets[0]->tiers[0]->amount;
        } else {
            $plan_price = $plan->tiersets[0]->base;
        }

        $plan_price_array[] = [$plan_id, $plan_name, $plan_price];
    }
}

include('templates/default/header.php');
?>
    <div class="container-fluid content">
        <div class="main-container">
            <div class="row-fluid">
                <div class="col-md-8 col-md-offset-2">

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
                                <label class="col-md-4" for="new_team_plan">TEAM PLAN*</label>
                                <div class="col-md-6">
                                    <select class="form-control plan" name="new_team_plan" required id="new_team_plan"
                                            data-htarget="new_team_price">
                                        <?php
                                        if (count($plan_price_array) > 0) {
                                            echo '<option value="">Choose Plan...</option>';
                                            foreach ($plan_price_array as $plan) {
                                                echo '<option value="' . $plan[0] . '" data-price="' . $plan[2] . '">' . $plan[1] . '</option>';
                                            }

                                        } else {
                                            echo '<option value="">There is no plan to Choose...</option>';
                                        }
                                        ?>
                                    </select>
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
                                <label class="col-md-4" for="new_personal_plan">PERSONAL PLAN*</label>
                                <div class="col-md-6">
                                    <select class="form-control plan" name="new_personal_plan" required id="new_personal_plan"
                                            data-htarget="new_personal_price">
                                        <?php
                                        if (count($plan_price_array) > 0) {
                                            echo '<option value="">Choose Plan...</option>';
                                            foreach ($plan_price_array as $plan) {
                                                echo '<option value="' . $plan[0] . '" data-price="' . $plan[2] . '">' . $plan[1] . '</option>';
                                            }

                                        } else {
                                            echo '<option value="">There is no plan to Choose...</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4" for="new_personal_price">PERSONAL PRICE</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="number" name="new_personal_price"
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
                                <label class="col-md-4" for="team_plan">TEAM PLAN*</label>
                                <div class="col-md-6">
                                    <select class="form-control plan" name="team_plan" required id="team_plan"
                                            data-htarget="team_price">
                                        <?php
                                        if (count($plan_price_array) > 0) {
                                            echo '<option value="">Choose Plan...</option>';
                                            foreach ($plan_price_array as $plan) {
                                                echo '<option value="' . $plan[0] . '" data-price="' . $plan[2] . '">' . $plan[1] . '</option>';
                                            }

                                        } else {
                                            echo '<option value="">There is no plan to Choose...</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4" for="team_price">TEAM PRICE</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="number" name="team_price" value=""
                                           placeholder="Price for Team" readonly
                                           id="team_price"/>
                                </div>
                            </div>


                            <div class="row form-group">
                                <label class="col-md-4" for="personal_plan">PERSONAL PLAN*</label>
                                <div class="col-md-6">
                                    <select class="form-control plan" name="personal_plan" required id="personal_plan"
                                            data-htarget="personal_price">
                                        <?php
                                        if (count($plan_price_array) > 0) {
                                            echo '<option value="">Choose Plan...</option>';
                                            foreach ($plan_price_array as $plan) {
                                                echo '<option value="' . $plan[0] . '" data-price="' . $plan[2] . '">' . $plan[1] . '</option>';
                                            }

                                        } else {
                                            echo '<option value="">There is no plan to Choose...</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4" for="personal_price">PERSONAL PRICE</label>
                                <div class="col-md-6">
                                    <input class="form-control" type="number" name="personal_price"
                                           placeholder="Price for Personal" readonly
                                           value="" id="personal_price"/>
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
                <div class="col-md-10 col-md-offset-1">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="h2 text-blue">STATE LIST</div>
                        </div>
                        <div class="col-md-4">
                            <button class="pri_button pull-right" style="font-size: 14px" onclick="show_create_form()">
                                <i class="fa fa-plus"></i> ADD STATE
                            </button>
                        </div>
                    </div>

                    <table class="state_table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>State Name</th>
                            <th>Short Name</th>
                            <th>Team Price</th>
                            <th>Plan For Team</th>
                            <th>Personal Price</th>
                            <th>Plan For Personal</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($state_count > 0) {
                            $i = 1;
                            foreach ($states as $state) {
                                ?>
                                <tr data-stateid="<?php echo $state['id']; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td data-name="state_name"><?php echo $state['name']; ?></td>
                                    <td data-name="short_name"
                                        class="text-center"><?php echo $state['short_name']; ?></td>
                                    <td data-name="team_price"
                                        class="text-center"><?php echo $state['team_price']; ?></td>
                                    <td data-name="team_plan"
                                        class="text-center"><?php echo $state['team_plan']; ?></td>
                                    <td data-name="personal_price"
                                        class="text-center"><?php echo $state['personal_price']; ?></td>
                                    <td data-name="personal_plan"
                                        class="text-center"><?php echo $state['personal_plan']; ?></td>
                                    <td data-name="state_status" class="status"
                                        data-status="<?php echo $state['status']; ?>"><?php if ($state['status']) {
                                            echo "Active";
                                        } else {
                                            echo "Inactive";
                                        } ?></td>
                                    <td data-stateid="<?php echo $state['id']; ?>" class="actions">
                                        <i class="fa fa-edit fa-2x edit_state"></i>

                                        <i class="fa fa-trash fa-2x remove_state"></i>

                                        <i class="fa fa-check-square fa-2x deactivate_state <?php if (!$state['status']) echo 'hidden' ?>"></i>

                                        <i class="fa fa-square-o fa-2x activate_state <?php if ($state['status']) echo 'hidden' ?>"></i>

                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else { ?>
                            <tr>
                                <td colspan="100%">There are no states to manage.</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>

        function show_create_form() {
            $('#create_form').show();
            $('#new_state_name').focus();
        }

        function hide_form(button) {
            $(button).closest('form').hide();
        }

        function show_edit_form(tr) {
            var edit_form = $('#edit_form');

            var state_id = $(tr).data('stateid');
            var state_name = $(tr).find('td[data-name="state_name"]').text();
            var short_name = $(tr).find('td[data-name="short_name"]').text();
            var team_plan = $(tr).find('td[data-name="team_plan"]').text();
            var team_price = $(tr).find('td[data-name="team_price"]').text();
            var personal_plan = $(tr).find('td[data-name="personal_plan"]').text();
            var personal_price = $(tr).find('td[data-name="personal_price"]').text();
            var status = $(tr).find('td[data-name="state_status"]').attr('data-status');

            $('#state_id').val(state_id);
            $('#state_name').val(state_name);
            $('#state_short_name').val(short_name);
            $('#team_plan option[value="' + team_plan + '"]').attr('selected', 'selected');
            $('#team_price').val(team_price);
            $('#personal_plan option[value="' + personal_plan + '"]').attr('selected', 'selected');
            $('#personal_price').val(personal_price);
            if (status == 0) {
                $('#state_status').attr('checked', false);
            } else {
                $('#state_status').attr('checked', true);
            }

            $(edit_form).show();
            $('#state_name').focus();
        }

        $('.edit_state').click(function () {
            var tr = $(this).closest('tr');
            $(tr).find('i').attr('disabled', true);
            show_edit_form(tr);
        });


        $('.activate_state').click(function () {
            var icon = $(this);

            var state_id = $(this).closest('td').data('stateid');

            var data = "state_id=" + state_id + "&action=activate_state";

            $.ajax({
                url: 'manage_settings.php',
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response == "success") {
                        $(icon).addClass('hidden');
                        $(icon).parent().find('.deactivate_state').removeClass('hidden');
                        $(icon).closest('tr').find('td.status').text("Active");
                        $(icon).closest('tr').find('td.status').attr('data-status', 1);
                        //alert('State Activated');
                    } else {
                        alert(response);
                    }
                },
                error: function () {
                    alert("While Activating States, Error Occurred, Please try again later.");
                }
            })
        });

        $('.deactivate_state').click(function () {
            var icon = $(this);

            var state_id = $(this).closest('td').data('stateid');

            var data = "state_id=" + state_id + "&action=deactivate_state";

            $.ajax({
                url: 'manage_settings.php',
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response == "success") {
                        $(icon).addClass('hidden');
                        $(icon).parent().find('.activate_state').removeClass('hidden');
                        $(icon).closest('tr').find('td.status').text("Inactive");
                        $(icon).closest('tr').find('td.status').attr('data-status', 0);
                        //alert('State Deactivated');
                    } else {
                        alert(response);
                    }
                },
                error: function () {
                    alert("While Deactivating States, Error Occurred, Please try again later.");
                }
            })
        });

        $('.remove_state').click(function () {

            var icon = $(this);

            var state_id = $(this).closest('td').data('stateid');

            var data = "state_id=" + state_id + "&action=remove_state";

            $.ajax({
                url: 'manage_settings.php',
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response == "success") {
                        $(icon).closest('tr').remove();
                        //alert('State Removed');
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function () {
                    alert("While Removing States, Error Occurred, Please try again later.");
                }
            })
        });

        $('#edit_form').submit(function (e) {

            e.preventDefault();

            var form_data = $(this).serializeArray();

            $.ajax({
                url: 'manage_settings.php',
                type: 'POST',
                data: form_data,
                success: function (response) {
                    if (response == "success") {
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function () {
                    alert("While Updating States, Error Occurred, Please try again later.");
                }
            })
        });


        $('#create_form').submit(function (e) {

            e.preventDefault();

            var form_data = $(this).serializeArray();

            $.ajax({
                url: 'manage_settings.php',
                type: 'POST',
                data: form_data,
                success: function (response) {
                    console.log(response);
                    if (response == "success") {
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function () {
                    alert("While Adding new State, Error Occurred, Please try again later.");
                }
            })
        });

        $('.plan').change(function () {
            var price = $(this).find('option:selected').data('price');
            var price_obj_id = $(this).data('htarget');
            $('#' + price_obj_id).val(price);
        });

    </script>
<?php include('templates/default/footer.php'); ?>