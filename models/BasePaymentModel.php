<?php
namespace \yii_ext\payment\models;
/**
 * Class BasePaymentModel
 * This is the model class for table "Payment".
 * @author  Dmitry Semenov <disemx@gmail.com>
 *
 * The followings are the available columns in table 'Payment':
 * @property integer $id
 * @property integer $rootId
 * @property integer $userId
 * @property integer $productId
 * @property integer $transactionID
 * @property string  $amount
 * @property string  $status
 * @property string  $type
 * @property string  $message
 * @property string  $ip
 * @property string  $creationDate
 * @property string  $updatedDate
 * @package payment\models
 */
class BasePaymentModel extends \CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Payment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('userId, productId, transactionID, amount, status, type, creationDate', 'required'),
            array('rootId, userId, productId, transactionID', 'numerical', 'integerOnly' => true),
            array('amount, status', 'length', 'max' => 10),
            array('type', 'length', 'max' => 50),
            array('message', 'length', 'max' => 256),
            array('ip', 'length', 'max' => 20),
            array('updatedDate', 'safe'),
            array('rootId, message, ip, updatedDate', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, rootId, userId, productId, transactionID, amount, status, type, message, ip, creationDate, updatedDate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'rootId' => Yii::t('app', 'Root'),
            'userId' => Yii::t('app', 'User'),
            'productId' => Yii::t('app', 'Product'),
            'transactionID' => Yii::t('app', 'Transaction'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
            'message' => Yii::t('app', 'Message'),
            'ip' => Yii::t('app', 'Ip'),
            'creationDate' => Yii::t('app', 'Creation Date'),
            'updatedDate' => Yii::t('app', 'Updated Date'),
        );
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'createdDate',
                'updateAttribute' => 'updatedDate',
            )
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }


}