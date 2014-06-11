<?php
namespace \yii_ext\payment;

use \yii_ext\payment\models\BasePaymentModel;

/**
 * Class GatewayAbstract
 * @package payment
 */
abstract class GatewayAbstract
{

    /**
     * @param        $success
     * @param string $message
     *
     * @return array
     */
    public function response($success, $message = '')
    {
        return array(
            'success' => $success,
            'message' => $message
        );
    }


    /**
     * @param      $data
     * @param null $parentId
     *
     * @return array
     */
    public function logTransaction($data, $parentId = null)
    {
        if ($parentId !== null) {
            $model = BasePaymentModel::model()->findByPk($parentId);
        } else {
            $model = new BasePaymentModel();
        }
        $model->attributes = $data;
        if ($model->validate()) {
            if ($model->save()) {
                return $this->response(true);
            }
        }
        return $this->response(false);
    }
}