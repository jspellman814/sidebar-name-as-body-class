<?php
/*
Plugin Name: Sidebar Name as Body Class
Description: Adds $name parameter from <a href="https://developer.wordpress.org/reference/functions/get_sidebar/" target="_blank">get_sidebar()</a> as class to body.
Version:     1.0
Author:      TrestleMedia
Author URI: https://trestlemedia.com
*/

if (!defined('ABSPATH')) {
  exit;
} // Exit if accessed directly

add_action('wp_head', 'start_sb_class_output');
add_action('get_sidebar', 'get_sb_name');
add_action('wp_footer', 'sb_classes_to_body');

// hook into wp_head action (where body_class is executed)
function start_sb_class_output() {
// start output buffer
  ob_start();
}

// get $name parameter from get_sidebar
function get_sb_name($name = '') {
  // by default $name will be empty
  // every page with sidebar will be given class = 'sidebar'
  static $class = 'sidebar';
  // append class(es) from additional sidebar(s)
  if (!empty($name)) {
    $class .= " sidebar-{$name}";
  }
  // pass class(es) for addition to body
  sb_classes_to_body($class);
}

function sb_classes_to_body($c = '') {
  // by default $c will be empty and add classes as usual
  static $class = '';
  // if parameter is not empty, assign it to $class
  if (!empty($c)) {
    $class = $c;
  }
  else {
    // replace <body> with updated $class
    echo str_replace('<body class="', '<body class="' . $class . ' ', ob_get_clean());
    ob_start();
  }
}