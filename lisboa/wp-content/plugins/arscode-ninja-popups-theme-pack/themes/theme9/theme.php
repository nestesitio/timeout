<?php

$SNP_THEMES_theme9_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_theme9_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['theme9']		 = array(
    'NAME'	 => 'Theme 9 [Themes Pack]',
    'STYLES' => 'css/theme9.css',
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
	    'desc'	 => __('px (default: 630)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '700'
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
	    'type'	 => 'color_gradient',
	    'std'	 => '#ffffff',
	    //'desc'	 => __('(default: #ffffff)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
	    'std'		 => array('from'	 => '#615c73', 'to'	 => '#211a3b'),
	     
	),
	array(
	    'id'	 => 'logo_img',
	    'type'	 => 'upload',
	    'title'	 => __('Logo', 'nhp-opts'),
	),
	array(
	    'id'	 => 'logo_top',
	    'type'	 => 'text',
	    'title'	 => __('Logo Position Top', 'nhp-opts'),
	    'desc'	 => __('px (default: -15px)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '-15'
	),
	array(
	    'id'	 => 'logo_left',
	    'type'	 => 'text',
	    'title'	 => __('Logo Position Left', 'nhp-opts'),
	    'desc'	 => __('px (default: -60px)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '-60'
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
	    'desc'	 => __('px (default: 37px, #ffffff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme9_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '37', 'color'	 => '#ffffff'),
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
	    'desc'	 => __('px (default: 19px, #afafaf)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme9_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '19', 'color'	 => '#afafaf'),
	),
	array(
	    'id'	 => 'name_placeholder',
	    'type'	 => 'text',
	    'std'	 => 'Your Name...',
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
	    'std'	 => 'Your E-mail...',
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
		'snp-field-name' => plugin_dir_url( __FILE__ ).'css/gfx/input-name.png',
		'snp-field-email' => plugin_dir_url( __FILE__ ).'css/gfx/input-email.png',
		'snp-field-phone' => plugin_dir_url( __FILE__ ).'css/gfx/input-phone.png',
		'snp-field-address' => plugin_dir_url( __FILE__ ).'css/gfx/input-address.png',
		'snp-field-website' => plugin_dir_url( __FILE__ ).'css/gfx/input-website.png',
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
	    'std'	 => '#fecb00',
	    'desc'	 => __('(default: #fecb00)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_text_color',
	    'type'	 => 'color',
	    'std'	 => '#000000',
	    'desc'	 => __('(default: #000000)', 'nhp-opts'),
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