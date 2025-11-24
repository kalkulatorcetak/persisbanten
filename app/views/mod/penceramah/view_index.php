<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-inner">
<div class="d-sm-flex align-items-center justify-content-between pd-b-20">
<div class="pageheader pd-t-20 pd-b-0">
<div class="d-flex justify-content-between">
<div class="clearfix">
<div class="breadcrumb pd-0 pd-b-10 mg-0">
<a href="#" class="breadcrumb-item"><?=lang_line('ui_dashboard');?></a>
<a href="#" class="breadcrumb-item">Penceramah</a>
</div>
<h4 class="pd-0 mg-0 tx-20">Penceramah</h4>
</div>
</div>
</div>
<div class="mg-t-15">
<button type="button" class="btn btn-md pd-x-15 btn-white btn-uppercase" onclick="window.location='<?=admin_url($this->mod.'/add');?>'"><i data-feather="plus" class="mr-2"></i><?=lang_line('button_add');?></button>
</div>
</div>

<div>
<?=$this->cifire_alert->show($this->mod);?>
<div class="ajax_alert" style="display:none;"></div>
</div>

<div class="card">
<div class="table-responsive">
<div class="card-body">
<table id="DataTable" class="table table-striped table-bordered table-datatable">
<thead>
<tr>
<th>Id</th>
<th>Title</th>
<th>Kategori</th>
<th>Status</th>
<th class="th-action text-center">Action</th>
</tr>
</thead>
<tbody></tbody>
</table>
</div>
</div>
</div>
</div>