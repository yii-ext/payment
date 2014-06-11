<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 22.04.14
 * Time: 19:42
 */

namespace \yii_ext\payment\interfaces;

/**
 * Interface PaymentGatewayFactoryInterface
 * @package payment\interfaces
 */
interface GatewayFactoryInterface
{
    /**
     * @static
     *
     * @param $gatewayClassName
     * @param $params
     *
     * @return mixed
     */
    public static function loadGateway($gatewayClassName, $params);

}