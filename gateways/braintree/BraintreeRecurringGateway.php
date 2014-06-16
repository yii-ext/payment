<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 29.05.14
 * Time: 15:39
 */

namespace yii_ext\payment\gateways\braintree;


use yii_ext\payment\GatewayAbstract;
use yii_ext\payment\gateways\braintree\models\PaymentForm;
use yii_ext\payment\interfaces\PaymentRecurringInterface;

/**
 * Class BraintreeRecurringGateway
 * @package payment\gateways\braintree
 */
class BraintreeRecurringGateway extends GatewayAbstract implements PaymentRecurringInterface
{

    /**
     * @param $config
     * @param $isTest
     *
     * @return mixed|void
     */
    public function setConfig($config, $isTest)
    {
        if ($isTest == true) {
            \Braintree_Configuration::environment('sandbox');
        } else {
            \Braintree_Configuration::environment('production');
        }

        \Braintree_Configuration::merchantId($config['merchantId']);
        \Braintree_Configuration::publicKey($config['publicKey']);
        \Braintree_Configuration::privateKey($config['privateKey']);
    }

    /**
     * @return PaymentForm
     */
    public function getForm()
    {
        return new PaymentForm();
    }

    /**
     * @param $data array
     *
     * @return mixed
     */
    public function createSubscription($data)
    {
        $customer = $this->getCustomer($data);
        if ($customer->success == false) {

        }

        $card = $this->getCard($customer, $data);
        if ($card->success == false) {

        }

        $subscription = \Braintree_Subscription::create(array(
            'paymentMethodToken' => $card->token,
            'planId' => $data['planId'],
        ));
        if ($subscription->success == false) {

        } else {
            return true;
        }

    }

    /**
     * @param $data
     *
     * @return object
     */
    private function  getCustomer($data)
    {
        $customer = $this->getCustomerById($data['customerId']);
        if ($customer == false) {
            $customer = \Braintree_Customer::create(array(
                'id' => $data['customerId'],
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ));
        }

        return $customer;
    }

    /**
     * @param $id
     *
     * @return object
     */
    public function  getCustomerById($id)
    {
        try {
            $customer = \Braintree_Customer::find($id);
        } catch (\Braintree_Exception_NotFound $e) {
            return false;
        }
        return $customer;
    }

    public function getCustomerDefaultCard($customerId)
    {
        $customer = $this->getCustomerById($customerId);
        if ($customer !== false) {
            foreach ($customer->creditCards as $card) {
                if ($card->isDefault()) {
                    return $card;
                }
            }
        }
        return false;
    }

    /**
     * @param $subscriptionId
     * @param $data
     *
     * @return array
     */
    public function updateSubscription($subscriptionId, $data)
    {
        $result = \Braintree_Subscription::update($subscriptionId, $data);
        if ($result->success) {
            return $this->response(true);
        } else {
            return $this->response(false);
        }
    }

    /**
     * @param $subscriptionId
     *
     * @return mixed
     */
    public function cancelSubscription($subscriptionId)
    {
        $result = \Braintree_Subscription::cancel($subscriptionId);
        if ($result->success == true) {
            return $this->response(true);
        }
    }

    /**
     * @param $transactionId
     *
     * @return array
     */
    public function voidTransaction($transactionId)
    {
        try {
            $transaction = \Braintree_Transaction::find($transactionId);
        } catch (\Exception $e) {
            return false;
        }
        if ($transaction) {
            if ($transaction->status == \Braintree_Transaction::AUTHORIZED || $transaction->status == \Braintree_Transaction::SUBMITTED_FOR_SETTLEMENT) {
                $result = \Braintree_Transaction::void($transactionId);
            } else {
                $result = \Braintree_Transaction::refund($transactionId);
            }
            if ($result->success == true) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $customer
     * @param $data
     *
     * @return bool
     */
    private function getCard($customer, $data)
    {
        if (isset($customer->creditCards) && isset($customer->creditCards[0])) {
            $card = $customer->creditCards[0];
        } else {
            $card = $this->createCard($customer, $data);
        }
        return $card;
    }

    /**
     * @param $customer
     * @param $data
     *
     * @return bool
     */
    private function createCard($customer, $data)
    {
        $card = \Braintree_CreditCard::create(array(
            'customerId' => $customer->customer->id,
            'number' => $data['creditCardNumber'],
            'expirationDate' => "{$data['expirationMonth']}/{$data['expirationYear']}",
            'cardholderName' => $data['cardHolderName'],
            'cvv' => $data['securityCode'],
            'options' => array(
                'makeDefault' => true
            )
        ));
        return $card;
    }

    public function updateCard($token, $data)
    {
        $updateResult = \Braintree_CreditCard::update(
            $token,
            array(
                'number' => $data['creditCardNumber'],
                'expirationDate' => "{$data['expirationMonth']}/{$data['expirationYear']}",
                'cvv' => $data['securityCode'],
                'options' => array(
                    'makeDefault' => true
                )
            )
        );
        if ($updateResult->success == true) {
            return true;
        }
        return $updateResult->message;
    }

    /**
     * @param        $success
     * @param string $message
     *
     * @return array
     */
    public function response($success, $message = '')
    {
        return array(
            'success' => $success,
            'message' => $message
        );
    }
} 