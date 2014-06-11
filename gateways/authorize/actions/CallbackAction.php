<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 31.03.14
 * Time: 12:24
 */

namespace payment\gateways\authorize\actions;

use Yii;
use CJSON;

/**
 * Class CallbackAction
 * @package payment\gateways\authorize\actions
 */
class CallbackAction extends \CAction
{

    /**
     * Managing authorize.net silent post
     * @author Dmitry Semenov <disemx@gmail.com>
     */
    public function run()
    {
        $postData = $_POST;
        Yii::log(CJSON::encode($postData), 'trace');


        if (empty($postData) || empty($postData['x_trans_id']) || empty($postData['x_amount']) || empty($postData['x_response_code']) || empty($postData['x_response_reason_text'])) {
            Yii::log("Incorrect POST provided", 'error');
            exit();
        }

        try {
            if (Yii::app()->params['payment']['testMode'] == true) {
                $hash = md5(Yii::app()->params['payment']['testData']['md5Word'] . $postData['x_trans_id'] . $postData['x_amount']);
            } else {
                $hash = md5(Yii::app()->params['payment']['liveData']['md5Word'] . $postData['x_trans_id'] . $postData['x_amount']);
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage(), 'error');
            Yii::app()->end();
        }

        try {
            if (strtolower($hash) == strtolower($postData['x_MD5_Hash'])) {
                $payment = PaymentModel::model()->findByAttributes(array('subscriptionID' => $postData['x_subscription_id']));
                if (empty($payment)) {
                    Yii::log("No subscription #" . $postData["x_subscription_id"] . " in DB\n", 'error');
                    Yii::app()->end();
                } else {
                    $valid = true;
                }
            } else {
                Yii::log("Incorrect hash provided.", 'error');
                Yii::app()->end();
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage(), 'error');
            exit();
        }

        // If it is an ARB transaction, do something with it
        if ($valid) {
            try {
                if ($postData['x_response_code'] == 1) {
                    // --- Approved transactions management --- //
                    if ($postData['x_subscription_paynum'] == 1) {
                        Yii::log("Subscription OK", 'trace');
                        Yii::app()->end();
                    }
                    $membershipPlan = MembershipPlanModel::model()->findByPk($payment->relatedUser->membership->membershipPlanID);
                    $paymentData = array(
                        'status' => PaymentModel::STATUS_COMPLETED,
                        'message' => $postData['x_response_reason_text'],
                        'initID' => $payment->id,
                    );
                    PaymentModel::createPayment($payment->relatedUser, PaymentModel::TYPE_OEM_RECURRING, $membershipPlan, $payment->relatedUser->membership, null, $paymentData);
                    UserMembershipModel::extendMembership($payment->userMembershipID);
                    Yii::app()->membership->prolong($plan->id, $plan->intervalLength, $plan->intervalUnit, $userId);

                } else {
                    // Denied transactions
                    //--- oem_recurring (failed) ---//
                    $membershipPlan = MembershipPlanModel::model()->findByPk($payment->relatedUser->membership->membershipPlanID);
                    $paymentData = array(
                        'status' => PaymentModel::STATUS_REFUSED,
                        'message' => $postData['x_response_reason_text'],
                        'initID' => $payment->id,
                    );
                    PaymentModel::createPayment($payment->relatedUser, PaymentModel::TYPE_OEM_RECURRING, $membershipPlan, $payment->relatedUser->membership, null, $paymentData);
                    Yii::app()->membership->prolong($plan->id, $plan->intervalLength, $plan->intervalUnit, $userId);
                }
            } catch (Exception $e) {
                Yii::log($e->getMessage(), 'error');
                Yii::app()->end();
            }
        }
        Yii::app()->end();
    }
}