<?php

$SNP_THEMES_theme14_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_theme14_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['theme14']		 = array(
    'NAME'	 => 'Theme 14 [Themes Pack]',
    'STYLES' => 'css/theme14.css',
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
	    'desc'	 => __('px (default: 660)', 'nhp-opts'),
	    'class'	 => 'mini',
	    'std'	 => '660'
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
	    'std'	 => '#0065B3',
	    'desc'	 => __('(default: #0065B3)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 24px, #ffffff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme14_SIZES,
		'disable_fonts'	 => 1,
		'disable_color'	 => 1,
	    ),
	    'std'		 => array('size'	 => '24', 'color'	 => '#ffffff'),
	),
	array(
	    'id'	 => 'subheader',
	    'type'	 => 'text',
	    'title'	 => __('Subheader', 'nhp-opts'),
	),
	array(
	    'id'	 => 'subheader_font',
	    'type'	 => 'typo',
	    'title'	 => __('Subheader Font Size', 'nhp-opts'),
	    'desc'	 => __('px (default: 24px, #FFDE00)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme14_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '24', 'color'	 => '#FFDE00'),
	),
	array(
	    'id'	 => 'maintext',
	    'type'	 => 'textarea',
	    'title'	 => __('Text', 'nhp-opts'),
	),
	array(
	    'id'	 => 'maintext_font',
	    'type'	 => 'typo',
	    'title'	 => __('Text Font Size', 'nhp-opts'),
	    'desc'	 => __('px (default: 15px, #ffffff)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme14_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '15', 'color'	 => '#ffffff'),
	),
	array(
	    'id'	 => 'img',
	    'type'	 => 'upload',
	    'desc'	 => __('', 'nhp-opts'),
	    'title'	 => __('Right Image', 'nhp-opts'),
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
	    'std'	 => 'Your Email...',
	    'title'	 => __('E-mail Placeholder', 'nhp-opts'),
	),
	array(
	    'id'	 => 'cf',
	    'type'	 => 'custom_fields',
	    'std'	 => '',
	    'title'	 => __('Custom Fields', 'nhp-opts'),
	    'desc'	 => __('', 'nhp-opts'),
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
	    'std'	 => '#FFDE00',
	    'desc'	 => __('(default: #FFDE00)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_text_color',
	    'type'	 => 'color',
	    'std'	 => '#337D8F',
	    'desc'	 => __('(default: #337D8F)', 'nhp-opts'),
	    'title'	 => __('Submit Button Text Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'security_note',
	    'type'	 => 'text',
	    'title'	 => __('Security Note', 'nhp-opts'),
	),
    )
);