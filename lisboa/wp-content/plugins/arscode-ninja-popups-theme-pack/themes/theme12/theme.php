<?php

$SNP_THEMES_theme12_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_theme12_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['theme12']		 = array(
    'NAME'	 => 'Theme 12 [Themes Pack]',
    'STYLES' => 'css/theme12.css',
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
	    'desc'	 => __('px (default: 800)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '800'
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
	    'desc'	 => __('(default: #F00047)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
	    'std'		 => '#F00047',
	     
	),
	array(
	    'id'	 => 'img',
	    'type'	 => 'upload',
	    'title'	 => __('Image', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header',
	    'type'	 => 'text',
	    'title'	 => __('Header Line 1', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header_font',
	    'type'	 => 'typo',
	    'title'	 => __('Header Font', 'nhp-opts'),
	    'desc'	 => __('px (default: 35px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme12_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '35', 'color'	 => '#fff'),
	),
	array(
	    'id'	 => 'header2',
	    'type'	 => 'text',
	    'title'	 => __('Header Line 2', 'nhp-opts'),
	),
	array(
	    'id'	 => 'header2_font',
	    'type'	 => 'typo',
	    'title'	 => __('Header Font', 'nhp-opts'),
	    'desc'	 => __('px (default: 54px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme12_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '54', 'color'	 => '#fff'),
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
	    'desc'	 => __('px (default: 17px, #fff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme12_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '17', 'color'	 => '#fff'),
	),
	array(
	    'id'	 => 'name_placeholder',
	    'type'	 => 'text',
	    'std'	 => 'Your Name:',
	    'title'	 => __('Name Field Label', 'nhp-opts'),
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
	    'title'	 => __('E-mail Field Label', 'nhp-opts'),
	),
	array(
	    'id'	 => 'cf',
	    'type'	 => 'custom_fields',
	    'std'	 => '',
	    'title'	 => __('Custom Fields', 'nhp-opts'),
	    'desc'	 => __('', 'nhp-opts')
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
	    'std'	 => '#E4BC42',
	    'desc'	 => __('(default: #E4BC42)', 'nhp-opts'),
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