<?php

$SNP_THEMES_theme17_SIZES = array();
for ($i = 10; $i <= 72; $i++)
{
    $SNP_THEMES_theme17_SIZES[$i]	 = $i . 'px';
}
$SNP_THEMES['theme17']		 = array(
    'NAME'	 => 'Theme 17  [Themes Pack]',
    'STYLES' => 'css/theme17.css',
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
	    'id'	 => 'bg_color',
	    'type'	 => 'color',
	    'std'	 => '#ffffff',
	    'desc'	 => __('(default: #ffffff)', 'nhp-opts'),
	    'title'	 => __('Background Color', 'nhp-opts'),
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
	    'desc'	 => __('px (default: 24px, #545454)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme17_SIZES,
		'disable_fonts'	 => 1,
		'disable_color'	 => 1,
	    ),
	    'std'		 => array('size'	 => '24', 'color'	 => '#545454'),
	),
	array(
	    'id'	 => 'subheader',
	    'type'	 => 'textarea',
	    'title'	 => __('Text', 'nhp-opts'),
	),
	array(
	    'id'	 => 'subheader_font',
	    'type'	 => 'typo',
	    'title'	 => __('Text Font Size', 'nhp-opts'),
	    'desc'	 => __('px (default: 14px, #545454)', 'nhp-opts'),
	    'args'	 => array(
		'sizes'		 => $SNP_THEMES_theme17_SIZES,
		'disable_fonts'	 => 1,
	    ),
	    'std'		 => array('size'	 => '14', 'color'	 => '#545454'),
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
	    'std'	 => '#30a6d7',
	    'desc'	 => __('(default: #30a6d7)', 'nhp-opts'),
	    'title'	 => __('Submit Button Color', 'nhp-opts'),
	),
	array(
	    'id'	 => 'submit_button_hover_color',
	    'type'	 => 'color',
	    'std'	 => '#30a6d7',
	    'desc'	 => __('(default: #30a6d7)', 'nhp-opts'),
	    'title'	 => __('Submit Button Hover Color', 'nhp-opts'),
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