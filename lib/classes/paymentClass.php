<?php

class paymentClass
{
    private $API;


    public function __construct()
    {
        include ROOT_DIR . '/lib/classes/ChargeOverAPI.php';

        $url = 'https://gofetchcode.chargeover.com/api/v3';
        $authmode = ChargeOverAPI::AUTHMODE_HTTP_BASIC;
        $username = 'X5Ci1mxVKBhQ3kjUZqbED6e9zp82Lads';
        $password = 'efMxvTHmpREFGqzNIPVs8ahr6OXuCkJ3';

        $this->API = new ChargeOverAPI($url, $authmode, $username, $password);
    }

    public function createCustomer($uid, $username, $first_name, $last_name, $email, $phone, $organization)
    {
        $Customer = new ChargeOverAPI_Object_Customer(array(
            'company' => $organization,
            'external_key' => 'gfc_users_' . $uid . '_' . time(),
            'superuser_name' => $first_name . ' ' . $last_name,
            'superuser_email' => $email,
            'superuser_phone' => $phone
        ));

        $resp = $this->API->create($Customer);
        if (!$this->API->isError($resp)) {
            $customer_id = $resp->response->id;
            return $customer_id;
        } else {
            print('error saving customer via API: ' . $this->API->lastError());
            die();
        }
    }

    public function updatePhone($customer_id, $phone)
    {
        $Customer = new ChargeOverAPI_Object_Customer(array(
            'superuser_phone' => $phone
        ));

        $resp = $this->API->modify($customer_id, $Customer);

        if (!$this->API->isError($resp)) {
            $invoice_id = $resp->response->id;
            return (object)array('status' => 'success', 'id' => $resp->response->id);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }


    /*Customer*/

    public function getCustomerById($customer_id)
    {
        $resp = $this->API->findById('customer', $customer_id);

        if ($resp) {
            return (object)array('status' => 'success', 'customer' => $resp);
        } else {
            return (object)array('status' => 'error', 'message' => "There was an error looking up the customer!");
        }
    }

    public function updateCustomer($customer_id, $customer_data)
    {

        $customer = new ChargeOverAPI_Object_Customer($customer_data);

        $resp = $this->API->modify($customer_id, $customer);

        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'id' => $resp->response->id);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }


    public function createCard($user_id, $customer_id, $number, $expdate_year, $expdate_month, $name, $address = '', $city = '', $postcode = '', $country = '', $state = '')
    {
        $CreditCard = new ChargeOverAPI_Object_CreditCard(array(
            'customer_id' => $customer_id, // Must be the customer ID of an existing customer in ChargeOver
            //'customer_external_key' => 'abcd12345',
            'number' => $number,
            'expdate_year' => $expdate_year,
            'expdate_month' => $expdate_month,
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'postcode' => $postcode,
            'country' => $country,
            'state' => $state
        ));

        $resp = $this->API->create($CreditCard);
        if (!$this->API->isError($resp)) {
            $creditcard_id = $resp->response->id;
            return (object)array('status' => 'success', 'id' => $creditcard_id);
            //return $creditcard_id;
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
            //return $resp;
            //print('Error saving credit card via API!');
            //print($this->API->lastResponse());
        }
    }

