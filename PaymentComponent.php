<?php
namespace yii_ext\payment;

use yii_ext\payment\gateways;
use yii_ext\payment\interfaces\PaymentComponentInterface;

/**
 * Class PaymentComponent
 * @package payment
 */
class PaymentComponent extends \CApplicationComponent implements PaymentComponentInterface
{

    /**
     * @var bool use test mode for transactions or not
     */
    public $isTestMode = false;

    /**
     * @var array filled in configuration containing gateways classes and configuration params
     */
    public $gateways;

    /**
     * @var null|string default gateway from config file
     */
    public $defaultGateway = null;

    /**
     * @var object|null active gateway used for payment actions
     */
    public $activeGateway = null;


    /**
     * Set default gateway from config
     */
    public function init()
    {
        if ($this->activeGateway === null && $this->defaultGateway !== null) {
            $this->setGateway($this->defaultGateway);
        }
        parent::init();
    }


    /**
     * Setting gateway for further actions
     * @author Dmitry Semenov <disemx@gmail.com>
     *
     * @param $name string gateway name from configuration
     *
     * @return void
     */
    public function setGateway($name)
    {
        if (isset($this->gateways[$name]) && class_exists($this->gateways[$name]['class'])) {
            if (isset($this->gateways[$name]['params']['testMode']) && $this->gateways[$name]['params']['testMode'] == true) {
                $params = $this->gateways[$name]['params']['test'];
                $isTest = true;
            } else {
                $params = $this->gateways[$name]['params']['production'];
                $isTest = false;
            }
            $this->activeGateway = GatewayFactory::loadGateway($this->gateways[$name]['class'], $params, $isTest);
        }
    }

}