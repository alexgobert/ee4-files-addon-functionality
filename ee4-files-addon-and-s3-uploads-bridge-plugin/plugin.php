<?php

/*
Plugin Name: EE4 Files Addon Functionality Plugin
Plugin URI:  https://github.com/alexgobert/ee4-files-addon-functionality
Description: Functionality plugin to improve the EE4 files addon, last updated in 2017. 
Author:      Alex Gobert, 2024-2025 UNAVSA Information Technology Director and 2023-2025 UVSA South Secretary
Author URI:  https://alexgobert.github.io/
Version:     1.2
License:     GPL-3.0
License URI: https://opensource.org/license/gpl-3-0
*/

// rename files to reduce filename collisions
add_filter('ssa_override_filename', 'normalize_filename');

function normalize_filename(string $filename) {
    $current_date = new DateTime('now', new DateTimeZone(wp_timezone_string()));
    $current_date_str = $current_date->format('Ymd-his'); // date as 20250101-130559 for January 1st, 2025 at 1:05:59 PM

    $offset = $current_date->format('O');
    $offset = str_replace('+', 'p', str_replace('-', 'm', $offset));

    $parsed = parse_url($filename);
    $parsed['path'] = pathinfo($parsed['path'], PATHINFO_FILENAME) . '-' . $current_date_str . $offset . '.' . pathinfo($parsed['path'], PATHINFO_EXTENSION);

    return unparse_url($parsed);
}

// from https://www.php.net/manual/en/function.parse-url.php#106731
function unparse_url($parsed_url) {
    $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
    $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
    $pass     = ($user || $pass) ? "$pass@" : '';
    $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

    return "$scheme$user$pass$host$port$path$query$fragment";
  }
