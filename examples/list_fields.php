<?php
/**
 * This file contains examples for using the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
// require the setup which has registered the autoloader
require_once dirname(__FILE__) . '/setup.php';

// CREATE THE ENDPOINT
$endpoint = new AdcruxApi_Endpoint_ListFields();

/*===================================================================================*/

// GET ALL ITEMS
$response = $endpoint->getFields('LIST-UNIQUE-ID');

// DISPLAY RESPONSE
echo '<pre>';
print_r($response->body);
echo '</pre>';
