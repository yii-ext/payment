<?php
/**
 * Created by PhpStorm.
 * User: semenov
 * Date: 31.03.14
 * Time: 12:24
 */

namespace payment\actions;


    /**
     * Class BillingHistoryAction
     * @package payment\actions
     */
/**
 * Class BillingHistoryAction
 * @package payment\actions
 */
class BillingHistoryAction extends \CAction
{
    /**
     * @var string
     */
    public $view = 'payment.views.history';

    /**
     * @author Dmitry Semenov <disemx@gmail.com>
     */
    public function run($type = 'default', $userId = null)
    {
        $this->setBreadcrumbs($type, $userId);
        $criteria = new \CDbCriteria();
        $criteria = $this->attachUserCriteria($criteria, $userId);
        $criteria = $this->attachTypeCriteria($criteria, $type);

        $dataProvider = new \CActiveDataProvider('BasePaymentDetailsModel', $criteria);
        $this->controller->render($this->view, array(
            'dataProvider' => $dataProvider
        ));
    }

    private function attachUserCriteria($criteria, $userId)
    {
        if ($userId !== null) {
            $criteria->addCondition('userId', $userId);
        }
        return $criteria;
    }

    private function attachTypeCriteria($criteria, $type)
    {
        switch ($type) {
            case 'expiring':

                break;
            case 'active':

                break;
            default:
                break;
        }
    }

    /**
     * @param $filter
     * @param $userId
     */
    private function setBreadcrumbs($filter, $userId)
    {
        if ($userId !== null) {
            $breadcrumbs[] = array('user' => 'luser');
        }
        switch ($filter) {
            case 'expiring':
                $breadcrumbs[] = array(
                    'Expiring Soon'
                );
                break;
            case 'active':
                $breadcrumbs[] = array(
                    'Active Subscriptions'
                );
                break;
            default:
                break;
        }
        $this->controller->breadcrumbs = $breadcrumbs;
    }

}