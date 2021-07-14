<?php
/**
 * This file contains the AdcruxApi_Http_Request class used in the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */


/**
 * AdcruxApi_Http_Request is the request class used to send the requests to the API endpoints.
 *
 * @package AdcruxApi
 * @subpackage Http
 * @since 1.0
 */
class AdcruxApi_Http_Request extends AdcruxApi_Base
{
    /**
     * @var AdcruxApi_Http_Client the http client injected.
     */
    public $client;

    /**
     * @var AdcruxApi_Params the request params.
     */
    public $params;

    /**
     * Constructor.
     *
     * @param AdcruxApi_Http_Client $client
     */
    public function __construct(AdcruxApi_Http_Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the request to the remote url.
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function send()
    {
        foreach ($this->getEventHandlers(self::EVENT_BEFORE_SEND_REQUEST) as $callback) {
            call_user_func_array($callback, array($this));
        }

        $client         = $this->client;
        $registry       = $this->getRegistry();
        $isCacheable    = $registry->contains('cache') && $client->getIsGetMethod() && $client->enableCache;
        $requestUrl     = rtrim($client->url, '/'); // no trailing slash
        $scheme         = parse_url($requestUrl, PHP_URL_SCHEME);

        $getParams = (array)$client->paramsGet->toArray();
        if (!empty($getParams)) {
            ksort($getParams, SORT_STRING);
            $queryString = http_build_query($getParams, '', '&');
            if (!empty($queryString)) {
                $requestUrl .= '?'.$queryString;
            }
        }

        $this->sign($requestUrl);

        $etagCache = '';
        $cacheKey  = '';
        
        /** @var AdcruxApi_Cache_Abstract $cacheComponent */
        $cacheComponent = null;
        
        if ($isCacheable) {
            $client->getResponseHeaders = true;

            $bodyFromCache  = null;
            $etagCache      = '';
            $params         = $getParams;

            foreach (array('X-MW-PUBLIC-KEY', 'X-MW-TIMESTAMP', 'X-MW-REMOTE-ADDR') as $header) {
                $params[$header] = $client->headers->itemAt($header);
            }

            $cacheKey = $requestUrl;
            
            /** @var AdcruxApi_Cache_Abstract $cacheComponent */
            $cacheComponent = $registry->itemAt('cache');
            
            /** @var array $cache */
            $cache = $cacheComponent->get($cacheKey);

            if (isset($cache['headers']) && is_array($cache['headers'])) {
                foreach ($cache['headers'] as $header) {
                    if (preg_match('/etag:(\s+)?(.*)/ix', $header, $matches)) {
                        $etagCache = trim($matches[2]);
                        $client->headers->add('If-None-Match', $etagCache);
                        $bodyFromCache = $cache['body'];
                        break;
                    }
                }
            }
        }

        if ($client->getIsPutMethod() || $client->getIsDeleteMethod()) {
            $client->headers->add('X-HTTP-Method-Override', strtoupper($client->method));
        }

        $ch = curl_init($requestUrl);
	    if ($ch === false) {
		    throw new Exception('Cannot initialize curl!');
	    }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $client->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $client->timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AdcruxApi Client version '. AdcruxApi_Http_Client::CLIENT_VERSION);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);

        if ($client->getResponseHeaders) {
            // curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if (!ini_get('safe_mode')) {
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            if (!ini_get('open_basedir')) {
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            }
        }

        if ($client->headers->count > 0) {
            $headers = array();
            foreach ($client->headers as $name => $value) {
                $headers[] = $name.': '.$value;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        //if ($scheme === 'https') {
        //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //}

        if ($client->getIsPostMethod() || $client->getIsPutMethod() || $client->getIsDeleteMethod()) {
            $params = new AdcruxApi_Params($client->paramsPost);
            $params->mergeWith($client->paramsPut);
            $params->mergeWith($client->paramsDelete);

            if (!$client->getIsPostMethod()) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($client->method));
            }

            curl_setopt($ch, CURLOPT_POST, $params->count);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params->toArray(), '', '&'));
        }

        $body           = (string)curl_exec($ch);
        $curlCode       = (int)curl_errno($ch);
        $curlMessage    = (string)curl_error($ch);

        $curlInfo = curl_getinfo($ch);
        $params = $this->params = new AdcruxApi_Params($curlInfo);

        if ($curlCode === 0 && $client->getResponseHeaders) {
            $headersSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = explode("\n", substr($body, 0, $headersSize));
            foreach ($headers as $index => $header) {
                $header = trim($header);
                if (empty($header)) {
                    unset($headers[$index]);
                }
            }
            $body = substr($body, $headersSize);
            $params->add('headers', new AdcruxApi_Params($headers));
        }

        $decodedBody = array();
        if ($curlCode === 0 && !empty($body)) {
            $decodedBody = json_decode($body, true);
            if (!is_array($decodedBody)) {
                $decodedBody = array();
            }
        }

        // note here
        if ((int)$params->itemAt('http_code') === 304 && $isCacheable && !empty($bodyFromCache)) {
            $decodedBody = $bodyFromCache;
        }

        $params->add('curl_code', $curlCode);
        $params->add('curl_message', $curlMessage);
        $params->add('body', new AdcruxApi_Params($decodedBody));

        $response = new AdcruxApi_Http_Response($this);
        $body = $response->body;

        if (!$response->getIsSuccess() && $body->itemAt('status') !== 'success' && !$body->contains('error')) {
            $response->body->add('status', 'error');
            $response->body->add('error', $response->getMessage());
        }

        curl_close($ch);

        if ($isCacheable && $response->getIsSuccess() && $body->itemAt('status') == 'success') {
            $etagNew = null;
            foreach ($response->headers as $header) {
                if (preg_match('/etag:(\s+)?(.*)/ix', $header, $matches)) {
                    $etagNew = trim($matches[2]);
                    break;
                }
            }
            if ($etagNew && $etagNew != $etagCache) {
                $cacheComponent->set($cacheKey, array(
                    'headers'   => $response->headers->toArray(),
                    'body'      => $response->body->toArray(),
                ));
            }
        }

        foreach ($this->getEventHandlers(self::EVENT_AFTER_SEND_REQUEST) as $callback) {
            $response = call_user_func_array($callback, array($this, $response));
        }

        return $response;
    }

    /**
     * Sign the current request.
     *
     * @param string $requestUrl
     * @return void
     *
     * @throws Exception
     */
    protected function sign($requestUrl)
    {
        $client = $this->client;
        $config = $this->getConfig();

        $publicKey  = $config->publicKey;
        $privateKey = $config->privateKey;
        $timestamp  = time();

        $specialHeaderParams = array(
            'X-MW-PUBLIC-KEY'   => $publicKey,
            'X-MW-TIMESTAMP'    => $timestamp,
            'X-MW-REMOTE-ADDR'  => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
        );

        foreach ($specialHeaderParams as $key => $value) {
            $client->headers->add($key, $value);
        }

        $params = new AdcruxApi_Params($specialHeaderParams);
        $params->mergeWith($client->paramsPost);
        $params->mergeWith($client->paramsPut);
        $params->mergeWith($client->paramsDelete);

        $params = $params->toArray();
        ksort($params, SORT_STRING);

        $separator          = $client->paramsGet->count > 0 && strpos($requestUrl, '?') !== false ? '&' : '?';
        $signatureString    = strtoupper($client->method) . ' ' . $requestUrl . $separator . http_build_query($params, '', '&');
        $signature          = hash_hmac('sha1', $signatureString, $privateKey, false);

        $client->headers->add('X-MW-SIGNATURE', $signature);
    }
}
