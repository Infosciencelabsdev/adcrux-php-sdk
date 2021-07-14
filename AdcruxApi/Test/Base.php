<?php

use PHPUnit\Framework\TestCase;

/**
 * Class Base
 */
class AdcruxApi_Test_Base extends TestCase
{
    public function setUp()
    {
        // configuration object
        try {
            AdcruxApi_Base::setConfig(new AdcruxApi_Config(array(
                'apiUrl'     => getenv('ADCRUX_API_URL'),
                'publicKey'  => getenv('ADCRUX_API_PUBLIC_KEY'),
                'privateKey' => getenv('ADCRUX_API_PRIVATE_KEY'),
            )));
        } catch (ReflectionException $e) {
        }
        
        // start UTC
        date_default_timezone_set('UTC');

        parent::setUp();
    }
}
