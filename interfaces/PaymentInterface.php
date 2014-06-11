<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 22.04.14
 * Time: 19:42
 */

namespace yii_ext\payment\interfaces;


/**
 * Interface PaymentInterface
 * @package payment\interfaces
 */
interface PaymentInterface
{
    /**
     * @param $config
     * @param $isTest true for test config usage
     *
     * @return mixed
     */
    public function setConfig($config, $isTest);

}