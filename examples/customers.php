<?php
/**
 * This file contains examples for using the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
// require the setup which has registered the autoloader
require_once dirname(__FILE__) . '/setup.php';

// CREATE THE ENDPOINT
$endpoint = new AdcruxApi_Endpoint_Customers();
/*===================================================================================*/

// CREATE CUSTOMER
$response = $endpoint->create(array(
    'customer' => array(
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'email'      => 'john.doe@doe.com',
        'password'   => 'superDuperPassword',
        'timezone'   => 'UTC',
    ),
    // company is optional, unless required from app settings
    'company'  => array(
        'name'     => 'John Doe LLC',
        'country'  => 'United States', // see the countries endpoint for available countries and their zones
        'zone'     => 'New York', // see the countries endpoint for available countries and their zones
        'city'     => 'Brooklyn',
        'zip_code' => 11222,
        'address_1'=> 'Some Address',
        'address_2'=> 'Some Other Address',
    ),
));

// DISPLAY RESPONSE
echo '<hr /><pre>';
print_r($response->body);
echo '</pre>';
