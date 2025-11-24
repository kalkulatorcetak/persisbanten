<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-inner">
	<div class="d-sm-flex align-items-center justify-content-between pd-b-20">
		<div class="pageheader pd-t-20 pd-b-0">
			<div class="d-flex justify-content-between">
				<div class="clearfix">
					<div class="breadcrumb pd-0 pd-b-10 mg-0">
						<a href="#" class="breadcrumb-item"><?=lang_line('ui_dashboard');?></a>
						<a href="#" class="breadcrumb-item"><?=lang_line('ui_component');?></a>
						<a href="#" class="breadcrumb-item">banner</a>
						<a href="#" class="breadcrumb-item">Edit Data</a>
					</div>
					<h4 class="pd-0 mg-0 tx-20">banner</h4>
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
			<!-- input text | Title -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Title</label>
				<div class="col-md-10">
					<input type="text" name="title" value="<?=$data_row['title'];?>" class="form-control" />
				</div>
			</div>
			<!--/ input text | Title -->
			<!-- input browse filemanager | Gambar -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Gambar</label>
				<div class="col-md-10">
					<div class="input-group" style="max-width:400px;">
						<div class="input-group-prepend">
							<button type="button" id="browse-filemanager" href="<?=site_url('plugins/filemanager/dialog.php?type=1&relative_url=1&field_id=pictures&sort_by=date&descending=1&akey='.fmkey());?>" class="btn btn-default">Browse</button>
						</div>
						<input id="prv" type="text" value="<?=$data_row['gambar'];?>" class="form-control" placeholder="Choose file..." readonly />
					</div>
					<input id="pictures" type="hidden" name="gambar" value="<?=$data_row['gambar'];?>" class="form-control" />
				</div>
			</div>
			<!-- input browse filemanager | Gambar -->
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
			<!-- input select ENUM | Aktif -->
			<div class="form-group row">
				<label class="col-form-label col-md-2">Aktif</label>
				<div class="col-md-10">
					<select name="aktif" class="form-control" style="max-width:400px;" required>
						<option value="<?=$data_row['aktif'];?>" style="display:none;"><?=$data_row['aktif'];?></option><option value="Y">Y</option><option value="N">N</option>
					</select>
				</div>
			</div>
			<!--/ input select ENUM | Aktif -->
			</div> <!-- card-body -->
			<div class="card-footer">
				<button type="submit" class="btn btn-lg btn-primary mr-2"><i class="cificon licon-save mr-2"></i><?=lang_line('button_save');?></button>
			</div>
		<?=form_close();?>
	</div> <!-- card -->
</div> <!-- page-inner -->