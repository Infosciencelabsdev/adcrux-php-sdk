<?php
/**
 * This file contains the lists subscribers endpoint for AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */


/**
 * AdcruxApi_Endpoint_ListSubscribers handles all the API calls for lists subscribers.
 *
 * @package AdcruxApi
 * @subpackage Endpoint
 */
class AdcruxApi_Endpoint_ListSubscribers extends AdcruxApi_Base
{
    /**
     * Get subscribers from a certain mail list
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $listUid
     * @param integer $page
     * @param integer $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function getSubscribers($listUid, $page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers', $listUid)),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage,
            ),
            'enableCache'   => true,
        ));

        return $response = $client->request();
    }

    /**
     * Get one subscriber from a certain mail list
     *
     * Note, the results returned by this endpoint can be cached.
     *
     * @param string $listUid
     * @param string $subscriberUid
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function getSubscriber($listUid, $subscriberUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers/%s', (string)$listUid, (string)$subscriberUid)),
            'paramsGet'     => array(),
            'enableCache'   => true,
        ));

        return $response = $client->request();
    }

    /**
     * Create a new subscriber in the given list
     *
     * @param string $listUid
     * @param array $data
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function create($listUid, array $data)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_POST,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers', (string)$listUid)),
            'paramsPost'    => $data,
        ));

        return $response = $client->request();
    }

    /**
     * Create subscribers in bulk in the given list
     *
     * @param string $listUid
     * @param array $data
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function createBulk($listUid, array $data)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_POST,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers/bulk', (string)$listUid)),
            'paramsPost'    => array('subscribers' => $data),
        ));

        return $response = $client->request();
    }

    /**
     * Update existing subscriber in given list
     *
     * @param string $listUid
     * @param string $subscriberUid
     * @param array $data
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function update($listUid, $subscriberUid, array $data)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_PUT,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers/%s', (string)$listUid, (string)$subscriberUid)),
            'paramsPut'     => $data,
        ));

        return $response = $client->request();
    }

    /**
     * Update existing subscriber by email address
     *
     * @param string $listUid
     * @param string $emailAddress
     * @param array $data
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function updateByEmail($listUid, $emailAddress, array $data)
    {
        $response = $this->emailSearch($listUid, $emailAddress);

        // the request failed.
        if ($response->getIsCurlError()) {
            return $response;
        }

        $bodyData = $response->body->itemAt('data');

        // subscriber not found.
        if ($response->getIsError() && $response->getHttpCode() == 404) {
            return $response;
        }

        if (empty($bodyData['subscriber_uid'])) {
            return $response;
        }

        return $this->update($listUid, $bodyData['subscriber_uid'], $data);
    }

    /**
     * Unsubscribe existing subscriber from given list
     *
     * @param string $listUid
     * @param string $subscriberUid
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function unsubscribe($listUid, $subscriberUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_PUT,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers/%s/unsubscribe', (string)$listUid, (string)$subscriberUid)),
            'paramsPut'     => array(),
        ));

        return $response = $client->request();
    }

    /**
     * Unsubscribe existing subscriber by email address
     *
     * @param string $listUid
     * @param string $emailAddress
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function unsubscribeByEmail($listUid, $emailAddress)
    {
        $response = $this->emailSearch($listUid, $emailAddress);

        // the request failed.
        if ($response->getIsCurlError()) {
            return $response;
        }

        $bodyData = $response->body->itemAt('data');

        // subscriber not found.
        if ($response->getIsError() && $response->getHttpCode() == 404) {
            return $response;
        }

        if (empty($bodyData['subscriber_uid'])) {
            return $response;
        }

        return $this->unsubscribe($listUid, $bodyData['subscriber_uid']);
    }

    /**
     * Unsubscribe existing subscriber by email address from all lists
     *
     * @param string $emailAddress
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function unsubscribeByEmailFromAllLists($emailAddress)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_PUT,
            'url'           => $this->getConfig()->getApiUrl('lists/subscribers/unsubscribe-by-email-from-all-lists'),
            'paramsPut'     => array(
                'EMAIL' => $emailAddress,
            ),
        ));

        return $response = $client->request();
    }


    /**
     * Delete existing subscriber in given list
     *
     * @param string $listUid
     * @param string $subscriberUid
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function delete($listUid, $subscriberUid)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_DELETE,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers/%s', (string)$listUid, (string)$subscriberUid)),
            'paramsDelete'  => array(),
        ));

        return $response = $client->request();
    }

    /**
     * Delete existing subscriber by email address
     *
     * @param string $listUid
     * @param string $emailAddress
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function deleteByEmail($listUid, $emailAddress)
    {
        $response = $this->emailSearch($listUid, $emailAddress);
        $bodyData = $response->body->itemAt('data');

        if ($response->getIsError() || empty($bodyData['subscriber_uid'])) {
            return $response;
        }

        return $this->delete($listUid, $bodyData['subscriber_uid']);
    }

    /**
     * Search in a list for given subscriber by email address
     *
     * @param string $listUid
     * @param string $emailAddress
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function emailSearch($listUid, $emailAddress)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers/search-by-email', (string)$listUid)),
            'paramsGet'     => array('EMAIL' => (string)$emailAddress),
        ));

        return $response = $client->request();
    }

    /**
     * Search in a all lists for given subscriber by email address
     *
     * @param string $emailAddress
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function emailSearchAllLists($emailAddress)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl('lists/subscribers/search-by-email-in-all-lists'),
            'paramsGet'     => array('EMAIL' => (string)$emailAddress),
        ));

        return $response = $client->request();
    }

    /**
     * Search in a list by custom fields
     *
     * @param string $listUid
     * @param array $fields
     * @param int $page
     * @param int $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function searchByCustomFields($listUid, array $fields = array(), $page = 1, $perPage = 10)
    {
        $paramsGet = $fields;
        $paramsGet['page']      = (int)$page;
        $paramsGet['per_page']  = (int)$perPage;
        
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers/search-by-custom-fields', (string)$listUid)),
            'paramsGet'     => $paramsGet,
        ));

        return $response = $client->request();
    }

    /**
     * Search in a list for given subscribers by status
     *
     * @param string $listUid
     * @param string $status
     * @param int $page
     * @param int $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function searchByStatus($listUid, $status, $page = 1, $perPage = 10)
    {
        $client = new AdcruxApi_Http_Client(array(
            'method'        => AdcruxApi_Http_Client::METHOD_GET,
            'url'           => $this->getConfig()->getApiUrl(sprintf('lists/%s/subscribers', $listUid)),
            'paramsGet'     => array(
                'page'      => (int)$page,
                'per_page'  => (int)$perPage,
                'status'    => $status,
            ),
            'enableCache'   => true,
        ));

        return $response = $client->request();
    }

    /**
     * Get only the confirmed subscribers
     *
     * @param string $listUid
     * @param int $page
     * @param int $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getConfirmedSubscribers($listUid, $page = 1, $perPage = 10)
    {
        return $this->searchByStatus($listUid, 'confirmed', $page, $perPage);
    }

    /**
     * Get only the unconfirmed subscribers
     *
     * @param string $listUid
     * @param int $page
     * @param int $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getUnconfirmedSubscribers($listUid, $page = 1, $perPage = 10)
    {
        return $this->searchByStatus($listUid, 'unconfirmed', $page, $perPage);
    }

    /**
     * Get only the unsubscribed subscribers
     *
     * @param string $listUid
     * @param int $page
     * @param int $perPage
     *
     * @return AdcruxApi_Http_Response
     * @throws ReflectionException
     */
    public function getUnsubscribedSubscribers($listUid, $page = 1, $perPage = 10)
    {
        return $this->searchByStatus($listUid, 'unsubscribed', $page, $perPage);
    }

    /**
     * Create or update a subscriber in given list
     *
     * @param string $listUid
     * @param array $data
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function createUpdate($listUid, $data)
    {
        $emailAddress    = !empty($data['EMAIL']) ? $data['EMAIL'] : null;
        $response        = $this->emailSearch($listUid, $emailAddress);

        // the request failed.
        if ($response->getIsCurlError()) {
            return $response;
        }

        $bodyData = $response->body->itemAt('data');

        // subscriber not found.
        if ($response->getIsError() && $response->getHttpCode() == 404) {
            return $this->create($listUid, $data);
        }

        if (empty($bodyData['subscriber_uid'])) {
            return $response;
        }

        return $this->update($listUid, $bodyData['subscriber_uid'], $data);
    }
}
