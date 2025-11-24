<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12 clearfix mb-5 left-content">
	<div class="post-head text-center p-5">
		<p>Maaf Belum ada Postingan untuk kategori <?=$title;?></p>
	</div>
	
	<!-- related posts -->
	<div class="post-head mt-2">
		<h4>Postingan Lainnya</h4>
	</div>
	<div class="post-inner clearfix mb-2">
		<div class="related-posts clearfix">
			<ul>
				<?php
					$related_posts = $this->CI->home_model->related_post_more(15);
					foreach ($related_posts as $res_relatedpost):
				?>
				<li><a href="<?=post_url($res_relatedpost['seotitle']);?>" title="<?=$res_relatedpost['title'];?>"><?=$res_relatedpost['title'];?></a></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>
<!--/ related posts -->