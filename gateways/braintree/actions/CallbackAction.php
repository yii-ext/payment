<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 31.03.14
 * Time: 12:24
 */

namespace yii_ext\payment\gateways\braintree\actions;

use Braintree_WebhookNotification;
use Yii;
use CJSON;

/**
 * Class CallbackAction
 * @package payment\gateways\braintree\actions
 */
class CallbackAction extends \CAction
{

    /**
     * Managing braintree webhook
     * @author Dmitry Semenov <disemx@gmail.com>
     */
    public function run()
    {
        Braintree_WebhookNotification::verify($_GET["bt_challenge"]);
        $webhookNotification = Braintree_WebhookNotification::parse(
            $_POST["bt_signature"], $_POST["bt_payload"]
        );

        $webhookNotification->kind;


        $webhookNotification->timestamp;


        $webhookNotification->subscription->id;

        Yii::app()->end();
    }
}