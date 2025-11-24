<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12 clearfix mb-5 left-content">
	<div class="box-pages">
		<div class="post-head">
			<h4><i class="cificon licon-image mr-1"></i> Album</h4>
		</div>
		<div class="post-inner clearfix">
			<div class="container">
				<div id="gallery" class="row">
					<?php 
						
						foreach ($all_album_image as $res):
						$rows = $this->db
						->select('picture')
						->where('id_album', $res['id'])
						->where('featured', 1)
						->limit(1)
						->get('t_gallery')
						->row_array();
						
						$photosrc = post_images($rows['picture'],'medium',TRUE);
					?>
					<div class="col-md-4 mb-4">
						<div class="card shadow-sm">
							<a href="/album/<?=$res['seotitle']?>" title="Lihat detail Judul Album 1">
								<img src="<?=$photosrc?>" itemprop="thumbnail" class="card-img-top" alt="<?=$res['title']?>">
							</a>
							<div class="card-body">
								<h5 class="card-title text-center"><?=$res['title']?></h5>
							</div>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>
