<?php

/*

Plugin Name: Castlegate IT Yoast Heading Generator
Plugin URI: http://github.com/castlegateit/cgit-yoast-headings
Description: Generate overridable H1 headings from Yoast title data.
Version: 2.1
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: AGPLv3

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

require_once __DIR__ . '/classes/autoload.php';
require_once __DIR__ . '/functions.php';

$plugin = new \Cgit\YoastHeading\Plugin();

do_action('cgit_yoast_headings_loaded');
