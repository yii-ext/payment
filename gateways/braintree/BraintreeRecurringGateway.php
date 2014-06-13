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
        //customer
        try {
            $customer = \Braintree_Customer::find($data['customerId']);
        } catch (\Braintree_Exception_NotFound $e) {
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
        $result = \Braintree_Transaction::void($transactionId);
        if ($result->success) {
            return $this->response(true);
        } else {
            return $this->response(false, $result->errors);
        }
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
            'cvv' => $data['cvv'],
            'options' => array(
                'makeDefault' => true
            )
        ));
        return $card;
    }

    public function updateCard($token)
    {
        $updateResult = Braintree_CreditCard::update(
            $token,
            array(
                'number' => '4111111111111111',
                'expirationDate' => '07/14'
            )
        );
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