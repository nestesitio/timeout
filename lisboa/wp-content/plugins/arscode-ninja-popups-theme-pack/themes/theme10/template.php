<div class="snp-fb snp-theme10">
    <div class="snp-body">
	<?php
	if(!empty($POPUP_META['snp_header']))
	{
	    echo '<div class="snp-text">'.$POPUP_META['snp_header'].'</div>'; 
	}
	if(!empty($POPUP_META['snp_img']))
	{
	    echo '<div class="snp-right"><img src="'.$POPUP_META['snp_img'].'" alt=""/></div>'; 
	}
	echo '<div class="snp-left">';
	if(!empty($POPUP_META['snp_maintext']))
	{
	    echo '<p>'.$POPUP_META['snp_maintext'].'</p>'; 
	}
	if(!empty($POPUP_META['snp_bulletlist']))
	{
		$POPUP_META['snp_bulletlist']=unserialize($POPUP_META['snp_bulletlist']);
		foreach($POPUP_META['snp_bulletlist'] as $k => $v)
		{
			if(!trim($v))
			{
				unset($POPUP_META['snp_bulletlist'][$k]);
			}
		}
		if(count($POPUP_META['snp_bulletlist'])>0)
		{
			echo '<ul class="snp-features">';
			foreach((array)$POPUP_META['snp_bulletlist'] as $v)
			{
				echo '<li><span></span>'.$v.'</li>';
			}
			echo '</ul>';  
		}
	}
	echo '</div>';
	echo '<br style="clear: both;" />';
	?> 
	<div class="snp-form">
	    <?php
	    if(!empty($POPUP_META['snp_header2']))
	    {
		echo '<div class="snp-text2">'.$POPUP_META['snp_header2'].'</div>'; 
	    }
	    ?>
	    <form action="<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_url');}else{echo '#';}?>" method="post" class="snp-subscribeform snp_subscribeform"<?php if(snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_blank')){echo ' target="_blank"';}?>>
		<?php if(snp_get_option('ml_manager') == 'html'){echo snp_get_option('ml_html_hidden');}?>
		<fieldset>
		    <div class="snp-fieldset">
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
			else
			{
			  if(!$POPUP_META['snp_name_disable'])
			  {
				echo '<input type="text" name="'.((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_name')) ? snp_get_option('ml_html_name') : 'name').'" id="name" placeholder="'.$POPUP_META['snp_name_placeholder'].'" class="snp-field snp-field-name" />';
			  }
			  ?>
			  <input type="text" name="<?php echo ((snp_get_option('ml_manager') == 'html' && snp_get_option('ml_html_email')) ? snp_get_option('ml_html_email') : 'email');?>" id="email" placeholder="<?php echo $POPUP_META['snp_email_placeholder'];?>" class="snp-field snp-field-email" />						  
			  <?php
			}
			?> 
			<button type="submit" data-loading="<?php echo $POPUP_META['snp_submit_button_loading'];?>" data-success="<?php echo $POPUP_META['snp_submit_button_success'];?>" class="snp-submit"><?php echo $POPUP_META['snp_submit_button'];?></button>
		    </div>
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
	    echo '<div class="snp-close"><a href="#" class="snp_nothanks">'.$POPUP_META['snp_cb_text'].'</a></div>';
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
	echo '.snp-pop-'.$ID.' .snp-theme10 { max-width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-theme10 { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme10 .snp-text {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_header2_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme10 .snp-text2 {font-size: '.$POPUP_META['snp_header2_font']['size'].'px; color: '.$POPUP_META['snp_header2_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme10 .snp-body p, .snp-pop-'.$ID.' .snp-theme10 .snp-features {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme10 .snp-body {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme10 .snp-submit { color: '.$POPUP_META['snp_submit_button_text_color'].'; border-bottom: none;}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme10 .snp-submit { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme10 { background: '.$POPUP_META['snp_bg_color1'].'; }'."\n";
}
if (!empty($POPUP_META['snp_left_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme10 { border-left-color: '.$POPUP_META['snp_left_color'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme10 .snp-features li span { background-color: '.$POPUP_META['snp_left_color'].'; }'."\n";
	echo '.snp-pop-'.$ID.' .snp-theme10:after { border-left: 18px solid '.$POPUP_META['snp_left_color'].'; }'."\n";
}
echo '</style>';
