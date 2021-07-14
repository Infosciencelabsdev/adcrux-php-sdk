<?php
/**
 * This file contains the lists fields endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_ListFields handles all the API calls for handling the list custom fields.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_ListFields extends AdcruxApi_Base
{
    /**
     * Get fields from a certain mail list
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $listUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getFields($listUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/fields', $listUid)),
            'paramsGet'     => array(),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }
}
