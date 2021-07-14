<?php
/**
 * This file contains the campaigns endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_Campaigns handles all the API calls for campaigns.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_Campaigns extends AdcruxApi_Base
{
    /**
     * Get all the campaigns of the current customer
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getCampaigns($page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl('campaigns'),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage
            ),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }

    /**
     * Get one campaign
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $campaignUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getCampaign($campaignUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('campaigns/%s', (string)$campaignUid)),
            'paramsGet'     => array(),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }

    /**
     * Create a new campaign
     *
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function create(array $data)
    {
        if (isset($data['template']['content'])) {
            $data['template']['content'] = base64_encode($data['template']['content']);
        }
        
        if (isset($data['template']['archive'])) {
            $data['template']['archive'] = base64_encode($data['template']['archive']);
        }
        
        if (isset($data['template']['plain_text'])) {
            $data['template']['plain_text'] = base64_encode($data['template']['plain_text']);
        }
        
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_POST,
            'url'           => $this->getConfig()->getApiUrl('campaigns'),
            'paramsPost'    => array(
                'campaign'  => $data
            ),
        ));
        
        return $response = $client->request();
    }

    /**
     * Update existing campaign for the customer
     *
     * @param string $campaignUid
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function update($campaignUid, array $data)
    {
        if (isset($data['template']['content'])) {
            $data['template']['content'] = base64_encode($data['template']['content']);
        }
        
        if (isset($data['template']['archive'])) {
            $data['template']['archive'] = base64_encode($data['template']['archive']);
        }
        
        if (isset($data['template']['plain_text'])) {
            $data['template']['plain_text'] = base64_encode($data['template']['plain_text']);
        }
        
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_PUT,
            'url'           => $this->getConfig()->getApiUrl(sprintf('campaigns/%s', $campaignUid)),
            'paramsPut'     => array(
                'campaign'  => $data
            ),
        ));
        
        return $response = $client->request();
    }

    /**
     * Copy existing campaign for the customer
     *
     * @param string $campaignUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function copy($campaignUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_POST,
            'url'       => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/copy', $campaignUid)),
        ));
        
        return $response = $client->request();
    }

    /**
     * Pause/Unpause existing campaign
     *
     * @param string $campaignUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function pauseUnpause($campaignUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_PUT,
            'url'       => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/pause-unpause', $campaignUid)),
        ));
        
        return $response = $client->request();
    }

    /**
     * Mark existing campaign as sent
     *
     * @param string $campaignUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function markSent($campaignUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_PUT,
            'url'       => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/mark-sent', $campaignUid)),
        ));
        
        return $response = $client->request();
    }

    /**
     * Delete existing campaign for the customer
     *
     * @param string $campaignUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function delete($campaignUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_DELETE,
            'url'       => $this->getConfig()->getApiUrl(sprintf('campaigns/%s', $campaignUid)),
        ));
        
        return $response = $client->request();
    }

    /**
     * Get the stats for an existing campaign for the customer
     *
     * @param string $campaignUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getStats($campaignUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_GET,
            'url'       => $this->getConfig()->getApiUrl(sprintf('campaigns/%s/stats', $campaignUid)),
        ));

        return $response = $client->request();
    }
}
