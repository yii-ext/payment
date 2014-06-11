<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 31.03.14
 * Time: 12:24
 */

namespace payment\actions;


/**
 * Class CallbackAction
 * @package payment\actions
 */
class BillingStatisticAction extends \CAction
{
    public $view = 'payment.views.statistic';

    /**
     * @author Dmitry Semenov <disemx@gmail.com>
     */
    public function run()
    {

        $this->controller->render($this->view, array());
    }
}