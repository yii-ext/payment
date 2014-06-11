<?php
namespace payment\gateways\authorize\models;


use payment\forms\BasePaymentForm;

class PaymentForm extends BasePaymentForm
{
    public $billingPlan;
    public $name;
    public $orderInvoiceNumber;
    public $intervalLength;
    public $intervalUnit;
    public $startDate;
    public $price;
    public $totalOccurrences;
    public $creditCardCardNumber;
    public $creditCardExpirationDate;
    public $creditCardCardCode;
    public $billToFirstName;
    public $billToLastName;
    public $customerId;
    public $billToCountry;
    public $billToZip;
} 