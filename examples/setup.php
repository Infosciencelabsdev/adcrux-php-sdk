<?php
/**
 * This file contains an example of base setup for the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */

exit('COMMENT ME TO TEST THE EXAMPLES!');

// require the autoloader class if you haven't used composer to install the package
require_once dirname(__FILE__) . '/../AdcruxApi/Autoloader.php';

// register the autoloader if you haven't used composer to install the package
AdcruxApi_Autoloader::register();

// if using a framework that already uses an autoloading mechanism, like Yii for example,
// you can register the autoloader like:
// Yii::registerAutoloader(array('AdcruxApi_Autoloader', 'autoloader'), true);

/**
 *
 * Configuration components:
 * The api return proper etags when GET requests are made.
 * We can use this to cache the request response in order to decrease loading time therefore improving performance.
 * In this case, we will need to use a cache component that will store the responses and a file cache will do it just fine.
 * Please see AdcruxApi/Cache for a list of available cache components and their usage.
 */

// configuration object
$config = new AdcruxApi_Config(array(
    'apiUrl'        => 'http://adcrux.io/api',
    'publicKey'     => 'PUBLIC-KEY',
    'privateKey'    => 'PRIVATE-KEY',

    // components
    'components' => array(
        'cache' => array(
            'class'     => 'AdcruxApi_Cache_File',
            'filesPath' => dirname(__FILE__) . '/../AdcruxApi/Cache/data/cache', // make sure it is writable by webserver
        )
    ),
));

// now inject the configuration and we are ready to make api calls
AdcruxApi_Base::setConfig($config);

// start UTC
date_default_timezone_set('UTC');
