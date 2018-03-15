<div class="snp-fb snp-theme9">
    <div class="snp-header<?php if(empty($POPUP_META['snp_logo_img'])){ echo ' snp-header-nologo';}?>">
	<?php
	if(!empty($POPUP_META['snp_logo_img']))
	{
	    echo '<div class="snp-logo"><img src="'.$POPUP_META['snp_logo_img'].'" alt="" /></div>'; 
	}
	if(!empty($POPUP_META['snp_header']))
	{
	    echo '<div class="snp-text">'.$POPUP_META['snp_header'].'</div>'; 
	}
	?>
    </div>
    <div class="snp-body">
	<?php
	if(!empty($POPUP_META['snp_maintext']))
	{
	    echo '<p>'.$POPUP_META['snp_maintext'].'</p>'; 
	}
	?> 
	<div class="snp-form">
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
    <div class="snp-envelope">
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
if(isset($POPUP_META['snp_bg_color1']))
{
	$POPUP_META['snp_bg_color1']=unserialize($POPUP_META['snp_bg_color1']);
}
echo '<style>';
if (!empty($POPUP_META['snp_width']))
{
	echo '.snp-pop-'.$ID.' .snp-theme9 { max-width: '.$POPUP_META['snp_width'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_height']))
{
	echo '.snp-pop-'.$ID.' .snp-theme9 { min-height: '.$POPUP_META['snp_height'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_header_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme9 .snp-text {font-size: '.$POPUP_META['snp_header_font']['size'].'px; color: '.$POPUP_META['snp_header_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['size']))
{
	echo '.snp-pop-'.$ID.' .snp-theme9 .snp-body p {font-size: '.$POPUP_META['snp_maintext_font']['size'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_maintext_font']['color']))
{
	echo '.snp-pop-'.$ID.' .snp-theme9 .snp-body, .snp-pop-'.$ID.' .snp-theme9 a, .snp-pop-'.$ID.' .snp-theme9 a:hover {color: '.$POPUP_META['snp_maintext_font']['color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_text_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme9 .snp-submit { color: '.$POPUP_META['snp_submit_button_text_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_submit_button_color']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme9 .snp-submit { background-color: '.$POPUP_META['snp_submit_button_color'].';}'."\n";
}
if (!empty($POPUP_META['snp_logo_left']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme9 .snp-logo { margin-left: '.$POPUP_META['snp_logo_left'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_logo_top']))
{
    	echo '.snp-pop-'.$ID.' .snp-theme9 .snp-logo { margin-top: '.$POPUP_META['snp_logo_top'].'px;}'."\n";
}
if (!empty($POPUP_META['snp_bg_color1']))
{
	if(!$POPUP_META['snp_bg_color1']['to'])
	{
		$POPUP_META['snp_bg_color1']['to']=$POPUP_META['snp_bg_color1']['from'];
	}
    	echo '.snp-pop-'.$ID.' .snp-theme9 {    background: '.$POPUP_META['snp_bg_color1']['to'].';
	background-image: -moz-radial-gradient(50% 50%, circle contain, '.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].' 120%);
	background-image: -webkit-radial-gradient(50% 50%, circle contain, '.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].' 120%);
	background-image: -o-radial-gradient(50% 50%, circle contain, '.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].' 120%);
	background-image: -ms-radial-gradient(50% 50%, circle contain, '.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].' 120%);
	background-image: radial-gradient(50% 50%, circle contain, '.$POPUP_META['snp_bg_color1']['from'].', '.$POPUP_META['snp_bg_color1']['to'].' 120%);
	}'."\n";
}
echo '</style>';