    public function deleteCard($creditcard_id)
    {
        $resp = $this->API->delete(ChargeOverAPI_Object::TYPE_CREDITCARD, $creditcard_id);
        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success');
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function getCards($customer_id)
    {
        $resp = $this->API->find('creditcard', array('customer_id:EQUALS:' . $customer_id));
        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'cards' => $resp->response);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function getCard($creditcard_id)
    {
        $resp = $this->API->find('creditcard', array('creditcard_id:EQUALS:' . $creditcard_id));

        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'card' => $resp->response);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function getCardByCustomerId($customer_id)
    {
        $resp = $this->API->find('creditcard', array('customer_id:EQUALS:' . $customer_id));

        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'card' => $resp->response);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function invoiceSubscription($subscription_id)
    {
        $resp = $this->API->action('package', $subscription_id, 'invoice');
        if (!$this->API->isError($resp)) {
            $invoice_id = $resp->response->id;
            return (object)array('status' => 'success', 'id' => $invoice_id);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function cancelSubscription($subscription_id)
    {
        $resp = $this->API->action('package', $subscription_id, 'cancel');
        if (!$this->API->isError($resp)) {
            //$invoice_id = $resp->response->id;
            return (object)array('status' => 'success');
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function getSubscriptions($customer_id)
    {
        //$resp = $this->API->find('package', array('package_status_state:EQUALS:a', 'customer_id:EQUALS:' . $customer_id));
        $resp = $this->API->find('package', array('customer_id:EQUALS:' . $customer_id));
        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'subscriptions' => $resp->response);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }


    public function getCustomerSubscription($customer_id)
    {
        $resp = $this->API->find('package', array('customer_id:EQUALS:' . $customer_id));
        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'subscriptions' => $resp->response);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function getSubscription($subscription_id)
    {
        $resp = $this->API->find('package', array('package_id:EQUALS:' . $subscription_id));
        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'subscription' => $resp->response);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }


    public function payInvoice($customer_id, $invoice_id, $amount)
    {
        $resp = $this->API->action('transaction', null, 'pay', array(
            'customer_id' => $customer_id,
            'amount' => $amount,
            'applied_to' => array(
                'invoice_id' => $invoice_id
            )
        ));
        if (!$this->API->isError($resp)) {
            $payment_id = $resp->response->id;
            return (object)array('status' => 'success', 'id' => $payment_id);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function createSubscription($user_id, $customer_id, $item_ids, $card_id, $line_quantity, $trial_days = 0, $customer_data)
    {
        $Package = new ChargeOverAPI_Object_Package();
        $Package->setCustomerId($customer_id);


        //$Package->setPaymethod('crd');
        $Package->setCreditcardId($card_id);

        //$trial_days = 7;

        foreach ($item_ids as $item_id) {
            $LineItem = new ChargeOverAPI_Object_LineItem();
            $LineItem->setItemId($item_id);

            if ($trial_days > 0)
                $LineItem->setTrialDays($trial_days);

            $LineItem->setLineQuantity($line_quantity);
            $Package->addLineItems($LineItem);
        }

        if ($trial_days > 0) {
            $Package->setHolduntilDatetime(date('Y-m-d H:i:s', strtotime('+1 week')));
        }

        $resp = $this->API->create($Package);
        if (!$this->API->isError($resp)) {
            $package_id = $resp->response->id;
            return (object)array('status' => 'success', 'id' => $package_id);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }


    public function updateSubscription($package_id, $item_ids, $line_quantity, $card_id)
    {

        $data = [];

        $line_items = [];

        //get origin items
        // Get the package
        $package = $this->API->findById('package', $package_id);

        $existing_items = $package->getLineItems();

        foreach ($existing_items as $existing_item) {

            $line_items[] = array('line_item_id' => $existing_item->line_item_id, 'cancel' => true);
        }

        foreach ($item_ids as $item_id) {
            $LineItem = new ChargeOverAPI_Object_LineItem();
            $LineItem->setItemId($item_id);
            $LineItem->setLineQuantity($line_quantity);
            $line_items[] = $LineItem;
        }

        $data['line_items'] = $line_items;
        $data['creditcard_id'] = $card_id;

        $resp = $this->API->action('package', $package_id, 'upgrade', $data);

        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success', 'id' => $package_id);
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }
    }

    public function suspendSubscription($package_id)
    {

        $resp = $this->API->action('package', $package_id, 'suspend');

        if (!$this->API->isError($resp)) {
            return (object)array('status' => 'success');
        } else {
            return (object)array('status' => 'error', 'message' => $resp->message);
        }

    }

    /*public function createSubscription($user_id, $customer_id, $item_id, $card_id, $line_quantity, $trial_days = 0) {
        $Package = new ChargeOverAPI_Object_Package();
        $Package->setCustomerId($customer_id);
        //$Package->setPaymethod('crd');
        $Package->setCreditcardId($card_id);

        $LineItem = new ChargeOverAPI_Object_LineItem();
        $LineItem->setItemId($item_id);
        if($trial_days > 0)
            $LineItem->setTrialDays($trial_days);

        $LineItem->setLineQuantity($line_quantity);


        $Package->addLineItems($LineItem);

        $resp = $this->API->create($Package);
        if (!$this->API->isError($resp)) {
            $package_id = $resp->response->id;
            return (object) array('status' => 'success', 'id' => $package_id);
        } else {
            return (object) array('status' => 'error', 'message' => $resp->message);
        }
    }*/


    public function getPayCycleName($cycle_value)
    {
        $cycle_name = "";
        switch ($cycle_value) {
            case ChargeOverAPI_Object_Package::PAYCYCLE_EVERYOTHERWEEK:
                $cycle_name = "2 Weeks";
                break;
            case ChargeOverAPI_Object_Package::PAYCYCLE_MONTHLY:
                $cycle_name = "Monthly";
                break;
            case ChargeOverAPI_Object_Package::PAYCYCLE_QUARTERLY:
                $cycle_name = "Quarterly";
                break;
            case ChargeOverAPI_Object_Package::PAYCYCLE_SIXMONTHS:
                $cycle_name = "6 Months";
                break;
            case ChargeOverAPI_Object_Package::PAYCYCLE_TWOMONTHS:
                $cycle_name = "2 Months";
                break;
            case ChargeOverAPI_Object_Package::PAYCYCLE_WEEKLY:
                $cycle_name = "Weekly";
                break;
            case ChargeOverAPI_Object_Package::PAYCYCLE_YEARLY:
                $cycle_name = "Yearly";
                break;
            default:
                $cycle_name = "Monthly";
        }

        return $cycle_name;
    }

}

?>