<?php

$SNP_THEMES_theme18_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_theme18_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['theme18']		 = array(
    'NAME'	 => 'Theme 18  [Themes Pack]',
    'STYLES' => 'css/theme18.css',
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
	    'desc'	 => __('px (default: 700)', 'nhp-opts'),
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
	    'type'	 => 'color',
	    'std'	 => '#f5f4ed',
	    'desc'	 => __('(default: #f5f4ed)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'border_color',
	    'type'	 => 'color',
	    'std'	 => '#4dc0ae',
	    'desc'	 => __('(default: #4dc0ae)', 'nhp-opts'),
	    'title'	 => __('Border Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'topheader',
	    'type'	 => 'text',
	    'std'	 => 'NEWSLETTER',
	    'title'	 => __('Top Header', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 24px, #4dc0ae)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme18_SIZES,
		'disable_fonts'	 => 1,
		'disable_color'	 => 1,
	    ),
	    'std'		 => array('size'	 => '24', 'color'	 => '#4dc0ae'),
	),
	array(
	    'id'	 => 'img',
	    'type'	 => 'upload',
	    'desc'	 => __('', 'nhp-opts'),
	    'title'	 => __('Header Image', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 16px, #959595)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme18_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '16', 'color'	 => '#959595'),
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
	    'desc'	 => __('px (default: 12px, #959595)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme18_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '12', 'color'	 => '#959595'),
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
	    'std'	 => '#ff8e36',
	    'desc'	 => __('(default: #ff8e36)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_shadow_color',
	    'type'	 => 'color',
	    'std'	 => '#e76400',
	    'desc'	 => __('(default: #e76400)', 'nhp-opts'),
	    'title'	 => __('Submit Button Shadow Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_text_color',
	    'type'	 => 'color',
	    'std'	 => '#ffffff',
	    'desc'	 => __('(default: #ffffff)', 'nhp-opts'),
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