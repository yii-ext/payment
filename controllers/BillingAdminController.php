<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 31.03.14
 * Time: 17:31
 */

namespace payment\controllers;

/**
 * Class BillingAdminController
 * @package payment\controllers
 */
class BillingAdminController extends \AdminController
{
    public $layout = 'application.modules.admin.views.layouts.main';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => array(
                'class' => '\payment\actions\BillingStatisticAction',
            ),
            'history' => array(
                'class' => '\payment\actions\BillingHistoryAction',
            ),

        );
    }

} 