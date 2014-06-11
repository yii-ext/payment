<?php
namespace payment\gateways\braintree\models;


use payment\forms\BasePaymentForm;

/**
 * Class PaymentForm
 * @package payment\gateways\braintree\models
 */
class PaymentForm extends BasePaymentForm
{
    /**
     * @var
     */
    public $billingPlan;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $orderInvoiceNumber;
    /**
     * @var
     */
    public $intervalLength;
    /**
     * @var
     */
    public $intervalUnit;
    /**
     * @var
     */
    public $startDate;
    /**
     * @var
     */
    public $price;
    /**
     * @var
     */
    public $totalOccurrences;
    /**
     * @var
     */
    public $creditCardCardNumber;
    /**
     * @var
     */
    public $creditCardExpirationDate;
    /**
     * @var
     */
    public $creditCardCardCode;
    /**
     * @var
     */
    public $billToFirstName;
    /**
     * @var
     */
    public $billToLastName;

    /**
     * @var
     */
    public $billToCountry;
    /**
     * @var
     */
    public $billToZip;
    /**
     * @var
     */
    public $amount;


    /**
     * @var
     */
    public $orderId;

    /**
     * @var
     */
    public $creditCard_number;
    /**
     * @var
     */
    public $creditCard_cvv;
    /**
     * @var
     */
    public $creditCard_month;
    /**
     * @var
     */
    public $creditCard_year;
    /**
     * @var
     */
    public $creditCard_date;
    /**
     * @var
     */
    public $creditCard_name;

    /**
     * @var
     */
    public $customer_firstName;
    /**
     * @var
     */
    public $customer_lastName;
    /**
     * @var
     */
    public $customer_company;
    /**
     * @var
     */
    public $customer_phone;
    /**
     * @var
     */
    public $customer_fax;
    /**
     * @var
     */
    public $customer_website;
    /**
     * @var
     */
    public $customer_email;

    /**
     * @var
     */
    public $billing_firstName;
    /**
     * @var
     */
    public $billing_lastName;
    /**
     * @var
     */
    public $billing_company;
    /**
     * @var
     */
    public $billing_streetAddress;
    /**
     * @var
     */
    public $billing_extendedAddress;
    /**
     * @var
     */
    public $billing_locality;
    /**
     * @var
     */
    public $billing_region;
    /**
     * @var
     */
    public $billing_postalCode;
    /**
     * @var
     */
    public $billing_countryCodeAlpha2;

    /**
     * @var
     */
    public $shipping_firstName;
    /**
     * @var
     */
    public $shipping_lastName;
    /**
     * @var
     */
    public $shipping_company;
    /**
     * @var
     */
    public $shipping_streetAddress;
    /**
     * @var
     */
    public $shipping_extendedAddress;
    /**
     * @var
     */
    public $shipping_locality;
    /**
     * @var
     */
    public $shipping_region;
    /**
     * @var
     */
    public $shipping_postalCode;
    /**
     * @var
     */
    public $shipping_countryCodeAlpha2;

    /**
     * @var BraintreeApi
     */
    public $BraintreeApi;

    /**
     * @var
     */
    public $customerId;
    /**
     * @var
     */
    public $planId;

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('customerId', 'required', 'on' => 'creditcard'),
            array('customerId', 'required', 'on' => 'address'),
            array('customer_firstName, customer_lastName', 'required', 'on' => 'customer'),
            array('amount', 'required', 'on' => 'charge'),
            array('amount', 'numerical'),
            array('customer_email', 'email'),
            array('creditCard_number, creditCard_cvv, creditCard_month, creditCard_year, creditCard_date,
                    customer_firstName,
                    customer_lastName,
                    customer_company,
                    customer_phone,
                    customer_fax,
                    customer_website,
                    customer_email,
                    billing_firstName,
                    billing_lastName,
                    billing_company,
                    billing_streetAddress,
                    billing_extendedAddress,
                    billing_locality,
                    billing_region,
                    billing_postalCode,
                    billing_countryCodeAlpha2,
                    shipping_firstName,
                    shipping_lastName,
                    shipping_company,
                    shipping_streetAddress,
                    shipping_extendedAddress,
                    shipping_locality,
                    shipping_region,
                    shipping_postalCode,
                    shipping_countryCodeAlpha2', 'safe'),
        ));
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'amount' => 'Amount($)',
            'orderId' => 'Order ID',
            'creditCard_number' => 'Credit Card Number',
            'creditCard_cvv' => 'Security Code',
            'creditCard_month' => 'Expiration Month (MM)',
            'creditCard_year' => 'Expiration Year (YYYY)',
            'creditCard_date' => 'Expiration Date (MM/YYYY)',
            'creditCard_name' => 'Name on Card',
            'customer_firstName' => 'First Name',
            'customer_lastName' => 'Last Name',
            'customer_company' => 'Company Name',
            'customer_phone' => 'Phone Number',
            'customer_fax' => 'Fax Number',
            'customer_website' => 'Website',
            'customer_email' => 'Email',
            'billing_firstName' => 'First Name',
            'billing_lastName' => 'Last Name',
            'billing_company' => 'Company Name',
            'billing_streetAddress' => 'Address',
            'billing_extendedAddress' => 'Address',
            'billing_locality' => 'City/Locality',
            'billing_region' => 'State/Region',
            'billing_postalCode' => 'Zip/Postal Code',
            'billing_countryCodeAlpha2' => 'Country',
            'shipping_firstName' => 'First Name',
            'shipping_lastName' => 'Last Name',
            'shipping_company' => 'Company Name',
            'shipping_streetAddress' => 'Address',
            'shipping_extendedAddress' => 'Address',
            'shipping_locality' => 'City/Locality',
            'shipping_region' => 'State/Region',
            'shipping_postalCode' => 'Zip/Postal Code',
            'shipping_countryCodeAlpha2' => 'Country',
        );
    }
}