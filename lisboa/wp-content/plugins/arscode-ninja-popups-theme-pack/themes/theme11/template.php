<div class="snp-fb snp-theme11">
    <div class="snp-body">
	<?php
	if(!empty($POPUP_META['snp_header']))
	{
	    echo '<div class="snp-header">'.$POPUP_META['snp_header'].'</div>'; 
	}
	if(!empty($POPUP_META['snp_img']))
	{
	    echo '<div class="snp-img"><img src="'.$POPUP_META['snp_img'].'" alt=""/></div>'; 
	}
	if(!empty($POPUP_META['snp_maintext']))
	{
	    echo '<div class="snp-text"><p>'.$POPUP_META['snp_maintext'].'</div>'; 
	}
	?> 
	<div class="snp-form">
	    <form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
		<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
		<fieldset>
		    <div class="snp-field">
			<input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field snp-field-email" />
		    </div>
		    <button type="submit" class="snp-submit">Submit</button>
		</fieldset>
	    </form>
	</div>
	<?php
	if (!empty($POPUP_META['snp_security_note']))
	{
		echo '<div class="snp-privacy">'.$POPUP_META['snp_security_note'].'</div>';
	}
	?>
	<?php
	if ($POPUP_META['snp_show_cb_button'] == 'yes')
	{  
	 echo '<a href="#" class="snp-close snp_nothanks">x</a>';
	}
	?>
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
if(isset($POPUP_META['snp_maintext_font']))
{
	$POPUP_META['snp_maintext_font']=unserialize($POPUP_META['snp_maintext_font']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-theme11 { max-width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-theme11 { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme11 .snp-header {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme11 .snp-text {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme11 .snp-text {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme11 .snp-submit { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
    	echo '.snp-pop-'.$ID.' .snp-theme11 .snp-header span { color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme11 { background-color: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
}

echo '</style>';
