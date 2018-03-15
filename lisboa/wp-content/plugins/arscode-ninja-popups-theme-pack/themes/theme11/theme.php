<?php

$SNP_THEMES_theme11_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_theme11_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['theme11']		 = array(
    'NAME'	 => 'Theme 11 [Themes Pack]',
    'STYLES' => 'css/theme11.css',
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
	    'desc'	 => __('px (default: 530)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '530'
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
	    'desc'	 => __('(default: #f7f7f5)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
	    'std'		 => '#f7f7f5',
	     
	),
	array(
	    'id'	 => 'img',
	    'type'	 => 'upload',
	    'title'	 => __('Image', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 55px, #391c04)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme11_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '55', 'color'	 => '#391c04'),
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
	    'desc'	 => __('px (default: 15px, #391c04)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme11_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '15', 'color'	 => '#391c04'),
	),
	array(
	    'id'	 => 'email_placeholder',
	    'type'	 => 'text',
	    'std'	 => 'enter your e-mail...',
	    'title'	 => __('E-mail Placeholder', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_color',
	    'type'	 => 'color',
	    'std'	 => '#79bb49',
	    'desc'	 => __('(default: #79bb49)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'security_note',
	    'type'	 => 'text',
	    'title'	 => __('Security Note', 'nhp-opts'),
	),
    )
);
?>