<?php

/*
  Plugin Name: Ninja Popups Themes Pack
  Plugin URI: http://codecanyon.net/item/ninja-popups-for-wordpress/3476479?ref=arscode
  Description:
  Version: 1.4
  Author: ArsCode
  Author URI: http://www.arscode.pro/
  License:
 */


add_filter('snp_themes_dir_2', 'snp_themes_dir_2_f', 10, 3);

function snp_themes_dir_2_f($val)
{
    return plugin_dir_path(__FILE__) . '/themes/';
}

function snp_theme_pack_1()
{
    if (file_exists(plugin_dir_path(__FILE__) . '/../arscode-ninja-popups/arscode-ninja-popups.php'))
    {
	$np_data = get_plugin_data(plugin_dir_path(__FILE__) . '/../arscode-ninja-popups/arscode-ninja-popups.php');
	if (version_compare($np_data['Version'], '3.0', '>='))
	{
	    return;
	}
    }
    echo "<div style=\"padding: 20px; background-color: #ef9999; margin: 40px; border: 1px solid #cc0000; \"><b>Requirement: you need to have version 3.0+ of Ninja Popup for Wordpress to run Theme Pack.</b></div>";
}

add_action('admin_notices', 'snp_theme_pack_1');
?>