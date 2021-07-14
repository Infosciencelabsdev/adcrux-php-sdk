<?php
/**
 * This file contains the configuration class for the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Config contains the configuration class that is injected at runtime into the main application.
 *
 * It's only purpose is to set the needed data so that the API calls will run without problems.
 *
 * @package AdcruxApi
 * @since 1.0
 */
class AdcruxApi_Config extends AdcruxApi_Base
{
    /**
     * @var string the api public key
     */
    public $publicKey;
    
    /**
     * @var string the api private key.
     */
    public $privateKey;

    /**
     * @var string the preffered charset.
     */
    public $charset = 'utf-8';
    
    /**
     * @var string the API url.
     */
    private $_apiUrl;

    /**
     * Constructor
     *
     * @param array $config the config array that will populate the class properties.
     *
     * @throws ReflectionException
     */
    public function __construct(array $config = array())
    {
        $this->populateFromArray($config);
    }

    /**
     * Setter for the API url.
     *
     * Please note, this url should NOT contain any endpoint,
     * just the base url to the API.
     *
     * Also, a basic url check is done, but you need to make sure the url is valid.
     *
     * @param mixed $url
     *
     * @return AdcruxApi_Config
     * @throws Exception
     */
    public function setApiUrl($url)
    {
        if (!parse_url($url, PHP_URL_HOST)) {
            throw new Exception('Please set a valid api base url.');
        }

        $this->_apiUrl = trim($url, '/') . '/';
        return $this;
    }

    /**
     * Getter for the API url.
     *
     * Also, you can use the $endpoint param to point the request to a certain endpoint.
     *
     * @param string $endpoint
     *
     * @return string
     * @throws Exception
     */
    public function getApiUrl($endpoint = null)
    {
        if ($this->_apiUrl === null) {
            throw new Exception('Please set the api base url.');
        }
        
        return $this->_apiUrl . $endpoint;
    }
}