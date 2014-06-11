<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 31.03.14
 * Time: 12:26
 */

namespace \yii_ext\payment\forms;

use \yii_ext\payment\validators\ECCValidator;


/**
 * Class BasePaymentForm
 * @author  Dmitry Semenov <disemx@gmail.com>
 * @package payment\forms
 */
class BasePaymentForm extends \CFormModel
{
    /**
     * @var int Used for adjust membership (billing: card number)
     */
    public $creditCardNumber;
    /**
     * @var date $expirationMonth for card
     */
    public $expirationMonth;
    /**
     * @var date $expirationYear for card
     */
    public $expirationYear;
    /**
     * @var ccv Security Code
     */
    public $securityCode;
    /**
     * @var
     */
    public $cardHolderName;


    /**
     * @var string used for promo code handling
     */
    public $promoCode;

    /**
     * @var
     */
    public $productId;


    /**
     * @var can be used to manipule price etc
     */
    public $productModel;

    /**
     * Declares the validation rules.
     * @author Dmitry Semenov <disemx@gmail.com>
     */
    public function rules()
    {
        return array(
            array('creditCardNumber, expirationMonth, expirationYear, securityCode', 'required'),
            array('creditCardNumber', 'payment\validators\ECCValidator', 'format' => array(ECCValidator::VISA, ECCValidator::MASTERCARD, ECCValidator::DISCOVER, ECCValidator::AMERICAN_EXPRESS)),
            array('expirationMonth, expirationYear', 'validateDate'),
            //array('cardHolderName', 'validateName'),
            array('securityCode', 'numerical', 'min' => 0, 'max' => 9999),
            array('promoCode, productId, productModel', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'creditCardNumber' => 'Credit Card Number',
            'expirationMonth' => 'Expiration Month',
            'expirationYear' => 'Expiration Year',
            'securityCode' => 'Security Code',
            'cardHolderName' => 'Name',
        );
    }

    /**
     * Expiration date validator
     * @author Dmitry Semenov <disemx@gmail.com>
     *
     * @param $attribute
     * @param $params
     */
    public function validateDate($attribute, $params)
    {
        $ECCValidator = new ECCValidator();
        if (!$ECCValidator->validateDate($this->expirationMonth, $this->expirationYear)) {
            $this->addError('date', 'Expiration date can\'t be in the past.');
            $this->addError($attribute, '');
        }
    }

    /**
     * Card Holder name validator
     * @author Dmitry Semenov <disemx@gmail.com>
     *
     * @param $attribute
     * @param $params
     */
    public function validateName($attribute, $params)
    {
        $ECCValidator = new ECCValidator();
        if (!$ECCValidator->validateName($this->$attribute)) {
            $this->addError($attribute, 'Incorrect Name.');
        }
    }

    /**
     * Generate listData array with months for DropDown
     *
     * @author Drozdenko Anna
     *
     * @return array
     */
    public static function getDateMonths()
    {
        $rows = array();
        for ($i = 1; $i <= 12; $i++) {
            $months = date("m", mktime(0, 0, 0, $i, 1, 2000));
            $rows[$months] = date("d - M", mktime(0, 0, 0, $i, 1, 2000));
        }
        return $rows;
    }

    /**
     * Generate listData array with years for DropDown
     *
     * @author Drozdenko Anna
     *
     * @return array
     */
    public static function getDateYears()
    {
        $fromYear = date('Y');
        $toYear = date('Y') + 20;
        $rows = range($fromYear, $toYear);
        return array_combine($rows, $rows);
    }

} 