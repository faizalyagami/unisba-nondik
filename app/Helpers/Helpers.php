<?php

namespace App\Helpers;

class Helpers 
{
    function randomString() {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 11)), 0, 11);
    }
}