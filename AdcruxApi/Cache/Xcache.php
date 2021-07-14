<?php
/**
 * This file contains the APC cache class used in the AdcruxApi PHP-SDK.
 *
 * @link https://adcrux.io/
 */
 
 
/**
 * AdcruxApi_Cache_Xcache makes use of the xcache extension in order to cache data in memory.
 *
 * As all the data will stay in memory, it is recommeded that will be used only if
 * the system has enough memory, or for development/small servers.
 *
 * @package AdcruxApi
 * @subpackage Cache
 * @since 1.0
 */
class AdcruxApi_Cache_Xcache extends AdcruxApi_Cache_Abstract
{
    /**
     * Cache data by given key.
     *
     * For consistency, the key will go through sha1() before it is saved.
     *
     * This method implements {@link AdcruxApi_Cache_Abstract::set()}.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set($key, $value)
    {
        return xcache_set(sha1($key), $value, 0);
    }
    
    /**
     * Get cached data by given key.
     *
     * For consistency, the key will go through sha1()
     * before it will be used to retrieve the cached data.
     *
     * This method implements {@link AdcruxApi_Cache_Abstract::get()}.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return xcache_isset(sha1($key)) ? xcache_get(sha1($key)) : null;
    }
    
    /**
     * Delete cached data by given key.
     *
     * For consistency, the key will go through sha1()
     * before it will be used to delete the cached data.
     *
     * This method implements {@link AdcruxApi_Cache_Abstract::delete()}.
     *
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return xcache_unset(sha1($key));
    }
    
    /**
     * Delete all cached data.
     *
     * This method implements {@link AdcruxApi_Cache_Abstract::flush()}.
     *
     * @return bool
     */
    public function flush()
    {
        if (!defined('XC_TYPE_VAR')) {
            return false;
        }
        for ($i = 0, $max = xcache_count(XC_TYPE_VAR); $i < $max; $i++) {
            xcache_clear_cache(XC_TYPE_VAR, $i);
        }
        return true;
    }
}
