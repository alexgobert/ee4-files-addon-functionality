<?php

/*
Plugin Name: EE4 Files Addon Functionality Plugin
Plugin URI:  https://github.com/alexgobert/ee4-files-addon-functionality
Description: Functionality plugin to improve the EE4 files addon, last updated in 2017. 
Author:      Alex Gobert, 2024-2025 UNAVSA Information Technology Director
Author URI:  https://alexgobert.github.io/
Version:     1.0
License:     GPL-3.0
License URI: https://opensource.org/license/gpl-3-0
*/

// rename files to reduce filename collisions
add_filter('ssa_override_filename', 'normalize_filename');

function normalize_filename(string $filename) {
    $current_date = date('Ymd-his'); // date as 20250101-130559 for January 1st, 2025 at 1:05:59 PM

    return $filename . '-' . $current_date;
}


// bridge compatibility of the EE4 files addon and humanmade/s3-uploads. See https://unavsait.atlassian.net/browse/UIT-123?atlOrigin=eyJpIjoiYWIyNjhjYzI2MWRhNDZjMDg3ZTlhZTMzYWJlNGY5OWQiLCJwIjoiaiJ9
