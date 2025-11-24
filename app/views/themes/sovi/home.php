<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- left content -->
<div class="col-lg-8 col-md-12 clearfix mb-5 left-content">
	
	<!-- headline -->
	<div id="headlines" class="carousel slide headlines mb-4" data-ride="carousel">
		<div class="carousel-inner">
			<?php
				$i = 0;
				$headlines = $this->CI->index_model->get_headline();
				foreach ($headlines as $res_headline):
				$i++;
				$active = ($i == 1 ? 'active' : '');
			?>
			<div class="carousel-item <?=$active;?>">
				<a href="<?=post_url($res_headline['post_seotitle']);?>" class="img-href"><img src="<?=post_images($res_headline['picture'],'medium',TRUE)?>" class="d-block w-100" alt="<?=$res_headline['post_title']?>"></a>
				
				<div class="carousel-caption d-md-block">
					<div class="tagcloud">
						<a href="#" rel="tag" class="bg-red"><?=$res_headline['category_title'];?></a>  
					</div>
					<h6 class="clearfix mb-1"><?=$res_headline['post_title'];?></h6>
					
					<ul class="entry-meta clearfix mb-2">
						<li><i class="cificon licon-calendar"></i> <?=ci_date($res_headline['datepost'], 'l, d F Y');?></li>
					</ul>
					
				</div>
			</div>
			<?php endforeach ?>
		</div>
		<a class="carousel-control-prev" href="#headlines" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
		<a class="carousel-control-next" href="#headlines" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>
	</div>
	<!--/ headline -->
	
	<!--/ left content -->
	<?php
		widget_wide(27);
		widget_boxed(20,30);
	?>
	<!--/ left content -->
</div>

<!-- sidebar -->
<div class="col-lg-4 col-md-12 clearfix mb-5 sidebar">
	<?php $this->CI->_layout('sidebar'); ?>
</div>
<!--/ sidebar -->
