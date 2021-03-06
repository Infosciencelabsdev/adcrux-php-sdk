<?php
/**
 * This file contains the AdcruxApi_Http_Client class used in the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Http_Client is the http client interface used to make the remote requests and receive the responses.
 *
 * @package AdcruxApi
 * @subpackage Http
 * @since 1.0
 */
class AdcruxApi_Http_Client extends AdcruxApi_Base
{
    /**
     * Marker for GET requests.
     */
    const METHOD_GET     = 'GET';
    
    /**
     * Marker for POST requests.
     */
    const METHOD_POST    = 'POST';
    
    /**
     * Marker for PUT requests.
     */
    const METHOD_PUT     = 'PUT';
    
    /**
     * Marker for DELETE requests.
     */
    const METHOD_DELETE = 'DELETE';
    
    /**
     * Marker for the client version.
     */
    const CLIENT_VERSION = '1.0';

    /**
     * @var AdcruxApi_Params the GET params sent in the request.
     */
    public $paramsGet;
    
    /**
     * @var AdcruxApi_Params the POST params sent in the request.
     */
    public $paramsPost;
    
    /**
     * @var AdcruxApi_Params the PUT params sent in the request.
     */
    public $paramsPut;
    
    /**
     * @var AdcruxApi_Params the DELETE params sent in the request.
     */
    public $paramsDelete;
    
    /**
     * @var AdcruxApi_Params the headers sent in the request.
     */
    public $headers;

    /**
     * @var string the url where the remote calls will be made.
     */
    public $url;

    /**
     * @var int the default timeout for request.
     */
    public $timeout = 30;
    
    /**
     * @var bool whether to sign the request.
     */
    public $signRequest = true;
    
    /**
     * @var bool whether to get the response headers.
     */
    public $getResponseHeaders = false;
    
    /**
     * @var bool whether to cache the request response.
     */
    public $enableCache = false;
    
    /**
     * @var string the method used in the request.
     */
    public $method = self::METHOD_GET;

    /**
     * Constructor.
     *
     * @param array $options
     *
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(array $options = array())
    {
        $this->populateFromArray($options);
        
        foreach (array('paramsGet', 'paramsPost', 'paramsPut', 'paramsDelete', 'headers') as $param) {
            if (!($this->$param instanceof AdcruxApi_Params)) {
                $this->$param = new AdcruxApi_Params(!is_array($this->$param) ? array() : $this->$param);
            }
        }
    }

    /**
     * Whether the request method is a GET method.
     *
     * @return bool
     */
    public function getIsGetMethod()
    {
        return strtoupper($this->method) === self::METHOD_GET;
    }
    
    /**
     * Whether the request method is a POST method.
     *
     * @return bool
     */
    public function getIsPostMethod()
    {
        return strtoupper($this->method) === self::METHOD_POST;
    }
    
    /**
     * Whether the request method is a PUT method.
     *
     * @return bool
     */
    public function getIsPutMethod()
    {
        return strtoupper($this->method) === self::METHOD_PUT;
    }
    
    /**
     * Whether the request method is a DELETE method.
     *
     * @return bool
     */
    public function getIsDeleteMethod()
    {
        return strtoupper($this->method) === self::METHOD_DELETE;
    }

    /**
     * Makes the request to the remote host.
     *
     * @return AdcruxApi_Http_Response
     * @throws Exception
     */
    public function request()
    {
        $request = new AdcruxApi_Http_Request($this);
        return $response = $request->send();
    }
}
