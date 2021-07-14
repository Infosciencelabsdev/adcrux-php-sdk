<?php
/**
 * This file contains the customers endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_Customers handles all the API calls for customers.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_Customers extends AdcruxApi_Base
{
    /**
     * Create a new mail list for the customer
     *
     * The $data param must contain following indexed arrays:
     * -> customer
     * -> company
     *
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function create(array $data)
    {
        if (isset($data['customer']['password'])) {
            $data['customer']['confirm_password'] = $data['customer']['password'];
        }
        
        if (isset($data['customer']['email'])) {
            $data['customer']['confirm_email'] = $data['customer']['email'];
        }
        
        if (empty($data['customer']['timezone'])) {
            $data['customer']['timezone'] = 'UTC';
        }
        
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_POST,
            'url'           => $this->getConfig()->getApiUrl('customers'),
            'paramsPost'    => $data,
        ));
        
        return $response = $client->request();
    }
}
