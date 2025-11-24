<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section  class="main-content mt-0">
	<section class="breadcrumb-option spad set-bg" data-setbg="https://sandbox.persisbanten.com/themes/persis/images/breadcrumb-bg.jpg" style="background-image: url(&quot;https://sandbox.persisbanten.com/themes/persis/images/breadcrumb-bg.jpg&quot;);">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb__text">
						<h2><?=$podcast['title'];?></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="single__track">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<div class="single__track__item">
							<div class="single__track__item__pic">
								<img src="<?=post_images($penceramah['gambar'],'medium',TRUE);?>" alt="<?=$penceramah['title'];?>">
							</div>
							<div class="single__track__item__text">
								<h5 class="penceramah"><a href="/podcast/ustadz-kasman"><?=$penceramah['title'];?></a></h5>
								<span><?=$penceramah['kategori'];?></span>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="single__track__option">
							<div class="jp-jplayer jplayer" data-ancestor=".jp_container" data-url="<?=$podcast['link_audio'];?>" id="jp_jplayer_0" style="width: 0px; height: 0px;"><img id="jp_poster_0" style="width: 0px; height: 0px; display: none;"><audio id="jp_audio_0" preload="metadata" src="<?=$podcast['link_audio'];?>"></audio></div>
							<div class="jp-audio jp_container" role="application" aria-label="media player">
								<div class="jp-gui jp-interface">
									<!-- Player Controls -->
									<div class="player_controls_box">
										<button class="jp-play player_button" tabindex="0"></button>
									</div>
									<!-- Progress Bar -->
									<div class="player_bars">
										<div class="jp-progress">
											<div class="jp-seek-bar" style="width: 100%;">
												<div>
													<div class="jp-play-bar" style="width: 0%;">
														<div class="jp-current-time" role="timer" aria-label="time">00:00</div>
													</div>
												</div>
											</div>
										</div>
										<div class="jp-duration ml-auto" role="timer" aria-label="duration">09:01</div>
									</div>
									<!-- Volume Controls -->
									<div class="jp-volume-controls">
										<button class="jp-mute" tabindex="0"><span class="icon_volume-high"></span></button>
										<div class="jp-volume-bar">
											<div class="jp-volume-bar-value" style="width: 90%;"></div>
										</div>
									</div>
								</div>
								<!-- AddToAny BEGIN -->
								<div class="jp-btns">
									<a class="a2a_dd" href="https://www.addtoany.com/share#url=<?=$podcast['title_seo'];?>"><i class="social_share"></i> Share</a>
									<a href="<?=$podcast['link_audio'];?>"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<style>
	
	.main-content {
    width: 100% !important;
	}
	.penceramah a{color:yellow}
</style>
<script>
	$( document ).ready(function() {
		$("#main").removeClass('container main-content mt-2');
		//custom button for homepage
		$( ".share-btn" ).click(function(e) {
			$('.networks-5').not($(this).next( ".networks-5" )).each(function(){
				$(this).removeClass("active");
			});
			
			$(this).next( ".networks-5" ).toggleClass( "active" );
		});   
	});
</script>