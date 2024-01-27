"use strict";
var KTDatatablescaleg = function() {

	var initTablecaleg = function() {


		var table = $('#tbl_desa');

		// begin first table
		table.DataTable({
			"language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "Data Kosong",
                "info": "Menampilkan _START_ s/d _END_ ( Total :  _TOTAL_ data)",
                "infoEmpty": "Data tidak ditemukan",
                "infoFiltered": "(filtered1 data _MAX_ total data)",
                "lengthMenu": "Menampilkan _MENU_ data",
                "search": "Cari:",
                "zeroRecords": "Data tidak ditemukan"
            },
            /*"order": [
                [1, 'asc']
            ],*/
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "Semua"] // change per page values here
            ],
            "pageLength": 25,
            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            "tableTools": {
                "sSwfPath": "../../assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [{
                    "sExtends": "pdf",
                    "sButtonText": "PDF"
                }, {
                    "sExtends": "csv",
                    "sButtonText": "CSV"
                }, {
                    "sExtends": "xls",
                    "sButtonText": "Excel"
                }, {
                    "sExtends": "copy",
                    "sButtonText": "Copy"
                }]
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "desa/data",
                "type": "GET",
                "data" : function(d){
                   
                }
            },
            "columns": [
                {
                    "data": "id",
                    "width": "50px",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                
                { "data": "VillageCode" },
                { "data": "VillageName" },
                { "data": "subdistrict.SubDistrictName" },
                // {
                //     "data": "SubDistrictID",
                //     "className": "text-center",
                //     "width": "80px",
                //     "visible":true,
                //     "orderable" : false,
                //     render: function (data, type, row, meta) {
                //         var aksi = '';
                       
                //         aksi += '<a href="javascript:;" data-toggle="modal" data-target="#AddCaleg" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_caleg" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                //                  '<i class="fa fa-edit"></i>'+   
                //                 '</a>';

                //         aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_caleg" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
                //                     '<i class="fas fa-trash"></i>'+
                //                 '</a>';
                       
                //         return aksi;
                //     }
                // },
            ]

		});

		
	};

	return {

		//main function to initiate the module
		init: function() {
            $.fn.dataTable.ext.errMode = 'none';
			initTablecaleg();
            $('.datatable').show();
		}
	};
}();




jQuery(document).ready(function() {

    KTDatatablescaleg.init();


    
});


