<div class="snp-fb snp-theme14">
    <?php
    if ($POPUP_META['snp_show_cb_button'] == 'yes')
	{
		echo '<a class="snp-close snp_nothanks" href="#"></a>';
	}
	?>
	<div class="snp-newsletter-content snp-clearfix">
	    <header>
	<?php
	echo '<h2>'; 
	if(!empty($POPUP_META['snp_header']))
	{
	    echo $POPUP_META['snp_header'];
	}
	if(!empty($POPUP_META['snp_subheader']))
	{
	    echo '<br /><span class="snp-color">'.$POPUP_META['snp_subheader'].'</span>'; 
	}
	echo '</h2>'; 
	?> 
	<?php
	
	if(!empty($POPUP_META['snp_maintext']))
	{
	    echo '<h3>'.$POPUP_META['snp_maintext'].'</h3>'; 
	}
	?> 
	 </header>
	<form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
	    <?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
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
	<?php
	if (!empty($POPUP_META['snp_security_note']))
	{
		echo '<p><small>'.$POPUP_META['snp_security_note'].'</small></p>';
	}
	?>
	 </form>
    </div>
	<?php
    if((snp_get_option('PROMO_ON') && snp_get_option('PROMO_REF')) && SNP_PROMO_LINK!='')
    {
	    $PROMO_LINK=SNP_PROMO_LINK.snp_get_option('PROMO_REF');
	    echo '<div class="snp-powered-b">';
	    echo '<a href="'.$PROMO_LINK.'" target="_blank">Powered by <strong>Ninja Popups</strong></a>';
	    echo '</div>';
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
if(isset($POPUP_META['snp_maintext_font']))
{
	$POPUP_META['snp_maintext_font']=unserialize($POPUP_META['snp_maintext_font']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-theme14 { width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-theme14 { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-newsletter-content header h2 {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_subheader_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-newsletter-content .snp-color {font-size: '.$POPUP_META['snp_subheader_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-newsletter-content .snp-color {color: '.$POPUP_META['snp_subheader_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-newsletter-content h3 {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-newsletter-content h3 {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-newsletter-content p small {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-submit { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme14 .snp-submit { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme14 { background-color: '.$POPUP_META['snp_bg_color1'].';}'."\n";
}
if (!empty($POPUP_META['snp_img']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme14 { background-image: url(\''.$POPUP_META['snp_img'].'\');}'."\n";
}
echo '</style>';