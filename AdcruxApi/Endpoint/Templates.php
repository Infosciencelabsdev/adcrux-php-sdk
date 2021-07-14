<?php
/**
 * This file contains the templates endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_Templates handles all the API calls for email templates.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_Templates extends AdcruxApi_Base
{
    /**
     * Get all the email templates of the current customer
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getTemplates($page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl('templates'),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage
            ),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }

    /**
     * Search through all the email templates of the current customer
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param integer $page
     * @param integer $perPage
     * @param array $filter
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     * @since Adcrux 1.4.4
     */
    public function searchTemplates($page = 1, $perPage = 10, array $filter = array())
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl('templates'),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage,
                'filter'    => $filter,
            ),
            'enableCache'   => true,
        ));

        return $response = $client->request();
    }

    /**
     * Get one template
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $templateUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getTemplate($templateUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('templates/%s', (string)$templateUid)),
            'paramsGet'     => array(),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }

    /**
     * Create a new template
     *
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function create(array $data)
    {
        if (isset($data['content'])) {
            $data['content'] = base64_encode($data['content']);
        }
        
        if (isset($data['archive'])) {
            $data['archive'] = base64_encode($data['archive']);
        }
        
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_POST,
            'url'           => $this->getConfig()->getApiUrl('templates'),
            'paramsPost'    => array(
                'template'  => $data
            ),
        ));
        
        return $response = $client->request();
    }

    /**
     * Update existing template for the customer
     *
     * @param string $templateUid
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function update($templateUid, array $data)
    {
        if (isset($data['content'])) {
            $data['content'] = base64_encode($data['content']);
        }
        
        if (isset($data['archive'])) {
            $data['archive'] = base64_encode($data['archive']);
        }
        
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_PUT,
            'url'           => $this->getConfig()->getApiUrl(sprintf('templates/%s', $templateUid)),
            'paramsPut'     => array(
                'template'  => $data
            ),
        ));
        
        return $response = $client->request();
    }

    /**
     * Delete existing template for the customer
     *
     * @param string $templateUid
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function delete($templateUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_DELETE,
            'url'       => $this->getConfig()->getApiUrl(sprintf('templates/%s', $templateUid)),
        ));
        
        return $response = $client->request();
    }
}
