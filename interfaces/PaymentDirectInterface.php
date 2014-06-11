<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 22.04.14
 * Time: 19:42
 */

namespace \yii_ext\payment\interfaces;


/**
 * Interface PaymentDirectInterface
 * @package payment\interfaces
 */
interface PaymentDirectInterface extends PaymentInterface
{
    /**
     * @return mixed
     */
    public function createPayment();

    /**
     * @return mixed
     */
    public function cancelPayment($transactionId);
}