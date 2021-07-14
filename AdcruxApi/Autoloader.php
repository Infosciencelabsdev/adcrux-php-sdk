<?php
/**
 * This file contains the autoloader class for the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io
 */
 
 
/**
 * The AdcruxApi Autoloader class.
 *
 * From within a Yii Application, you would load this as:
 *
 * <pre>
 * require_once(Yii::getPathOfAlias('application.vendors.AdcruxApi.Autoloader').'.php');
 * Yii::registerAutoloader(array('AdcruxApi_Autoloader', 'autoloader'), true);
 * </pre>
 *
 * Alternatively you can:
 * <pre>
 * require_once('Path/To/AdcruxApi/Autoloader.php');
 * AdcruxApi_Autoloader::register();
 * </pre>
 *
 * @package AdcruxApi
 * @since 1.0
 */
class AdcruxApi_Autoloader
{
    /**
     * The registrable autoloader
     *
     * @param string $class
     * @return void
     */
    public static function autoloader($class)
    {
        if (strpos($class, 'AdcruxApi') === 0) {
            $className = str_replace('_', '/', $class);
            $className = substr($className, 12);
            
            if (is_file($classFile = dirname(__FILE__) . '/'. $className.'.php')) {
                require_once($classFile);
            }
        }
    }
    
    /**
     * Registers the AdcruxApi_Autoloader::autoloader()
     *
     * @return void
     */
    public static function register()
    {
        spl_autoload_register('AdcruxApi_Autoloader::autoloader');
    }
}
