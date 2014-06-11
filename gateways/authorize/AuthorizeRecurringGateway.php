<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 31.03.14
 * Time: 15:51
 */

namespace payment\gateways\authorize;

use payment\GatewayAbstract;
use payment\gateways\authorize\models\PaymentForm;
use payment\interfaces\PaymentRecurringInterface;


\Yii::import('application.vendor/vendors.*');
require_once('anet_php_sdk/AuthorizeNet.php');

/**
 * Class AuthorizeRBGateway
 * @package payment\gateways\authorize
 */
class AuthorizeRecurringGateway extends GatewayAbstract implements PaymentRecurringInterface
{
    /**
     * @var
     */
    public $anetARB;

    /**
     * @param $config
     * @param $isTest
     *
     * @return mixed|void
     */
    public function setConfig($config, $isTest)
    {
        $this->anetARB = new \AuthorizeNetARB($config['api_login_id'], $config['transaction_key']);
        //$this->anetARB->setLogFile($config['authorizeLogDir']);
        if ($isTest == false) {
            $this->anetARB->setSandbox(false);
        }
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
        $subscription = new \AuthorizeNet_Subscription;
        $subscription->name = $data->name;
        $subscription->orderInvoiceNumber = $data->orderInvoiceNumber;
        $subscription->intervalLength = $data->intervalLength;
        $subscription->intervalUnit = $data->intervalUnit;
        $subscription->startDate = $data->startDate;
        $subscription->amount = $data->price;
        $subscription->totalOccurrences = "9999";
        $subscription->creditCardCardNumber = $data->creditCardNumber;
        $subscription->creditCardExpirationDate = $data->creditCardExpirationDate;
        $subscription->creditCardCardCode = $data->creditCardCardCode;
        $subscription->billToFirstName = $data->billToFirstName;
        $subscription->billToLastName = $data->billToLastName;
        $subscription->customerId = $data->customerId;
        $subscription->billToCountry = $data->billToCountry;
        $subscription->billToZip = $data->billToZip;
        $response = $this->anetARB->createSubscription($subscription);
        if ($response->isError()) {
            return array(
                'success' => false,
                'errorMessage' => $response->getMessageText()
            );
        } else {
            return array(
                'success' => true,
                'response' => $response
            );
        }
    }

    /**
     * @param                            $subscriptionId
     * @param \AuthorizeNet_Subscription $subscription
     */
    public function updateSubscription($subscriptionId, \AuthorizeNet_Subscription $subscription)
    {
        $this->anetARB->updateSubscription($subscriptionId, $subscription);
    }

    /**
     * @param $subscriptionId
     *
     * @return mixed
     */
    public function cancelSubscription($subscriptionId)
    {
        return $this->anetARB->cancelSubscription($subscriptionId);
    }

} 