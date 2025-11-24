<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(get_setting('tampil_iklan')=='Y'):?>
<!-- ADS -->
<div class="sidebar-widgets clearfix mb-3">
	<div class="widget">
		
		<?php
			$sidebar_banner = $this->CI->db
			->select('id,gambar,COUNT(*)')
			->from('t_banner')
			->where('aktif','Y')
			->group_by('id')
			->order_by('COUNT(*)','DESC')
			->get()
			->result_array();
			
			foreach ($sidebar_banner as $rescount):
			$filename = $rescount['gambar'];
			if (file_exists(PUBLICPATH."thumbs/$filename")) 
			$image_url = site_url("uploads/$filename");
			else 
			$image_url = site_url("images/thumb_noimage.jpg");
		?>
		<img src="<?=$image_url;?>" style="width:100%;">
		<?php endforeach ?>
		
	</div>
</div>
<?php endif; ?>
<!--/ ADS -->
<!-- Popular, Latest -->
<div class="sidebar-widgets clearfix mb-3">
	<div class="widget clearfix">
		<div class="tabs nobottommargin clearfix" id="sidebar-tabs">
			<ul class="tab-nav clearfix">
				<li><a href="#tabs-1"><i class="icon-star"></i>  Populer</a></li>
				<li><a href="#tabs-2"><i class="icon-clock"></i>  Terbaru</a></li>
			</ul>
			<div class="tab-container">
				<!-- Popular -->
				<div class="tab-content clearfix" id="tabs-1">
					<div id="popular-post-list-sidebar">
						<?php
							// interval = all, week, month, year
							foreach ($this->CI->web->popular_post('all', 5) as $popular_post):
						?>
						<div class="spost clearfix">
							
							<div class="entry-c">
								<div class="entry-title">
									<h4>
										<a href="<?=post_url($popular_post['post_seotitle']);?>" title="<?=$popular_post['post_title'];?>"><?=$popular_post['post_title'];?></a>
									</h4>
								</div>
								
							</div>
						</div>
						<?php endforeach ?>
					</div>
				</div>
				<!--/ Popular -->
				<!-- Latest -->
				<div class="tab-content clearfix" id="tabs-2">
					<div id="recent-post-list-sidebar">
						<?php
							foreach ($this->CI->web->latest_post() as $latest_post):
						?>
						<div class="spost clearfix">
							
							<div class="entry-c">
								<div class="entry-title">
									<h4>
										<a href="<?=post_url($latest_post['post_seotitle']);?>" title="<?=$latest_post['post_title'];?>"><?=$latest_post['post_title'];?></a>
									</h4>
								</div>
								
							</div>
						</div>
						<?php endforeach ?>
					</div>
				</div>
				<!--/ Latest -->
			</div>
		</div>
	</div>
</div>
<!--/ Popular, Latest -->

<div class="sidebar-widgets px-2 clearfix mb-3">
	<div class="widget">
		<?php
			widget_sidebar(6);
		?>
	</div>
</div>
<!-- tags -->
<div class="sidebar-widgets clearfix mb-3">
	<div class="widget-title">
		<h4 class="tx-capitalize">Tags</h4>
	</div>
	<div class="widget clearfix widget-tags">
		<div class="widget-body tagcloud">
			<?php
				$side_tags = $this->CI->db
				->select('
				t_tag.title, 
				t_tag.seotitle, 
				COUNT(t_post.id) AS tag_count
				')
				->from('t_tag')
				->join('t_post', "t_post.tag LIKE CONCAT('%',t_tag.seotitle,'%')", 'LEFT')
				->group_by('t_tag.id')
				->get()
				->result_array();
				foreach ( $side_tags as $row_stag ):
				if ( $row_stag['tag_count'] == 0 )
				continue;
			?>
			<a href="<?=site_url('tag/'.$row_stag['seotitle']);?>" class=""><?=$row_stag['title'];?></a>
			<?php endforeach ?>
		</div>
	</div>
</div>
<!--/ tags -->
<style>
	/* Tabs Navigation */
	.tabs .tab-nav {
	display: flex;
	list-style: none;
	border-bottom: 2px solid #eee;
	margin-bottom: 15px;
	padding-left: 0;
	}
	
	.tabs .tab-nav li {
	margin-right: 15px;
	}
	
	.tabs .tab-nav li a {
	display: inline-block;
	padding: 10px 15px;
	color: #555;
	font-weight: 600;
	border: 1px solid transparent;
	border-radius: 4px 4px 0 0;
	transition: all 0.3s ease;
	text-decoration: none;
	}
	
	.tabs .tab-nav li a:hover,
	.tabs .tab-nav li.ui-tabs-active a {
	color: #000;
	background-color: #f9f9f9;
	border-color: #ddd #ddd transparent;
	}
	
	/* Tab Content Area */
	.tab-content {
	padding: 15px;
	border: 1px solid #ddd;
	
	background-color: #fff;
	}
	
	/* Sidebar Posts */
	.spost {
	display: flex;
	margin-bottom: 15px;
	}
	
	.spost .entry-image {
	flex: 0 0 50px;
	margin-right: 10px;
	}
	
	.spost .entry-image img {
	width: 50px;
	height: 50px;
	object-fit: cover;
	border-radius: 50%;
	}
	
	.spost .entry-c {
	flex: 1;
	}
	.spost:not(:last-child) .entry-c {
	border-bottom: 1px solid #ddd;
	padding-bottom: 5px;
	}
	
	.spost .entry-title h4 {
	margin: 0 0 5px;
	font-size: 15px;
	font-weight: 600;
	}
	
	.spost .entry-title a {
	color: #333;
	text-decoration: none;
	}
	
	.spost .entry-title a:hover {
	color: #007bff;
	}
	
	.spost .entry-meta {
	list-style: none;
	padding: 0;
	margin: 0;
	font-size: 12px;
	color: #777;
	}
	
	.spost .entry-meta li {
	display: inline-block;
	margin-right: 10px;
	}
	
	.spost .entry-meta i {
	margin-right: 5px;
	color: #999;
	}
	
	/* Responsive Behavior */
	@media (max-width: 576px) {
	.spost {
	flex-direction: column;
	}
	
	.spost .entry-image {
	margin-bottom: 10px;
	}
	}
	.tab-nav li.active a {
	background-color: #f9f9f9;
	border-color: #ddd #ddd transparent;
	color: #000;
	}
	.tabs .tab-nav li {
	position: relative;
	margin-right: 0;
	}
	
	.tabs .tab-nav li:not(:last-child)::after {
	content: "";
	position: absolute;
	right: 0;
	top: 25%;
	height: 50%;
	width: 1px;
	background-color: #ddd;
	}
	
</style>

