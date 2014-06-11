<?php
namespace yii_ext\payment;

use yii_ext\payment\interfaces\GatewayFactoryInterface;

/**
 * Class GatewayFactory
 * @author   Dmitry Semenov <disemx@gmail.com>
 * @package  payment
 */
class GatewayFactory implements GatewayFactoryInterface
{
    /**
     * Payment factory
     *
     * @author   Dmitry Semenov <disemx@gmail.com>
     *
     *
     * @param $gatewayClassName
     * @param $params
     * @param $isTest
     *
     * @throws \CException
     * @return PaymentClass
     */
    public static function loadGateway($gatewayClassName, $params = null, $isTest = false)
    {
        try {
            $gateway = new $gatewayClassName;
            if ($params !== null) {
                $gateway->setConfig($params, $isTest);
            }
            return $gateway;
        } catch (Exception $e) {
            Yii::log($e->getMessage());
        }
        return false;
    }
}