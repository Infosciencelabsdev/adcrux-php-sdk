<?php
/**
 * This file contains the campaign bounces endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */


/**
 * AdcruxApi_Endpoint_CampaignBounces handles all the API calls for campaign bounces.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_CampaignBounces extends AdcruxApi_Base
{
    /**
     * Get bounces from a certain campaign
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $campaignUid
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getBounces($campaignUid, $page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/bounces', $campaignUid)),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage,
            ),
            'enableCache'   => true,
        ));

        return $response = $client->request();
    }

    /**
     * Create a new bounce in the given campaign
     *
     * @param string $campaignUid
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function create($campaignUid, array $data)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_POST,
            'url'           => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/bounces', (string)$campaignUid)),
            'paramsPost'    => $data,
        ));

        return $response = $client->request();
    }
}
