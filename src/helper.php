<?php

if ( ! function_exists('cache') )
{
    function cache($key, Closure $closure)
    {
        $content = Cache::get($key);
        if ( ! $content ) {
            ob_start();
            
            $closure();
            $content = ob_get_contents();
            ob_end_clean();
            Cache::forever($key, $content);
            Log::debug('writing cache', [$key]);
        } else {
            Log::debug('reading cache', [$key]);
        }

        return $content;
    }
}
