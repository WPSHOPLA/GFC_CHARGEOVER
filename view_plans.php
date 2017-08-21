<?php
require('lib/init.php');
requireLogin();

if (!isStaff()) {
    $url = BASE_URL . 'index.php';
    header("Location: $url");
    exit();
}

global $paymentClass;

$items = $paymentClass->getCOPlans();

if ($items->status == "success") {
    $plans = $items->plans;
    $plan_count = count($plans);

//    foreach ($plans as $plan) {
//        if ($plan->tiersets[0]->pricemodel == 'vol') {
//            var_dump($plan);
//        }
//    }
} else {
    $plans = [];
    $plan_count = 0;
}

$pricemodel = [
    'fla' => 'Flat Pricing',
    'uni' => 'Unit Pricing',
    'vol' => 'Volume Pricing',
    'tie' => 'Tiered Pricing'

];

$periodic_model = [
    'mon' => 'Monthly',
    'yrl' => 'Yearly',
    '1wk' => 'Every Week',
    '2wk' => 'Every other Week',
    'qtr' => 'Every Quarter'
];


include('templates/default/header.php');
?>
    <div class="container-fluid content">
        <div class="main-container">
            <div class="row-fluid" style="padding-top: 30px;">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="h2 text-blue">PLAN LIST</div>
                            <label class="text-info">You can assign Item id to the state</label>
                        </div>
                    </div>

                    <table class="user_table" id="plantable">
                        <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Name</th>
                            <th>Item ID</th>
                            <th>Item TYPE</th>
                            <th>Description</th>
                            <th>Enabled</th>
                            <th>Expire Recurs</th>
                            <th>PayCycle</th>
                            <th>PriceModel</th>
                            <th>Setup Formatted</th>
                            <th>Base Formatted</th>
                            <th>PriceModel Description</th>
                            <th>Spec</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($plan_count > 0) {
                            $i = 1;
                            foreach ($plans as $plan) {
                                $currency = $plan->tiersets[0]->currency_symbol;

                                ?>
                                <tr>
                                    <td class="no"><?php echo $i; ?></td>
                                    <td class=""><?php echo $plan->name; ?></td>
                                    <td class=""><?php echo $plan->item_id; ?></td>
                                    <td class=""><?php echo $plan->item_type; ?></td>
                                    <td class=""><?php echo $plan->description; ?></td>
                                    <td class=""><?php if($plan->enabled) echo 'Yes'; else echo 'No'; ?></td>
                                    <td class=""><?php echo $plan->expire_recurs; ?></td>
                                    <td class=""><?php echo $periodic_model[$plan->tiersets[0]->paycycle]; ?></td>
                                    <td class=""><?php echo $pricemodel[$plan->tiersets[0]->pricemodel]; ?></td>
                                    <td class=""><?php echo $plan->tiersets[0]->setup_formatted; ?></td>
                                    <td class="">
                                        <?php
                                        if ($plan->tiersets[0]->pricemodel == "uni") {
                                            echo $plan->tiersets[0]->tiers[0]->amount . $currency;
                                        } else {
                                            echo $plan->tiersets[0]->base_formatted;
                                        }

                                        ?>
                                    </td>
                                    <td class=""><?php echo $plan->tiersets[0]->pricemodel_desc; ?></td>
                                    <td class="">
                                        <?php

                                        $tiers = $plan->tiersets[0]->tiers;
                                        if (count($tiers) > 0 && $plan->tiersets[0]->pricemodel == 'vol') {
                                            foreach ($tiers as $tier) {
                                                $unit_from = $tier->unit_from;
                                                $unit_to = $tier->unit_to;
                                                $unit_amount = $tier->unit_to;

                                                echo 'Unit ' . $unit_from . '~' . $unit_to . ' : ' . $unit_amount . $currency . '<br>';
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else { ?>
                            <tr>
                                <td colspan="100%">There are no plans to manage.</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div id="paging-first-datatable" class="paging"></div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            //datatable
            $('#plantable').datatable({
                pageSize: 10,
//                filters: [false, true, false, false, false, 'select', false, 'select', 'select', false, false, false, false],
//                filterText: 'Type to filter... '
            });
        });

    </script>
<?php include('templates/default/footer.php'); ?>