<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearCache
{

    /**
     * This function is responsible for clearing the cache when a specific cache key is passed.
     * It is useful for paginated Resources that are cached
     *
     * @param int $key The cache key index
     */
    public function clearCache($key, $text = '')
    {
        // si no tiene paginacion
        if ($text !== '' and Cache::has($key . $text)) {
            Cache::forget($key . $text);
        }
        // si no tiene paginacion
        if (Cache::has($key)) {
            Cache::forget($key);
        }
        // cuando tiene paginacion
        for ($i = 1; $i <= 5000; $i++) {
            $newKey = $key . $i;
            if (Cache::has($newKey)) {
                Cache::forget($newKey);
            }
            else {
                break;
            }
        }
    }
}
