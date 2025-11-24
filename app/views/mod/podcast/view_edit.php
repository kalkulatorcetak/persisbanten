<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-inner">
	<div class="d-sm-flex align-items-center justify-content-between pd-b-20">
		<div class="pageheader pd-t-20 pd-b-0">
			<div class="d-flex justify-content-between">
				<div class="clearfix">
					<div class="breadcrumb pd-0 pd-b-10 mg-0">
						<a href="#" class="breadcrumb-item"><?=lang_line('ui_dashboard');?></a>
						<a href="#" class="breadcrumb-item"><?=lang_line('ui_component');?></a>
						<a href="#" class="breadcrumb-item">Podcast</a>
						<a href="#" class="breadcrumb-item">Edit Data</a>
					</div>
					<h4 class="pd-0 mg-0 tx-20">Podcast</h4>
				</div>
			</div>
		</div>
		<div class="mg-t-15">
			<button type="button" class="btn btn-md pd-x-15 btn-white btn-uppercase" onclick="window.location='<?=admin_url($this->mod);?>'"><i data-feather="arrow-left" class="mr-2"></i><?=lang_line('button_back');?></button>
		</div>
	</div>
	
	<div>
		<?=$this->cifire_alert->show($this->mod);?>
		<div class="ajax_alert" style="display:none;"></div>
	</div>
	
	<div class="card">
		<div class="card-header">
			<h6 class="lh-5 mg-b-0">Edit Data</h6>
		</div>
		<?php 
			echo form_open('','autocomplete="off"');
			echo form_hidden('act', '1');
		?>
		<div class="card-body">
			<!-- input number | Id Penceramah -->
			<!-- Penceramah -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Penceramah</label>
				<div class="col-md-10">
					<select name="id_penceramah" class="select2 form-control" data-placeholder="- Penceramah -">
					<?php
						if (is_null($data_row['id_penceramah'])) {
							echo '<option style="display:none;"></option>';
						}
						
						foreach ($penceramah as $category) {
							$selected = ($category['id']==$data_row['id_penceramah']?'selected':'');
							echo '<option value="'. encrypt($category['id']) .'" '. $selected .'>'. $category['title'] .'</option>';
						}
					?>
				</select>
				</div>
			</div>
			  
			<!-- input text | Title -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Title</label>
				<div class="col-md-10">
					<input type="text" name="title" value="<?=$data_row['title'];?>" class="form-control" />
				</div>
			</div>
			<!--/ input text | Title -->
			 
			<!-- textarea | Link Audio -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Link Audio</label>
				<div class="col-md-10">
					<textarea name="link_audio" class="form-control"><?=$data_row['link_audio'];?></textarea>
				</div>
			</div>
			<!--/ textarea | Link Audio -->
			<!-- input datetime | Tanggal -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Tanggal</label>
				<div class="col-md-10">
					<div class="input-group" style="max-width:250px;">
						<input id="datetime-picker" type="text" name="tanggal" value="<?=$data_row['tanggal'];?>" class="form-control" placeholder="yyyy-mm-dd HH:ii:ss" required/>
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
			</div>
			<!--/ input datetime | Tanggal -->
			<!-- input select ENUM | Active -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Active</label>
				<div class="col-md-10">
					<select name="active" class="form-control" style="max-width:400px;" required>
						<option value="<?=$data_row['active'];?>" style="display:none;"><?=$data_row['active'];?></option><option value="Y">Y</option><option value="N">N</option>
					</select>
				</div>
			</div>
			<!--/ input select ENUM | Active -->
		</div> <!-- card-body -->
		<div class="card-footer">
			<button type="submit" class="btn btn-lg btn-primary mr-2"><i class="cificon licon-save mr-2"></i><?=lang_line('button_save');?></button>
		</div>
		<?=form_close();?>
	</div> <!-- card -->
</div> <!-- page-inner -->