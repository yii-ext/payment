<?php
namespace payment\gateways\authorize;

use payment\gateways\authorize\models\PaymentForm;
use payment\interfaces\PaymentRecurringInterface;


\Yii::import('application.vendor/vendors.*');
require_once('anet_php_sdk/AuthorizeNet.php');

/**
 * Class AuthorizeDirectGateway
 * @package payment\gateways\authorize
 */
class AuthorizeDirectGateway extends GatewayAbstract implements PaymentDirectInterface
{
    /**
     * @var
     */
    public $anetAIM;
    
    /**
     * @param $config
     * @param $isTest
     *
     * @return mixed|void
     */
    public function setConfig($config, $isTest)
    {
        $this->anetAIM = new \AuthorizeNetARB($config['api_login_id'], $config['transaction_key']);
        //$this->anetAIM->setLogFile($config['authorizeLogDir']);
        if ($isTest == false) {
            $this->anetAIM->setSandbox(false);
        }
    }

    /**
     * @return PaymentForm
     */
    public function getForm()
    {
        return new PaymentForm();
    }

    public function createPayment() {
        
    }

    /*Used for direct payments*/

    /**
     * Authorizing payments for further usage.
     * -- Response_code == 1 - it means everithing is ok --
     * @author   Dmitry Semenov <disemx@gmail.com>
     *
     * @param AuthorizeNetAIM $anetAIM
     * @param                 $amount
     *
     * @return boolean returns true if auth complete successful
     */
    public function anetAuthorizePayment($amount)
    {
        $anetAIM->amount = $amount;
        return $anetAIM->authorizeOnly();
    }

    /**
     * If miracle happend and user has correct credit card with enough money for all payments - we must capture them.
     * @author Dmitry Semenov <disemx@gmail.com>
     *
     * @param AuthorizeNetAIM $anetAIM
     * @param                 $payment
     *
     * @return boolean
     */
    public function anetCapturePayment($payment)
    {
        return $anetAIM->captureOnly($payment->authorization_code, $payment->amount);
    }

    /**
     * VOID
     * @author Dmitry Semenov <disemx@gmail.com>
     *
     * @param  $authorizationCode
     *
     * @return mixed
     */
    public function cancelPayment($authorizationCode)
    {
        return $anetAIM->void(authorizationCode);
    }

} 