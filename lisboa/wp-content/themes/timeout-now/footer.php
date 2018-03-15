<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package timeout
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">

			<?php if(ICL_LANGUAGE_CODE=='en') : ?>
			
			<div class="col col--two footer-1">

				<section class="col col--two col--two--mobile col--padding-left-big">
					<h1 class="home-module__title">site</h1>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container' => 'div', 'container_class' => 'menu-lang' ) ); ?>
				</section>
				<section class="col col--two col--two--mobile col--padding-left-big">
					<h1 class="home-module__title">contacts</h1>
					<a class="address-link" target="_blank" href="https://www.google.pt/maps/place/Time+Out+Mercado+da+Ribeira/@38.7067345,-9.1481336,17z/data=!3m1!4b1!4m5!3m4!1s0xd193487595e6075:0x138fe14e4972dc92!8m2!3d38.7067345!4d-9.1459449"><h2 class="site-footer__subtitle">Address</h2>
					<address class="site-footer__copy">Mercado da Ribeira <br>Avenida 24 de Julho<br>1200-479 Portugal</address></a>
					<h2 class="site-footer__subtitle">Opening hours</h2>
					<p class="site-footer__copy">Sunday to Wednesday – 10.00-00.00</p>
					<p class="site-footer__copy">Thursday to Saturdays – 10.00-02.00</p>
					<h2 class="site-footer__subtitle">Telephone</h2>
					<p class="site-footer__copy"><a href="tel:+351213951274">+351 213 951 274</a></p>
					<h2 class="site-footer__subtitle">E-Mail</h2>
					<p class="site-footer__copy"><a href="mailto:info@timeoutmarket.com">infolisboa@timeoutmarket.com</a></p>
						<h2 class="site-footer__subtitle">Social Network</h2>
					<ul class="site-footer__social-list">
						<li class="site-footer__social-list-item">
							<a class="site-footer__social-list-link" href="https://www.facebook.com/TimeOutMarketLisboa/" target="_blank">
								<div class="icon icon-facebook"></div>
							</a>
						</li>
						<li class="site-footer__social-list-item">
							<a class="site-footer__social-list-link" href="https://www.instagram.com/timeoutmarketlisboa/" target="_blank">
								<div class="icon icon-instagram"></div>
							</a>
						</li>
						<li class="site-footer__social-list-item">
							<a class="site-footer__social-list-link" href="https://www.youtube.com/user/timeoutlondonvideo" target="_blank">
								<div class="icon icon-youtube"></div>
							</a>
						</li>
					</ul>
	
				</section>

			
			</div>

			<div class="col col--two footer-2 -txt-center">
		
				<a href="http://www.timeout.com/" target="_blank"><img class="site-footer__logo" src="<?php echo get_template_directory_uri(); ?>/img/timeout-market-lisbon.png" alt="Timeout Market Lisbon"></a>
				<p class="site-footer__copyright">All rights reserved 2016©</p>
		

			</div>
			</div>
			<div class="subheader">
				<ul style="margin:0 auto;padding:0">
					<li style="font-size:9px;">Copyright © 2016 Time Out Market Limited. All rights reserved. <br /> Time Out Market Limited is a company registered in England and Wales, with company number 10359194 and whose registered office is at 4th Floor, 125 Shaftesbury Avenue, London, WC2H 8ADI.  <br /> Time Out Market Limited is a subsidiary of Time Out Group PLC.</li>
					
				</ul>
				<ul style="margin:0 auto;margin-top:10px;padding:0">
					<li style="font-size:9px;"><a style="color:white" href="http://www.timeoutmarket.com/en/privacy-policy/">Privacy Policy</a></li> | 
					<li style="font-size:9px;"><a style="color:white" href="http://www.timeoutmarket.com/en/terms-and-conditions/"> Terms and Conditions</a></li>

					
				</ul>
			</div> 
			<!--
  Ghostery Inc tag
  cid: 2211
  pid: 14599
-->
<!--<a id="_bapw-link" href="#" target="_blank" style="color:#ffffff !important;font:10pt Arial !important;text-decoration:none !important"><span style="vertical-align:middle !important">Cookies</span></a>-->
<script type="text/javascript">
  (function() {
    var ev = document.createElement('script'); ev.type = 'text/javascript'; ev.async = true; ev.setAttribute('data-ev-tag-pid', 14599); ev.setAttribute('data-ev-tag-ocid', 2211); 
    ev.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'c.betrad.com/pub/tag.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ev, s);
  })();
</script>
<script type="text/javascript">
  (function() {
    var hn = document.createElement('script'); hn.type = 'text/javascript'; hn.async = true; hn.setAttribute('data-ev-hover-pid', 14599); hn.setAttribute('data-ev-hover-ocid', 2211);
    hn.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'c.betrad.com/geo/h1.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(hn, s);
  })();
