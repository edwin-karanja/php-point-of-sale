<?php
/**
 * Created by PhpStorm.
 * User: pixeledge
 * Date: 06/07/2018
 * Time: 22:14
 */

namespace App\Helpers\Cache;


use App\Models\Item;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Cache\CacheInterface;

class ItemsCache implements CacheInterface
{
    /**
     * @param $key
     * @param int $duration
     * @return mixed
     * @throws \Exception
     */
    public function getCache($key, $duration = 180)
    {
        $hashedKey = $this->getHashedKey( $key );
        if (Cache::has( $hashedKey )) {
            $data = Cache::get( $hashedKey );
        } else {
            $method = camel_case( $key );
            if ( method_exists( $this, $method )) {
                $data = $this->$method();
                Cache::put( $hashedKey, $data, $duration );
            } else {
                throw new \Exception( 'That method does not exist' );
            }
        }

        return $data;
    }

    public function clearCache($key)
    {
        $hashedKey = $this->getHashedKey($key);

        Cache::forget($hashedKey);
    }

    private function getHashedKey($key)
    {
        return md5('cache' . $key);
    }

    private function groupedItems()
    {
        return Item::getGroupedItems();
    }

    private function inventoryItems()
    {
        return Item::updatesFirst()->with('category')->get();
    }
}