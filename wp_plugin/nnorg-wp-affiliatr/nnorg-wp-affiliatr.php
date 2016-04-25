<?php
    /*
    Plugin Name: N.K.org WP Affiliat*r Integration
    Plugin URI: http://nobody-knows.org/download/affiliatr/
    Description: Plugin for easy integration of the Affiliat*r System into Wordpress-based pages
    Version: 1.2.128
    Author: Stefan Seehafer aka imagine
    Author URI: http://nobody-knows.org/download/affiliatr/
    Update Server: http://nobody-knows.org/updatepools/affiliatr/packages/wp/
    License: GPLv3
    */

    require_once __DIR__.'/nnorg-wp-affiliatr-functions.php';

    if(!load_plugin_textdomain('nnorg-wp-affiliatr', false, dirname(plugin_basename(__FILE__)) . '/lang/')){
        nnorg_afltr_common::show_message('Unable to load language files!', true);
    }    
    
    define('NNORG_AFLTR_SETTINGS_CFG', dirname(__FILE__).'/settings.cfg');

    register_activation_hook(__FILE__, array('nnorg_afltr_common', 'install'));
    register_deactivation_hook(__FILE__, array('nnorg_afltr_common', 'uninstall'));
    
    add_action('admin_menu', array('nnorg_afltr_common', 'register_menu'));
    add_action('admin_notices', array('nnorg_afltr_common', 'show_message'));    
    
    add_shortcode('affiliatr', array('nnorg_afltr_common', 'page'));