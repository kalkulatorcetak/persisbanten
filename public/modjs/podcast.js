/**
	* - This file was created using CoGen
	* 
	* - Date created : 2025-08-04 | 12:23
	* - Author       : CiFireCMS
	* - License      : MIT License
*/

$(function() {
	'use strict'
	
	// DataTable
	// $('#DataTable').DataTable({
	// language: {
	// url: datatable_lang,
	// },
	// autoWidth: false,
	// responsive: true,
	// processing: true,
	// serverSide: true,
	// order: [],
	// columnDefs: [
	// {targets: 'no-sort', orderable: false, searchable: false},
	// {targets: 'th-action', orderable: false, searchable: false, width: '50px'},
	// {targets: [0], width: '20px'},
	// {targets: [1], width: '20px'}
	// ],
	// lengthMenu: [
	// [10, 30, 50, 100, -1],
	// [10, 30, 50, 100, 'All']
	// ],
	// ajax: {
	// type : 'POST',
	// data : csrfData
	// },
	// drawCallback: function(settings) {
	// var apiTable = this.api();
	// dataTableDrawCallback(apiTable);
	// }
	// });
	var _dTable = $('#DataTable').DataTable({
		language: {
			url: datatable_lang,
		},
		autoWidth: false,
		responsive: true,
		processing: true,
		serverSide: true,
		order: [],
		rowReorder: {
			dataSrc: 'position' // kolom yang mewakili urutan
		},
		columnDefs: [
			{targets: 'no-sort', orderable: false, searchable: false},
			{targets: 'th-action', orderable: false, searchable: false, width: '50px'},
			{targets: [0], width: '20px'},
			{targets: [1], width: '20px'}
		],
		columns: [
			{ data: 'checkbox' },
			{ data: 'id' },
			{ data: 'title' },
			{ data: 'audio' },
			{ data: 'tanggal' },
			{ data: 'status' },
			{ data: 'action' },
			{ data: 'position', visible: false } // tidak harus ditampilkan
		],
		
		lengthMenu: [
			[10, 30, 50, 100, -1],
			[10, 30, 50, 100, 'All']
		],
		ajax: {
			type: 'POST',
			data: function(d) {
				$.extend(d, csrfData);
				d.id_penceramah = $('#id_penceramah').val(); // pastikan ada elemen ini
			}
		},
		drawCallback: function(settings) {
			var apiTable = this.api();
			dataTableDrawCallback(apiTable);
		}
	});
	$('#id_penceramah').change(function() {
		_dTable.ajax.reload();
	});
	_dTable.on('row-reorder', function (e, diff, edit) {
		let orderData = [];
		let idPenceramah = $('#id_penceramah').val(); // ambil dari form/filter
		diff.forEach(function (item) {
			let rowData = _dTable.row(item.node).data();
			orderData.push({
				id: rowData.id,        // pastikan JSON dari server punya `id`
				position: item.newData // posisi baru
			});
		});
		
		$.ajax({
			url: admin_url+"/podcast/update_order",
			method: 'POST',
			data: {
				order: orderData,
				id_penceramah: idPenceramah,
				csrf_name: csrfToken // ganti dengan token CSRF kamu
			},
			success: function (res) {
				console.log('Order updated successfully');
			}
		});
	});
	
	
	// datetime-picker  
	$('#datetime-picker').datetimepicker({
		format    : 'YYYY-MM-DD HH:mm:ss',
		showClear : true,
		showTodayButton : true,
		icons : {
			previous: 'icon-arrow-left8',
			next  : 'icon-arrow-right8',
			today : 'fa fa-calendar-check-o',
			clear : 'icon-bin',
		},
	});
	
	
	// datepicker
	$('#date-picker').datetimepicker({
		format : 'YYYY-MM-DD',
		showClear : true,
		showTodayButton : true,
		icons : {
			previous : 'icon-arrow-left8',
			next     : 'icon-arrow-right8',
			today    : 'fa fa-calendar-check-o',
			clear    : 'icon-bin',
		},
	});
	
	
	// clockpicker
	$('#time-picker').datetimepicker({
		format : 'HH:mm:ss',
		showClear : true,
		showTodayButton : true,
		icons : {
			up    : 'icon-arrow-up7',
			down  : 'icon-arrow-down7',
			today : 'fa fa-clock-o',
			clear : 'icon-bin',
		},
	});
	
	
	// textarea-tinymce
	cfTnyMCE('#textarea-tinymce', 300);
	
	
	// filemanager
	$('#browse-filemanager').fancybox({ 
		width     : 1000, 
		height    : 1000, 
		type      : 'iframe', 
		autoScale : false,
	});
});

// filemanager callback
function responsive_filemanager_callback(field_id) {
	// console.log(field_id);
	var url = $('#' + field_id).val();
	$('#prv').val(url);
	parent.$.fancybox.close();
}
