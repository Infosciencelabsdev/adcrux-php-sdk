<?php
/**
 * This file contains the campaign bounces endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */


/**
 * AdcruxApi_Endpoint_CampaignUnsubscribes handles all the API calls for campaign unsubscribes.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_CampaignUnsubscribes extends AdcruxApi_Base
{
    /**
     * Get unsubscribes from a certain campaign
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
    public function getUnsubscribes($campaignUid, $page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/unsubscribes', $campaignUid)),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage,
            ),
            'enableCache'   => true,
        ));

        return $response = $client->request();
    }
}
