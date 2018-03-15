<?php

$SNP_THEMES_theme13_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_theme13_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['theme13']		 = array(
    'NAME'	 => 'Theme 13 [Themes Pack]',
    'STYLES' => 'theme13.css',
    'TYPES'	 => array(
	'optin' => array('NAME'	 => 'Opt-in')
    ),
    'COLORS' => array(
	'multicolors' => array('NAME'	 => 'Multicolors')
    ),
    'FIELDS' => array(
	array(
	    'id'	 => 'width',
	    'type'	 => 'text',
	    'title'	 => __('Width', 'nhp-opts'),
	    'desc'	 => __('px (default: 600)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '600'
	),
	array(
	    'id'	 => 'height',
	    'type'	 => 'text',
	    'title'	 => __('Height', 'nhp-opts'),
	    'desc'	 => __('px (optional, leave empty for auto-height)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => ''
	),
	array(
	    'id'	 => 'bg_color1',
	    'type'	 => 'color',
	    'desc'	 => __('(default: #fff)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
	    'std'		 => '#fff',
	     
	),
	array(
	    'id'	 => 'header',
	    'type'	 => 'text',
	    'title'	 => __('Header', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header_font',
	    'type'	 => 'typo',
	    'title'	 => __('Header Font', 'nhp-opts'),
	    'desc'	 => __('px (default: 35px, #5fb1ea)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme13_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '35', 'color'	 => '#5fb1ea'),
	),
	array(
	    'id'	 => 'maintext',
	    'type'	 => 'textarea',
	    'title'	 => __('Main Text', 'nhp-opts'),
	),
	array(
	    'id'	 => 'maintext_font',
	    'type'	 => 'typo',
	    'title'	 => __('Main Text Font Size', 'nhp-opts'),
	    'desc'	 => __('px (default: 15px, #c6c3c3)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme13_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '15', 'color'	 => '#c6c3c3'),
	),
	array(
	    'id'	 => 'name_placeholder',
	    'type'	 => 'text',
	    'std'	 => 'Your Name:',
	    'title'	 => __('Name Placeholder', 'nhp-opts'),
	),
	array(
	    'id'		 => 'name_disable',
	    'type'		 => 'radio',
	    'title'		 => __('Disable Name Field', 'nhp-opts'),
	    'options'	 => array(0	 => 'No', 1	 => 'Yes'),
	    'std'	 => 0
	),
	array(
	    'id'	 => 'email_placeholder',
	    'type'	 => 'text',
	    'std'	 => 'Your E-mail:',
	    'title'	 => __('E-mail Placeholder', 'nhp-opts'),
	),
	array(
	    'id'	 => 'cf',
	    'type'	 => 'custom_fields',
	    'std'	 => '',
	    'title'	 => __('Custom Fields', 'nhp-opts'),
	    'desc'	 => __('', 'nhp-opts'),
	    'icons'	 => array(
		// class => img
		'snp-field-name' => plugin_dir_url( __FILE__ ).'gfx/input-name.png',
		'snp-field-email' => plugin_dir_url( __FILE__ ).'gfx/input-email.png',
		'snp-field-phone' => plugin_dir_url( __FILE__ ).'gfx/input-phone.png',
		'snp-field-address' => plugin_dir_url( __FILE__ ).'gfx/input-address.png',
		'snp-field-website' => plugin_dir_url( __FILE__ ).'gfx/input-website.png',
	    )
	),
	array(
	    'id'	 => 'submit_button',
	    'type'	 => 'text',
	    'std'	 => 'Subscribe Now!',
	    'title'	 => __('Submit Button', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_loading',
	    'type'	 => 'text',
	    'std'	 => '',
	    'title'	 => __('Submit Button Loading Text', 'nhp-opts'),
	    'desc'	 => __('(ex: Please wait...)', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_success',
	    'type'	 => 'text',
	    'std'	 => '',
	    'title'	 => __('Submit Button Success Text', 'nhp-opts'),
	    'desc'	 => __('(ex: Thank You!)', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_color',
	    'type'	 => 'color',
	    'std'	 => '#5fb1ea',
	    'desc'	 => __('(default: #5fb1ea)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_text_color',
	    'type'	 => 'color',
	    'std'	 => '#fff',
	    'desc'	 => __('(default: #fff)', 'nhp-opts'),
	    'title'	 => __('Submit Button Text Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'security_note',
	    'type'	 => 'text',
	    'title'	 => __('Security Note', 'nhp-opts'),
	),
    )
);
?>