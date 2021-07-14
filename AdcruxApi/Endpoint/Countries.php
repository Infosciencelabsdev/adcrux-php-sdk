<?php
/**
 * This file contains the countries endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_Countries handles all the API calls for handling the countries and their zones.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_Countries extends AdcruxApi_Base
{
    /**
     * Get all available countries
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getCountries($page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl('countries'),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage
            ),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }

    /**
     * Get all available country zones
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param integer $countryId
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getZones($countryId, $page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('countries/%d/zones', $countryId)),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage
            ),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }
}
