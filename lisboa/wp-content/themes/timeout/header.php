<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package timeout
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">


<?php wp_head(); ?>

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_over.css?counter=<?php echo time(); ?>">


<?php if( is_page(85) || is_page(266)) {
?>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/flexslider.css?counter=<?php echo time(); ?>">

<?php
} else {
}
?>

<?php
  if ( is_post_type_archive('comer-e-beber') ) {
    ?>
  
<script src="<?php echo get_template_directory_uri(); ?>/js/createjs-2015.11.26.min.js"></script>
<?php if(ICL_LANGUAGE_CODE=='en') : ?>
       <script src="<?php echo get_template_directory_uri(); ?>/TimeOut_PlantaAnimate_ENG_xai020.js"></script>
       <script>
var canvas, stage, exportRoot;
function init() {
  canvas = document.getElementById("canvas");
  images = images||{};
  var loader = new createjs.LoadQueue(false);
  loader.addEventListener("fileload", handleFileLoad);
  loader.addEventListener("complete", handleComplete);
  loader.loadManifest(lib.properties.manifest);
}
function handleFileLoad(evt) {  
  if (evt.item.type == "image") { images[evt.item.id] = evt.result; } 
}
function handleComplete(evt) {
  //This function is always called, irrespective of the content. You can use the variable "stage" after it is created in token create_stage.
  var queue = evt.target;
  var ssMetadata = lib.ssMetadata;
  for(i=0; i<ssMetadata.length; i++) {
    ss[ssMetadata[i].name] = new createjs.SpriteSheet( {"images": [queue.getResult(ssMetadata[i].name)], "frames": ssMetadata[i].frames} )
  }
  var preloaderDiv = document.getElementById("_preload_div_");
  preloaderDiv.style.display = 'none';
  canvas.style.display = 'block';
  exportRoot = new lib.TimeOut_PlantaAnimate_ENG();
  stage = new createjs.Stage(canvas);
  stage.addChild(exportRoot);
  stage.enableMouseOver();  
  //Registers the "tick" event listener.
  createjs.Ticker.setFPS(lib.properties.fps);
  createjs.Ticker.addEventListener("tick", stage);      
  //Code to support hidpi screens and responsive scaling.
  (function(isResp, respDim, isScale, scaleType) {    
    var lastW, lastH, lastS=1;    
    window.addEventListener('resize', resizeCanvas);    
    resizeCanvas();   
    function resizeCanvas() {     
      var w = lib.properties.width, h = lib.properties.height;      
      var iw = window.innerWidth, ih=window.innerHeight;      
      var pRatio = window.devicePixelRatio || 1, xRatio=iw/w, yRatio=ih/h, sRatio=1;      
      if(isResp) {                
        if((respDim=='width'&&lastW==iw) || (respDim=='height'&&lastH==ih)) {                    
          sRatio = lastS;                
        }       
        else if(!isScale) {         
          if(iw<w || ih<h)            
            sRatio = Math.min(xRatio, yRatio);        
        }       
        else if(scaleType==1) {         
          sRatio = Math.min(xRatio, yRatio);        
        }       
        else if(scaleType==2) {         
          sRatio = Math.max(xRatio, yRatio);        
        }     
      }     
      canvas.width = w*pRatio*sRatio;     
      canvas.height = h*pRatio*sRatio;
      canvas.style.width = preloaderDiv.style.width = w*sRatio+'px';      
      canvas.style.height = preloaderDiv.style.height = h*sRatio+'px';
      stage.scaleX = pRatio*sRatio;     
      stage.scaleY = pRatio*sRatio;     
      lastW = iw; lastH = ih; lastS = sRatio;   
    }
  })(true,'both',true,1); 
}
</script>
 <?php else: ?>
        <script src="<?php echo get_template_directory_uri(); ?>/TimeOut_PlantaAnimate_xai020.js"></script>
        <script>
var canvas, stage, exportRoot;
function init() {
  canvas = document.getElementById("canvas");
  images = images||{};
  var loader = new createjs.LoadQueue(false);
  loader.addEventListener("fileload", handleFileLoad);
  loader.addEventListener("complete", handleComplete);
  loader.loadManifest(lib.properties.manifest);
}
function handleFileLoad(evt) {  
  if (evt.item.type == "image") { images[evt.item.id] = evt.result; } 
}
function handleComplete(evt) {
  //This function is always called, irrespective of the content. You can use the variable "stage" after it is created in token create_stage.
  var queue = evt.target;
  var ssMetadata = lib.ssMetadata;
  for(i=0; i<ssMetadata.length; i++) {
    ss[ssMetadata[i].name] = new createjs.SpriteSheet( {"images": [queue.getResult(ssMetadata[i].name)], "frames": ssMetadata[i].frames} )
  }
  var preloaderDiv = document.getElementById("_preload_div_");
  preloaderDiv.style.display = 'none';
  canvas.style.display = 'block';
  exportRoot = new lib.TimeOut_PlantaAnimate_xai020();
  stage = new createjs.Stage(canvas);
  stage.addChild(exportRoot);
  stage.enableMouseOver();  
  //Registers the "tick" event listener.
  createjs.Ticker.setFPS(lib.properties.fps);
  createjs.Ticker.addEventListener("tick", stage);      
  //Code to support hidpi screens and responsive scaling.
  (function(isResp, respDim, isScale, scaleType) {    
    var lastW, lastH, lastS=1;    
    window.addEventListener('resize', resizeCanvas);    
    resizeCanvas();   
    function resizeCanvas() {     
      var w = lib.properties.width, h = lib.properties.height;      
      var iw = window.innerWidth, ih=window.innerHeight;      
      var pRatio = window.devicePixelRatio || 1, xRatio=iw/w, yRatio=ih/h, sRatio=1;      
      if(isResp) {                
        if((respDim=='width'&&lastW==iw) || (respDim=='height'&&lastH==ih)) {                    
          sRatio = lastS;                
        }       
        else if(!isScale) {         
          if(iw<w || ih<h)            
            sRatio = Math.min(xRatio, yRatio);        
        }       
        else if(scaleType==1) {         
          sRatio = Math.min(xRatio, yRatio);        
        }       
        else if(scaleType==2) {         
          sRatio = Math.max(xRatio, yRatio);        
        }     
      }     
      canvas.width = w*pRatio*sRatio;     
      canvas.height = h*pRatio*sRatio;
      canvas.style.width = preloaderDiv.style.width = w*sRatio+'px';      
      canvas.style.height = preloaderDiv.style.height = h*sRatio+'px';
      stage.scaleX = pRatio*sRatio;     
      stage.scaleY = pRatio*sRatio;     
      lastW = iw; lastH = ih; lastS = sRatio;   
    }
  })(true,'both',true,1); 
}
</script>
  
<?php endif; ?>



<?php
} else {
  ?>

<?php
}
?>




