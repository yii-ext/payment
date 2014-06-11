<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 22.04.14
 * Time: 19:43
 */

namespace \yii_ext\payment\interfaces;


/**
 * Interface PaymentHistoryInterface
 * @package payment\interfaces
 */
interface PaymentHistoryInterface
{
    /**
     * @return mixed
     */
    public function log();

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function viewLog($userId);

}