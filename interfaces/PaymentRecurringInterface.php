<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 22.04.14
 * Time: 19:41
 */

namespace yii_ext\payment\interfaces;


/**
 * Interface PaymentRecurringInterface
 * @package payment\interfaces
 */
interface PaymentRecurringInterface extends PaymentInterface
{
    /**
     * @param $data
     *
     * @return mixed
     */
    public function createSubscription($data);

    /**
     * @param $subscriptionId
     *
     * @return mixed
     */
    public function cancelSubscription($subscriptionId);
}