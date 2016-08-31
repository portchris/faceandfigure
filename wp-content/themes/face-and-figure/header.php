<?php
/**
 * The theme header
 * 
 * @package bootstrap-basic
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title('|', true, 'right'); ?></title>
		<meta name="viewport" content="width=device-width">

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<link rel="icon" type="image/ico" href="/favicon.ico">
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-60344337-1', 'auto');
		  ga('send', 'pageview');

		</script>
		<!--wordpress head-->
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<!--[if lt IE 8]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
		<?php $titleID = strtolower(str_replace(" ", "-", get_the_title())); ?>
		<div id="page-<?php echo $titleID; ?>" class="page-container">
			<?php do_action('before'); ?> 
			<header id="site-header" role="banner">
				<div class="container">
					<div class="row">
						<div class="col-xs-6 site-branding">
							<div class="site-title">
								<h1 class="site-title-heading text-left">
									<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
										<img src="<?php echo get_template_directory_uri() ?>/img/beauty-salon-taunton-face-and-figure-logo.png" alt="<?php bloginfo('name'); ?>"/>
										<span><?php bloginfo('name'); ?></span>
									</a>
								</h1>
							</div>
						</div><!--.site-branding-->
						<div class="main-navigation col-xs-6">
							<nav class="navbar" role="navigation">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-primary-collapse">
										<span class="sr-only"><?php _e('Toggle navigation', 'bootstrap-basic'); ?></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								</div>
								
								<div class="collapse navbar-collapse navbar-primary-collapse">
									<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav pull-right', 'walker' => new BootstrapBasicMyWalkerNavMenu())); ?> 
									<?php dynamic_sidebar('navbar-right'); ?> 
								</div><!--.navbar-collapse-->
							</nav>
						</div><!--.main-navigation-->
					</div><!-- .row -->
				</div><!-- .container -->
			</header>
			
			
			<div id="content" class="site-content">