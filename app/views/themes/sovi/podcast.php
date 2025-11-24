<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 
<section id="main" class="container main-content mt-2">
	<div class="row">
		<!-- left content -->
		<div class="col-lg-8 col-md-12 clearfix mb-5 left-content">
			<div class="box-category">
				<div class="post-head">
					<h4><i class="cificon licon-file-text mr-1"></i> Ngaji Online</h4>
				</div>
				<div class="post-inner clearfix">
					<div class="post-lists">
						<div class="row">
							<?php foreach ($data_post as $res): ?>
							<div class="col-md-4">
								<div class="image-warper">
									<a href="<?=site_url('podcast/'.$res['category_seotitle']);?>" title="<?=$res['category_title'];?>">
										<img  src="<?=post_images($res['gambar'],'medium',TRUE);?>" alt="<?=$res['post_title'];?>">
									</a>
									<h5 class="text-center"><a href="<?=site_url('podcast/'.$res['category_seotitle']);?>" title="<?=$res['category_title'];?>"><?=$res['category_title'];?></a></h5>
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