</script>

			<?php else: ?>

			<div class="col col--two footer-1">

				<section class="col col--two col--two--mobile col--padding-left-big">
					<h1 class="home-module__title">site</h1>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container' => 'div', 'container_class' => 'menu-lang' ) ); ?>
				</section>
				<section class="col col--two col--two--mobile col--padding-left-big">
					<h1 class="home-module__title">contactos</h1>
					<a class="address-link" href="https://www.google.pt/maps/place/Time+Out+Mercado+da+Ribeira/@38.7067345,-9.1481336,17z/data=!3m1!4b1!4m5!3m4!1s0xd193487595e6075:0x138fe14e4972dc92!8m2!3d38.7067345!4d-9.1459449"><h2 class="site-footer__subtitle">Morada</h2>
					<address class="site-footer__copy">Mercado da Ribeira <br>Avenida 24 de Julho<br>1200-479 Portugal</address></a>
					<h2 class="site-footer__subtitle">Hórario</h2>
					<p class="site-footer__copy">Domingo a Quarta – 10.00-00.00</p>
					<p class="site-footer__copy">Quinta a Sábado – 10.00-02.00</p>
					<h2 class="site-footer__subtitle">Telefone</h2>
					<p class="site-footer__copy"><a href="tel:+351213951274">+351 213 951 274</a></p>
					<h2 class="site-footer__subtitle">E-Mail</h2>
					<p class="site-footer__copy"><a href="mailto:info@timeoutmarket.com">infolisboa@timeoutmarket.com</a></p>
						<h2 class="site-footer__subtitle">Redes Sociais</h2>
					<ul class="site-footer__social-list">
						<li class="site-footer__social-list-item">
							<a class="site-footer__social-list-link" href="https://www.facebook.com/TimeOutMarketLisboa/" target="_blank">
								<div class="icon icon-facebook"></div>
							</a>
						</li>
						<li class="site-footer__social-list-item">
							<a class="site-footer__social-list-link" href="https://www.instagram.com/timeoutmarketlisboa/" target="_blank">
								<div class="icon icon-instagram"></div>
							</a>
						</li>
						<li class="site-footer__social-list-item">
							<a class="site-footer__social-list-link" href="https://www.youtube.com/user/timeoutlondonvideo" target="_blank">
								<div class="icon icon-youtube"></div>
							</a>
						</li>
					</ul>
	
				</section>

			
			</div>

			<div class="col col--two footer-2 -txt-center">
		
				<a href="http://www.timeout.com/" target="_blank"><img class="site-footer__logo" src="<?php echo get_template_directory_uri(); ?>/img/timeout-market-lisbon.png" alt="Timeout Market Lisbon"></a>
				<p class="site-footer__copyright">Todos os direitos reservados 2016©</p>
		

			</div>
			</div>
			<div class="subheader">
				<ul style="margin:0 auto;padding:0">
					<li style="font-size:9px;">Copyright © 2016 Time Out Market Limited. All rights reserved. <br /> Time Out Market Limited is a company registered in England and Wales, with company number 10359194 and whose registered office is at 4th Floor, 125 Shaftesbury Avenue, London, WC2H 8ADI.  <br /> Time Out Market Limited is a subsidiary of Time Out Group PLC.</li>
					
				</ul>
				<ul style="margin:0 auto;margin-top:10px;padding:0">
					<li style="font-size:9px;"><a style="color:white" href="http://www.timeoutmarket.com/politica-de-privacidade/">Política de Privacidade</a></li> | 
					<li style="font-size:9px;"><a style="color:white" href="http://www.timeoutmarket.com/termos-e-condicoes/"> Termos e Condições</a></li>

					
				</ul>
			</div> 
<!--
  Ghostery Inc tag
  cid: 2211
  pid: 14597
-->
<!--<a id="_bapw-link" href="#" target="_blank" style="color:#ffffff !important;font:10pt Arial !important;text-decoration:none !important"><span style="vertical-align:middle !important">Cookies</span></a>-->
<script type="text/javascript">
  (function() {
    var ev = document.createElement('script'); ev.type = 'text/javascript'; ev.async = true; ev.setAttribute('data-ev-tag-pid', 14597); ev.setAttribute('data-ev-tag-ocid', 2211); 
    ev.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'c.betrad.com/pub/tag.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ev, s);
  })();
</script>
<script type="text/javascript">
  (function() {
    var hn = document.createElement('script'); hn.type = 'text/javascript'; hn.async = true; hn.setAttribute('data-ev-hover-pid', 14597); hn.setAttribute('data-ev-hover-ocid', 2211);
    hn.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'c.betrad.com/geo/h1.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(hn, s);
  })();
</script>
			<?php endif; ?>
			
			<div class="sampleClass"></div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<?php if( is_page(85) || is_page(266)) {
?>

<script type="text/javascript" charset="utf-8">

(function($) {
    $('.flexslider').flexslider({
    animation: "slide",
    animationLoop: false,
    slideshow: false, 
    itemWidth: 320,
    minItems: 2,
    maxItems: 6,
    useCSS: true,
    touch: true, 
    directionNav: true
  });
})( jQuery );
</script>

<?php
} else {
}
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlL8I9cWNNAX5S6d2o-EabligOrqAGI1s"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81455381-1', 'auto');
  ga('send', 'pageview');

</script>

<script src="https://cdn.jsdelivr.net/modernizr/2.8.3/modernizr.min.js"></script>
<script>


    $('map').imageMapResize();


// Execute this if IE is detected.
function msieversion() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if ( ! Modernizr.objectfit ) {
            $('.search-img-container').each(function () {
                var $container = $(this),
                    imgUrl = $container.find('img').prop('src');
                if (imgUrl) {
                    $container
                        .css('backgroundImage', 'url(' + imgUrl + ')')
                        .addClass('compat-object-fit');
                }
            });
        }
    }
    return false;
} // End
$(document).ready(msieversion);
</script>

</body>
</html>
