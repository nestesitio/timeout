<div class="snp-fb snp-theme16">
    <header>
	<?php
	if(!empty($POPUP_META['snp_header']))
	{
	    echo '<h2>'.$POPUP_META['snp_header'].'</h2>'; 
	}
	if(!empty($POPUP_META['snp_subheader']))
	{
	    echo '<h3>'.$POPUP_META['snp_subheader'].'</h3>'; 
	}
	?> 
    </header>
    <?php
    if ($POPUP_META['snp_show_cb_button'] == 'yes')
    {
	echo '<a class="snp-close snp_nothanks" href="#"></a>';
    }
    ?>
    <div class="snp-newsletter-content">
	<form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
	<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
	    <div>
		<?php
		if(isset($POPUP_META['snp_cf']))
		{
		    $name_field =  '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp-name" placeholder="'.$POPUP_META['snp_name_placeholder'].'" class="snp-field snp-field-name" />';
		    $email_field = '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email').'" id="snp_email" placeholder="'.$POPUP_META['snp_email_placeholder'].'"  class="snp-field snp-field-email" />';
		    $tpl_field = '%FIELD%';
		     snp_custom_fields(unserialize($POPUP_META['snp_cf']),array(
			 'email_field' => $email_field,
			 'name_field' => $name_field,
			 'tpl_field' => $tpl_field,
			 'snp_name_disable' => $POPUP_META['snp_name_disable']
		     )); 
		}
		?>
		<input type="submit" class="snp-subscribe-button snp-submit" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" value="<?php echo $POPUP_META['snp_submit_button'];?>">
	    </div>
	</form>	
    </div>
    <?php
    if (!empty($POPUP_META['snp_security_note']))
    {
	    echo '<footer><small>'.$POPUP_META['snp_security_note'].'</small></footer>';
    }
    ?>
</div>
<?php
if(isset($POPUP_META['snp_header_font']))
{
	$POPUP_META['snp_header_font']=unserialize($POPUP_META['snp_header_font']);
}
if(isset($POPUP_META['snp_subheader_font']))
{
	$POPUP_META['snp_subheader_font']=unserialize($POPUP_META['snp_subheader_font']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-theme16 { width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-theme16 { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme16 h2 {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_subheader_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme16 h3 {font-size: '.$POPUP_META['snp_subheader_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme16 h3, .snp-pop-'.$ID.' .snp-theme16 footer {color: '.$POPUP_META['snp_subheader_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme16 .snp-submit { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme16 .snp-submit { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme16 form input[type="text"],.snp-pop-'.$ID.' .snp-theme16 form select,.snp-pop-'.$ID.' .snp-theme16 form textarea,.snp-pop-'.$ID.' .snp-theme16 form input[type="text"]:focus,.snp-pop-'.$ID.' .snp-theme16 form select:focus,.snp-pop-'.$ID.' .snp-theme16 form textarea:focus {border: 1px solid '.$POPUP_META['snp_submit_button_color'].';}';
}
if (!empty($POPUP_META['snp_submit_button_hover_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme16 form input[type="submit"]:hover { background-color: '.$POPUP_META['snp_submit_button_hover_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme16 { background: '.$POPUP_META['snp_bg_color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme16:before {  border-top: 50px solid '.$POPUP_META['snp_bg_color'].'; border-left: 50px solid '.$POPUP_META['snp_bg_color'].'; }'."\n";
}
if (!empty($POPUP_META['snp_border_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme16:after  { border-top: 70px solid '.$POPUP_META['snp_border_color'].'; border-left: 70px solid '.$POPUP_META['snp_border_color'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme16 { border-color: '.$POPUP_META['snp_border_color'].'; }'."\n";
}
if (!empty($POPUP_META['snp_input_bg']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme16 form input[type="text"],.snp-pop-'.$ID.' .snp-theme16 form select,.snp-pop-'.$ID.' .snp-theme16 form textarea, .snp-pop-'.$ID.' .snp-theme16 form input[type="text"]:focus, .snp-pop-'.$ID.'.snp-theme16 form select:focus, .snp-pop-'.$ID.'.snp-theme16 form textarea:focus { background-color: '.$POPUP_META['snp_input_bg'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme16 form input[type="text"],.snp-pop-'.$ID.' .snp-theme16 form select,.snp-pop-'.$ID.' .snp-theme16 form textarea, .snp-pop-'.$ID.' .snp-theme16 form input[type="text"]:focus, .snp-pop-'.$ID.'.snp-theme16 form select:focus, .snp-pop-'.$ID.'.snp-theme16 form textarea:focus { color: '.$POPUP_META['snp_input_text'].'; }'."\n";

}
echo '</style>';