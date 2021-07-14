<?php
/**
 * This file contains the transactional emails endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Endpoint_TransactionalEmails handles all the API calls for transactional emails.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 * @since 1.0
 */
class AdcruxApi_Endpoint_TransactionalEmails extends AdcruxApi_Base
{
    /**
     * Get all transactional emails of the current customer
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function getEmails($page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl('transactional-emails'),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage
            ),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }

    /**
     * Get one transactional email
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $emailUid
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function getEmail($emailUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('transactional-emails/%s', (string)$emailUid)),
            'paramsGet'     => array(),
            'enableCache'   => true,
        ));
        
        return $response = $client->request();
    }

    /**
     * Create a new transactional email
     *
     * @param array $data
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function create(array $data)
    {
        if (!empty($data['body'])) {
            $data['body'] = base64_encode($data['body']);
        }
        
        if (!empty($data['plain_text'])) {
            $data['plain_text'] = base64_encode($data['plain_text']);
        }
        
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_POST,
            'url'           => $this->getConfig()->getApiUrl('transactional-emails'),
            'paramsPost'    => array(
                'email'  => $data
            ),
        ));
        
        return $response = $client->request();
    }

    /**
     * Delete existing transactional email
     *
     * @param string $emailUid
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function delete($emailUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'    => AdcruxApi_Http_Client::METHOD_DELETE,
            'url'       => $this->getConfig()->getApiUrl(sprintf('transactional-emails/%s', $emailUid)),
        ));
        
        return $response = $client->request();
    }
}
