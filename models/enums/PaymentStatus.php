<?php
namespace yii_ext\payment\models\enums;


    /**
     * Class PaymentStatus
     * @package payment\models\enums
     */
/**
 * Class PaymentStatus
 * @package yii_ext\payment\models\enums
 */
class PaymentStatus extends \CEnumerable
{

    /**
     * @var int db representation for Pending status
     */
    const PENDING = 1;
    /**
     * @var int db representation for Completed status
     */
    const COMPLETED = 2;
    /**
     * @var int db representation for Cancelled status
     */
    const CANCELLED = 3;
    /**
     * @var int db representation for Refused status
     */
    const REFUSED = 4;
    /**
     * @var int db representation for Voided status
     */
    const VOID = 5;
    /**
     * @var int db representation for Refund status
     */
    const REFUND = 6;

    /**
     * @return array of key => values
     */
    public static function listData()
    {
        return array(
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
            self::REFUSED => 'Refused',
            self::VOID => 'Void',
            self::REFUND => 'Refund',
        );
    }

    /**
     * @var key
     * @return string label
     */
    public static function getLabel($key)
    {
        $list = self::listData();
        if (isset($list[$key])) {
            return $list[$key];
        }
        return false;
    }
} 