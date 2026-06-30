<?php

use App\Models\PengaturanSistem;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null) {
        $setting = PengaturanSistem::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}