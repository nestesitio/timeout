<div class="snp-fb snp-theme12">
    <?php
    if(!empty($POPUP_META['snp_img']))
    {
	echo '<div class="snp-img"><img src="'.$POPUP_META['snp_img'].'" alt=""/></div>'; 
    }
    ?>
    <div class="snp-right">
	<?php
        if(!empty($POPUP_META['snp_header']) || !empty($POPUP_META['snp_header2']))
	{
	    echo '<div class="snp-headers">';
	    if(!empty($POPUP_META['snp_header']))
	    {
		echo '<div class="snp-header">'.$POPUP_META['snp_header'].'</div>'; 
	    }
	    if(!empty($POPUP_META['snp_header2']))
	    {
		echo '<div class="snp-header2">'.$POPUP_META['snp_header2'].'</div>'; 
	    }
	    echo '</div>';
	}
	echo '<div class="snp-body">';
	if(!empty($POPUP_META['snp_maintext']))
	{
	    echo '<div class="snp-text"><p>'.$POPUP_META['snp_maintext'].'</div>'; 
	}
	?> 
	<div class="snp-form">
	    <form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
		<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
		<fieldset>	    
		    
		    <?php
			if(isset($POPUP_META['snp_cf']))
			{
			    $name_field =  '<div>'.$POPUP_META['snp_name_placeholder'].'</div><input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp-name"  class="snp-field snp-field-name" />';
			    $email_field = '<div>'.$POPUP_META['snp_email_placeholder'].'</div><input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email').'" id="snp_email"  class="snp-field snp-field-email" />';
			    $tpl_field = '<div>%LABEL%</div>%FIELD%';
			     snp_custom_fields(unserialize($POPUP_META['snp_cf']),array(
				 'email_field' => $email_field,
				 'name_field' => $name_field,
				 'tpl_field' => $tpl_field,
				 'snp_name_disable' => $POPUP_META['snp_name_disable']
			     )); 
			}
			else
			{
			    if(!$POPUP_META['snp_name_disable'])
			    {
				echo '<div>'.$POPUP_META['snp_name_placeholder'].'</div>';
				echo '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="snp_name" placeholder="" class="snp-field snp-field-name" />';
			    }
			    ?>
			    <div><?php echo $POPUP_META['snp_email_placeholder'];?></div>
			    <input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="snp_email" placeholder="" class="snp-field snp-field-email" />
			  <?php
			}
			?> 
		    <button type="submit" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-submit"><?php echo $POPUP_META['snp_submit_button'];?></button>
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
	echo '</div>';
	?>
    </div>
    <br style="clear: both;"/>
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
if(isset($POPUP_META['snp_header2_font']))
{
	$POPUP_META['snp_header2_font']=unserialize($POPUP_META['snp_header2_font']);
}
if(isset($POPUP_META['snp_maintext_font']))
{
	$POPUP_META['snp_maintext_font']=unserialize($POPUP_META['snp_maintext_font']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-theme12 { max-width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-theme12 { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme12 .snp-header {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_header2_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme12 .snp-header2 {font-size: '.$POPUP_META['snp_header2_font']['size'].'px; color: '.$POPUP_META['snp_header2_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme12 .snp-text {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme12 { color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
	echo '.snp-pop-'.$ID.' .snp-headers { border-bottom: 1px '.$POPUP_META['snp_maintext_font']['color'].' solid;}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme12 .snp-submit, .snp-pop-'.$ID.' .snp-theme12 .snp-submit:hover { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";	
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme12 .snp-submit { color: '.$POPUP_META['snp_submit_button_text_color'].'; border-bottom: none;}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme12 { background-color: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
}

echo '</style>';