</head>


<?php
  if ( is_post_type_archive('comer-e-beber') ) {
    ?>

<body onload="init();" <?php body_class(); ?>>


<?php
} else {
  ?>
  <body <?php body_class(); ?>>
<?php
}
?>
 
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'timeout' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="branding">
                                <div class="logos__desktop">
                                    <a title="Time Out Lisboa" href="http://www.timeout.pt" class="timeout-logo">Time Out Market</a>
                                  <div class="city-picker city-picker--desktop" id="city-picker-0">
                                  	<div class="city-picker__container">
                                  		<div class="city-picker__label-container">
                                  			<div class="city-picker__label">
                                  				<span>
                                  					<span>
                                              <?php if(ICL_LANGUAGE_CODE=='en') : ?>
                                              <a href="/en">Time Out Market Lisboa</a>
                                              <?php else: ?>
                                              <a href="/">Time Out Market Lisboa</a>
                                              <?php endif; ?>
                                            </span>
                                  				</span>
                                          <?php do_action('wpml_add_language_selector'); ?>
                                         
                                  			</div>
                                  		</div>
                                  	</div>
                                  </div>
                                </div>
                               
                            </div>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <div class="menu-toggle-btn">
				<img src="<?php echo get_template_directory_uri(); ?>/img/icon-menu.svg">
      </div>
			</div>
			<div class="menu-main-pt-container">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container' => 'div', 'container_class' => 'menu-lang' ) ); ?>
			
		</div>
		</nav><!-- #site-navigation -->
    <div class="search-container">
      <div class="lupa-container">
          <img clasS="lupa" src="<?php echo get_template_directory_uri(); ?>/img/lupa.png" />
      </div>
		<?php get_search_form(); ?>
  </div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
    
