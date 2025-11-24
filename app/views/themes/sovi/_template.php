<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$this->meta_title;?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="description" content="<?=$this->meta_description;?>"/>
		<meta name="keywords" content="<?=$this->meta_keywords;?>"/>
		<meta name="author" content="<?=get_setting('web_author');?>"/>
		<meta http-equiv="Copyright" content="<?=get_setting('web_name');?>"/>
		<meta http-equiv="imagetoolbar" content="no"/>
		<meta name="language" content="english"/>
		<meta name="revisit-after" content="7"/>
		<meta name="webcrawlers" content="all"/>
		<meta name="rating" content="general"/>
		<meta name="spiders" content="all"/>
		<link rel="canonical" href="<?=site_url(uri_string());?>"/>
		<meta name="csrf_token_name" content="<?= $this->security->get_csrf_token_name(); ?>">
		<meta name="csrf_token_value" content="<?= $this->security->get_csrf_hash(); ?>">
		<!-- favicon -->
		<link rel="shortcut icon" href="<?=favicon();?>"/>
		
		<!-- metasocial -->
		<?php $this->load->view('meta_social'); ?>
		
		<!-- stylesheet -->
		<link rel="stylesheet" href="<?=site_url('plugins/bootstrap/css/bootstrap.min.css');?>"/>
		<link rel="stylesheet" href="<?=site_url('plugins/prism/prism.css');?>"/>
		<link rel="stylesheet" href="<?=site_url('plugins/font-awesome/font-awesome.min.css');?>" type="text/css"/>
		<link rel="stylesheet" href="<?=site_url('plugins/cifireicon-feather/cifireicon-feather.min.css');?>" type="text/css"/>
		<link rel="stylesheet" href="<?=site_url('plugins/photoswipe/photoswipe.css');?>">
		<link rel="stylesheet" href="<?=site_url('plugins/photoswipe/default-skin/default-skin.css');?>"> 
		<link rel="stylesheet" href="<?=$this->CI->theme_asset('css/style.css');?>?v=4" />
		<link rel="stylesheet" href="<?=$this->CI->theme_asset('css/style_pod.css');?>" />
		<link rel="stylesheet" href="<?=$this->CI->theme_asset('css/share.css');?>" />
		<link rel="stylesheet" href="<?=$this->CI->theme_asset('css/elegant-icons.css');?>" />
		
		<!-- script -->
		<script src="<?=site_url('plugins/jquery/jquery3.4.1.min.js');?>"></script>
		<style>
			/* Dropdown submenu */
			.dropdown-menu {
			position: absolute;
			top: 100%;
			left: 10;
			z-index: 1000;
			display: none;
			margin-top: 0.1rem;
			}
			
			/* Show dropdown on hover */
			.nav-item.dropdown:hover > .dropdown-menu {
			display: block;
			}
			
			/* Submenu (level 2 and beyond) */
			.dropdown-submenu {
			position: relative;
			top: 10;
			}
			
			.dropdown-submenu > .dropdown-menu {
			top: 10;
			left: 100%;
			margin-top: 0;
			}
			
			/* Optional: Add arrow indicator */
			.dropdown-submenu > a:after {
			content: "\f105"; /* Font Awesome right arrow */
			float: right;
			border: none!important;
			font-family: FontAwesome;
			margin-left: 5px;
			}
			.top-menu .navbar-nav li ul li ul {
			top: 0px!important;
			
			}
			
			.top-menu{
			z-index: 50!important;
			}
		</style>
		<!-- google analytics -->
		<?=google_analytics();?>
		 
	</head>
	<body>
		<section class="header">
			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							<div class="top-link">
								<ul>
									<li><a href="<?=admin_url()?>"><?=login_status()?'<i class="fa fa-user"></i> &nbsp;'.data_login('name'):"LOGIN";?></a></li>
									<li><a href="<?=site_url('pages/tentang-kami')?>">Tentang Kami</a></li>
									<li><a href="<?=site_url('pages/redaksi')?>">Redaksi</a></li>
									<li><a href="<?=site_url('pages/pedoman-media-siber')?>">Pedoman Media Siber</a></li>
									<li><a href="<?=site_url('pages/download')?>">Download</a></li>
									<li><a href="<?=site_url('pages/kontak')?>">Kontak</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-4 text-right">
							<div class="top-social">
								<!--a href="#"><i class="fa fa-facebook"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-instagram"></i></a-->
								<?=html_entity_decode(get_setting('sosmed'));?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-inner">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="logo">
								<a href="<?=site_url();?>" title="<?=get_setting('web_name');?>">
									<img src="<?=favicon('logo');?>" alt="Logo"/>
								</a>
							</div>
						</div>
						<?php if(get_setting('tampil_iklan')=='Y'):?>
						<div class="top-ads col-md-8 text-right">
							<a href="#">
								<img src="<?=post_images('add728x90.jpg');?>" alt="ADS" style="max-width:100%;height:auto">
							</a>
						</div>
						 <?php endif; ?>
					</div>
				</div>
			</div>
			<div id="navsticky">
				<!-- form search -->
				<div class="top-search-warper">
					<div class="container">
						<?=form_open(site_url('search'),'class="search-form"');?>
						<input type="text" name="kata" class="input-search" placeholder="Search..."/>
						<?=form_close();?>
					</div>
				</div>
				<!--/ form search -->
				
				<!-- top nav -->
				<nav class="navbar navbar-expand-sm bg-white top-menu">
					<div class="container">
					    
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topMenu" aria-controls="topMenu" aria-label="Toggle navigation">
							<span class="fa fa-navicon"></span>
						</button>
						<!-- Logo khusus untuk mobile -->
						<div class="mobile-logo d-block d-sm-none text-center py-2">
							<a href="<?=site_url();?>" title="<?=get_setting('web_name');?>">
								<img src="<?=favicon('logo');?>" alt="Logo" style="max-height:40px;">
							</a>
						</div>
						
						<div id="topMenu" class="collapse navbar-collapse top-menus">
							<?php 
								// Load web menu.
								$this->CI->load_menu(
								$menu_group = 2, 
								$ul = 'class="navbar-nav"', 
								$ul_li = 'class="nav-item dropdown"', 
								$ul_li_a ='class="nav-link"', 
								$ul_li_a_ul = 'class="dropdown-menu"'
								);
							?>
						</div>
						<div class="top-seach-link">
							<a href="javascript:void(0)" class="search-toggle"><i class="fa fa-search"></i></a>
						</div>	
					</div>
				</nav>
				<!--/ top nav -->
			</div>
		</section>
		
		<section id="main" class="container main-content mt-2">
			<div class="row">
				<?php $this->CI->_layout($this->CI->__content_view); ?>
			</div>
		</section>
		
		<section id="footer">
			<div class="footer">
				<div class="container">
					<p><?=copyright();?></p>
				</div>
			</div>
		</section>
		
		<!-- script -->
		<script src="<?=site_url('plugins/popper/popper.js');?>"></script>
		<script src="<?=site_url('plugins/bootstrap/js/bootstrap.min.js');?>"></script>
		<script src="<?=site_url('plugins/sticky/jquery.sticky.js');?>"></script>
		<script src="<?=site_url('plugins/prism/prism.js');?>"></script>
		<script src="<?=site_url('plugins/photoswipe/photoswipe.min.js');?>"></script>
		<script src="<?=site_url('plugins/photoswipe/photoswipe-ui-default.min.js');?>"></script>
		<script src="<?=$this->CI->theme_asset('js/jquery.jplayer.min.js');?>"></script>
		<script src="<?=$this->CI->theme_asset('js/jplayerInit.js');?>"></script>
		
		<?php if (get_setting('recaptcha')=="Y"): ?>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<?php endif ?>
		<script src="<?=$this->CI->theme_asset('js/javascript.js');?>"></script>
	</body>
</html>