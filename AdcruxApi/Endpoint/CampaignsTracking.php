<?php
/**
 * This file contains the campaigns endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_CampaignsTracking handles all the API calls for campaigns.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_CampaignsTracking extends AdcruxApi_Base
{
    /**
     * Track campaign url click for certain subscriber
     *
     * @param string $campaignUid
     * @param string $subscriberUid
     * @param string $hash
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function trackUrl($campaignUid, $subscriberUid, $hash)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_GET,
            'url'       => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/track-url/%s/%s', (string)$campaignUid, (string)$subscriberUid, (string)$hash)),
            'paramsGet' => array(),
        ));
        
        return $response = $client->request();
    }

    /**
     * Track campaign open for certain subscriber
     *
     * @param string $campaignUid
     * @param string $subscriberUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function trackOpening($campaignUid, $subscriberUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_GET,
            'url'       => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/track-opening/%s', (string)$campaignUid, (string)$subscriberUid)),
            'paramsGet' => array(),
        ));

        return $response = $client->request();
    }

    /**
     * Track campaign unsubscribe for certain subscriber
     *
     * @param string $campaignUid
     * @param string $subscriberUid
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function trackUnsubscribe($campaignUid, $subscriberUid, array $data = array())
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'     => AdcruxApi_Http_Client::METHOD_POST,
            'url'        => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/track-unsubscribe/%s', (string)$campaignUid, (string)$subscriberUid)),
            'paramsPost' => $data,
        ));

        return $response = $client->request();
    }
}
