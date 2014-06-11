<?php
namespace yii_ext\payment\interfaces;


/**
 * Interface PaymentComponentInterface
 * @package payment\interfaces
 */
interface PaymentComponentInterface
{
    /**
     * @param $name gateway name from configuration
     *
     * @return void
     */
    public function setGateway($name);

}