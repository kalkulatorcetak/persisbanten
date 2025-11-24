<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section id="main" class="container main-content mt-2">
	<div class="row">
		<!-- left content -->
		<div class="col-lg-8 col-md-12 clearfix mb-5 left-content">
			<div class="box-category">
				<div class="post-head">
					<h4><i class="cificon licon-file-text mr-1"></i> <?=$penceramah;?></h4>
				</div>
				<div class="post-inner clearfix">
					<div class="post-lists">
						<div class="row">
							<?php foreach ($data_post as $val): ?>
							<div class="col-lg-12 col-md-12 col-sm-12  mix entrepreneurship">
								<div class="podcast__item">
									<div class="podcast__item__text" style="padding:15px 15px !important">
										<ul class="pl-0">
											<li><span class="icon_calendar"></span> <?=ci_date($val['tanggal'], 'l, d F Y');?></li>
										</ul>
										<h5><a href="/podcast/<?=$seotitle;?>/<?=$val['post_seotitle'];?>"><?=$val['judul'];?></a></h5>
										<div class="track__option">
											<div class="jp-jplayer jplayer" data-ancestor=".jp_container-<?=$val['post_id'];?>"
											data-url="<?=$val['link_audio'];?>"></div>
											<div class="jp-audio jp_container-<?=$val['post_id'];?>" role="application" aria-label="media player">
												<div class="jp-gui jp-interface">
													<!-- Player Controls -->
													<div class="player_controls_box">
														<button class="jp-play player_button" tabindex="0"></button>
													</div>
													<!-- Progress Bar -->
													<div class="player_bars">
														<div class="jp-progress">
															<div class="jp-seek-bar">
																<div>
																	<div class="jp-play-bar">
																		<div class="jp-current-time" role="timer" aria-label="time">
																			0:00
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="jp-duration ml-auto" role="timer" aria-label="duration">00:00
														</div>
													</div>
													<!-- Volume Controls -->
													<div class="jp-volume-controls">
														<button class="jp-mute" tabindex="0"><span
														class="icon_volume-high"></span></button>
														<div class="jp-volume-bar">
															<div class="jp-volume-bar-value" style="width: 0%;"></div>
														</div>
													</div>
												</div>
												<div class="jp-btns">
													<div class="share-button sharer" style="display: block;">
														<a href="javascript:void(0)"><i class="fa fa-play"></i> <span id="count_play"><?=$val['count'];?></span>x</a>
														<a href="<?=$val['link_audio'];?>"><i class="fa fa-download"></i> Download</a>
														<!--button type="button" class="btn btn-success btn-sm share-btn"><i class="social_share text-white"></i> Share</button>
															<!--div class="social top center networks-5 ">
															<!-- Facebook Share Button --
															<a class="fbtn share facebook" href="https://www.facebook.com/sharer/sharer.php?u="><i class="fa fa-facebook-f"></i></a>  
															<!-- Twitter Share Button --
															<a class="fbtn share twitter" href="https://twitter.com/intent/tweet?text=title&amp;url=&amp;via=persisbanten"><i class="fa fa-twitter"></i></a> 
															<!-- Pinterest Share Button --
															<a class="fbtn share whatsapp" href="whatsapp://send?text="><i class="fa fa-whatsapp"></i></a>
															
														</div-->
													</div>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
				<div class="post-footer">
					<div class="">
						<ul class="pagination">
							<?=$page_link;?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--/ left content -->
		<!-- sidebar -->
		<div class="col-lg-4 col-md-12 clearfix mb-5 sidebar">
			<?php $this->CI->_layout('sidebar'); ?>
		</div>
		<!--/ sidebar -->
	</div>
</section>
<script>
	$( document ).ready(function() {
		//custom button for homepage
		$( ".share-btn" ).click(function(e) {
			$('.networks-5').not($(this).next( ".networks-5" )).each(function(){
				$(this).removeClass("active");
			});
			
			$(this).next( ".networks-5" ).toggleClass( "active" );
		});   
	});
</script>