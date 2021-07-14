<?php
/**
 * This file contains the list segments endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_ListSegments handles all the API calls for handling the list segments.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_ListSegments extends AdcruxApi_Base
{
    /**
     * Get segments from a certain mail list
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $listUid
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getSegments($listUid, $page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/segments', $listUid)),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage
            ),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }
}
