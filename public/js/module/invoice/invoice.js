"use strict";
var KTDatatablesInvoice = function() {

    var initTableInboxInvoice = function() {
		var table = $('#tbl_inbox_invoice');

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
            "order": [
                [0, 'desc']
            ],
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
                "url": "invoices/ajax-data-inbox",
                "type": "GET",
                "data" : function(d){
                    d.no_invoice = $('#filter_no_invoice').val();
                    
                    d.date_start = $('#filter_tgl_start').val();
                    d.date_end = $('#filter_tgl_end').val();
                    
                    d.nama_vendor = $('#filter_vendor').val();
                    d.no_kontrak = $('#filter_no_kontrak').val();

                    d.nilai_invoice_start = $('#filter_nilai_start').val();
                    d.nilai_invoice_end = $('#filter_nilai_end').val();
 
                    d.tgl_bayar_start = $('#filter_tgl_bayar_start').val();
                    d.tgl_bayar_end = $('#filter_tgl_bayar_end').val();

                    d.currency_id = $('#filter_currency_id').val();
                    d.tahapan_id = $('#filter_tahapan_id').val();
                    d.kendala = $('#filter_kendala').val();
                    d.jenis_prk = $('#filter_jenis_prk').val();
                }
            },
            "columns": [
                {
                    "data": "id",
                    "width": "30px",
                    render: function (data, type, row, meta) {
                        var num = meta.row + meta.settings._iDisplayStart + 1;
                        var check = "";
                        if(jv_verifikator=='true' && (parseInt(row.verifikator)>0) && (row.reimburse_id=="" || row.reimburse_id==null)){
                            check = "<input class='checklist_reimburse' type='checkbox'  name='is_check_reimburse[]' id='"+data+"' >";
                        }
                        else if(jv_verifikasi_treasury=='true' && row.tahapan_id==12){
                            if(parseFloat(row.grouping_id)>0){
                                check = "<input  type='checkbox' disabled='disabled' checked='checked'  name='is_check_treasury_checked[]' id='"+data+"' >";
                            }else{
                                check = "<input class='checklist_treasury' type='checkbox'  name='is_check_treasury[]' id='"+data+"' >";
                            }
                            
                        }
                        else{

                        }
                        return num+" "+check;
                    }
                },
                { 
                    "data": "no_invoice" ,
                    "width": "90px"
                },
                { 
                    "data": "tgl_invoice",
                    render: function (data, type, row, meta) {
                       
                        return tanggalIndo(data);
                    }  
                },
                { "data": "nama_vendor" },
                { 
                    "data": "no_kontrak",
                    "width": "90px" 
                },
                { "data": "uraian_pekerjaan", "width": "130px", },
                { 
                    "data": "nilai_invoice" ,
                    "width": "110px",
                    "className": "text-right",
                    render: function (data, type, row, meta) {
                        return row.code+data;
                        
                    }
                },
                { 
                    "data": "tahapan" ,
                    render: function (data, type, row, meta) {
                        var status ="";
                        let disposisi ="Admin KKU";
                        if(row.tahapan_id>1 && row.tahapan_id<16){
                            disposisi = row.disposisi;
                        }else if(row.tahapan_id==16){
                            disposisi = "Paid";
                        }
                        var tahapan_id = row.tahapan_id;
                        if(parseInt(row.tahapan_id)==16){
                            tahapan_id = 13;
                        }
                        const step=13;
                        let label ="";
                        let step_fast = step-tahapan_id;
                        //status += "Waiting Verifikasi ";
                        status += disposisi;
                        status += "<br>";
                        // far fa-check-circle
                        for (let i = 1; i < tahapan_id; i++) {
                            if(i===1){label="Admin KKU";}
                            else if(i===2){label="Sekretaris GM";}
                            else if(i===3){label="GM";}
                            else if(i===4){label="SRM KKU";}
                            else if(i===5){label="MSB KEU & AKT, MSB ANG & AGA";}
                            else if(i===6){label="AMN KEU, Staf Pajak, Staf ANG";}
                            else if(i===7){label="Verifikator";}
                            else if(i===8){label="AMN KEU";}
                            else if(i===9){label="MSB KEU & AKT";}
                            else if(i===10){label="SRM KKU";}
                            else if(i===11){label="GM";}
                            else if(i===12){label="Treasury";}
                            else if(i===13){label="AMN KEU";}
                            else if(i===14){label="GM, SRM KKU , MSB KEU & AKT";}
                            else if(i===15){label="Treasury";}
                            else{label="";}
                            status += "<i class='far fa-check-circle text-success' data-toggle='popover' title='"+label+"'></i> ";
                        }
                        for (let index = 0; index < step_fast; index++) {
                            status += "<i class='far fa-circle' ></i> ";
                        }

                        if(row.is_cancel_payment=='1'){
                            status += '<span class="label label-light-danger label-inline font-weight-bold">Cancel</span>';
                        }
                        else if(row.is_verifikasi=='0' || row.is_cancel_payment=='2'){
                            //return data+" <i class='flaticon-circle text-danger'></i>" ;
                            status +=  '<span class="label label-light-warning label-inline font-weight-bold">Pending</span>';
                        }
                       
                        return status;
                    }
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                        aksi += '<a data-toggle="modal" data-target="#riwayatInvoice" class="btn btn-sm btn-clean btn-icon mr-2 btn_riwayat_invoice" uid="'+data+'" data-toggle="popover" title="Tracking Invoice" data-html="true" data-content="">'+
                                 '<i class="fas fa-history"></i>'+   
                                '</a>';
                        aksi += '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2 btn_detail_invoice" uid="'+data+'" data-toggle="popover" title="Detail" data-html="true" data-content="">'+
                                 '<i class="fa fa-eye"></i>'+   
                                '</a>';
                       
                        if(jv_delete=='true' && row.tahapan_id==1){
                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_invoice" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</a>';
                        }
                        return aksi;
                    }
                },
            ]

		});

		
	};

	var initTableInvoice = function() {
		var table = $('#tbl_invoice');

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
            "order": [
                [0, 'desc']
            ],
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
                "url": "invoices/ajax-data",
                "type": "GET",
                "data" : function(d){
                    d.no_invoice = $('#filter_no_invoice').val();
                    
                    d.date_start = $('#filter_tgl_start').val();
                    d.date_end = $('#filter_tgl_end').val();
                    
                    d.nama_vendor = $('#filter_vendor').val();
                    d.no_kontrak = $('#filter_no_kontrak').val();

                    d.nilai_invoice_start = $('#filter_nilai_start').val();
                    d.nilai_invoice_end = $('#filter_nilai_end').val();
 
                    d.tgl_bayar_start = $('#filter_tgl_bayar_start').val();
                    d.tgl_bayar_end = $('#filter_tgl_bayar_end').val();

                    d.currency_id = $('#filter_currency_id').val();
                    d.tahapan_id = $('#filter_tahapan_id').val();
                    d.jenis_invoice = $('#filter_jenis_invoice').val();
                    d.no_prk = $('#filter_no_prk').val();
                    d.kendala = $('#filter_kendala').val();
                    d.jenis_prk = $('#filter_jenis_prk').val();
                }
            },
            "columns": [
                {
                    "data": "id",
                    "width": "30px",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { 
                    "data": "no_invoice" ,
                    "width": "90px", 
                },
                { 
                    "data": "tgl_invoice",
                    render: function (data, type, row, meta) {
                        return tanggalIndo(data);
                    }   
                },
                { "data": "nama_vendor" },
                { 
                    "data": "no_kontrak",
                    "width": "90px", 
                    render: function (data, type, row, meta) {
                        var pjg = data.length;
                        var no_kontrak = "";
                        if(pjg>13){
                            if(pjg<27){
                                no_kontrak = data.substr(0,13)+" "+data.substr(13,14);
                            }else{
                                no_kontrak = data.substr(0,13)+" "+data.substr(13,13)+" "+data.substr(26,30);
                            }
                            
                        }else{
                            no_kontrak = data;
                        }
                       return no_kontrak;
                    }
                },
                { "data": "uraian_pekerjaan" },
                { 
                    "data": "nilai_invoice" ,
                    "width": "110px",
                    "className": "text-right",
                    render: function (data, type, row, meta) {
                        if(row.currency_id==1){
                            return row.code+viewThousandsSeparator(data,0,0);
                        }else{
                            return row.code+viewThousandsSeparator(data,1,0);
                        }
                       
                    }
                },
                { 
                    "data": "no_prk" ,
                    "width": "110px",
                    "visible" : false 
                },
                { 
                    "data": "tahapan" ,
                    render: function (data, type, row, meta) {
                        var status ="";
                        let label ="";
                        let disposisi ="Admin KKU";
                        if(row.tahapan_id>1 && row.tahapan_id<16){
                            disposisi = row.disposisi;
                        }else if(row.tahapan_id==16){
                            disposisi = "Paid";
                        }
                        var tahapan_id = row.tahapan_id;
                        if(parseInt(row.tahapan_id)==16){
                            tahapan_id = 13;
                        }
                        const step=13;
                        let step_fast = step-tahapan_id;
                        //status += "Waiting Verifikasi ";
                        status += disposisi;
                        status += "<br>";
                        // far fa-check-circle
                        for (let i = 1; i < tahapan_id; i++) {
                            if(i===1){label="Admin KKU";}
                            else if(i===2){label="Sekretaris GM";}
                            else if(i===3){label="GM";}
                            else if(i===4){label="SRM KKU";}
                            else if(i===5){label="MSB KEU & AKT, MSB ANG & AGA";}
                            else if(i===6){label="AMN KEU, Staf Pajak, Staf ANG";}
                            else if(i===7){label="Verifikator";}
                            else if(i===8){label="AMN KEU";}
                            else if(i===9){label="MSB KEU & AKT";}
                            else if(i===10){label="SRM KKU";}
                            else if(i===11){label="GM";}
                            else if(i===12){label="Treasury";}
                            else if(i===13){label="AMN KEU";}
                            else if(i===14){label="GM, SRM KKU , MSB KEU & AKT";}
                            else if(i===15){label="Treasury";}
                            else{label="";}
                            status += "<i class='far fa-check-circle text-success' data-toggle='popover' title='"+label+"'></i> ";
                        }
                        for (let index = 0; index < step_fast; index++) {
                            status += "<i class='far fa-circle'></i> ";
                        }

                        if(row.is_cancel_payment=='1'){
                            status += '<span class="label label-light-danger label-inline font-weight-bold">Cancel</span>';
                        }
                        else if(row.is_verifikasi=='0' || row.is_cancel_payment=='2'){
                            status +=  '<span class="label label-light-warning label-inline font-weight-bold">Pending</span>';
                        }

                        if(parseInt(row.reimburse_id)>0){
                            status +=  '<span class="label label-light-primary label-inline font-weight-bold">Reimburse</span>';
                        }
                        return status;
                        
                    }
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "117px",
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                        aksi += '<a data-toggle="modal" data-target="#riwayatInvoice" class="btn btn-sm btn-clean btn-icon mr-2 btn_riwayat_invoice" uid="'+data+'" data-toggle="popover" title="Tracking Invoice" data-html="true" data-content="">'+
                                 '<i class="fas fa-history"></i>'+   
                                '</a>';
                        aksi += '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2 btn_detail_invoice" uid="'+data+'" data-toggle="popover" title="Detail" data-html="true" data-content="">'+
                                 '<i class="fa fa-eye"></i>'+   
                                '</a>';
                        
                        if(jv_update=='true' && role_id==3 && row.tahapan_id<8){
                            aksi +=  '<a data-toggle="modal" data-target="#ModalUpdateDeskripsi" class="btn btn-sm btn-clean btn-icon btn_update_deskripsi_invoice" uid="'+data+'" data-toggle="popover" title="Update Deskripsi" data-html="true" data-content="">'+
                                        '<i class="fas fa-edit"></i>'+
                                    '</a>';
                        }

                        if(role_id==12 &&  row.tahapan_id>1 && row.tahapan_id<8){
                            aksi +=  '<a data-toggle="modal" data-target="#ModalUpdateDeskripsi" class="btn btn-sm btn-clean btn-icon btn_update_deskripsi_invoice" uid="'+data+'" data-toggle="popover" title="Update Deskripsi" data-html="true" data-content="">'+
                                        '<i class="fas fa-edit"></i>'+
                                    '</a>';
                        }

                        if(jv_delete=='true' && row.tahapan_id==1){
                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_invoice" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</a>';
                        }
                        return aksi;
                    }
                },
            ]

		});

		
	};

    var initTableGroupingInvoice = function() {
		var table = $('#tbl_grouping');

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
            "order": [
                [0, 'desc']
            ],
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
                "url": "grouping/ajax-data-grouping",
                "type": "GET",
                "data" : function(d){
                    d.deskripsi = $('#filter_gr_deskripsi').val();
                    
                    d.tgl_bayar_start = $('#filter_gr_tgl_bayar_start').val();
                    d.tgl_bayar_end = $('#filter_gr_tgl_bayar_end').val();

                    d.currency_id = $('#filter_gr_currency_id').val();
                    d.bank_id = $('#filter_gr_bank_id').val();
                    d.cek = $('#filter_gr_cek').val();
                    d.no_invoice = $('#filter_gr_no_invoice').val();
                }
            },
            "columns": [
                {
                    "data": "id",
                    "width": "30px",
                    render: function (data, type, row, meta) {
                        var num = meta.row + meta.settings._iDisplayStart + 1;
                        return num;
                    }
                },
                { 
                    "data": "keterangan"
                },
                { 
                    "data": "tgl_bayar",
                    render: function (data, type, row, meta) {
                       
                        return tanggalIndo(data);
                    }  
                },
                { "data": "no_cek" },
                { 
                    "data": "bank.bank",
                    "width": "90px" 
                },
                { 
                    "data": "saldo_awal" ,
                    "width": "110px",
                    "className": "text-right",
                    render: function (data, type, row, meta) {
                        if(row.currency_id==1){
                            return row.bank.ref_currencies.code+viewThousandsSeparator(data,0,0);
                        }else{
                            return row.bank.ref_currencies.code+viewThousandsSeparator(data,1,0);
                        }
                        
                    }
                },
                { 
                    "data": "total_nilai" ,
                    "width": "110px",
                    "className": "text-right",
                    render: function (data, type, row, meta) {
                        if(row.currency_id==1){
                            return row.bank.ref_currencies.code+viewThousandsSeparator(data,0,0);
                        }else{
                            return row.bank.ref_currencies.code+viewThousandsSeparator(data,1,0);
                        }
                        
                    }
                },
                { 
                    "data": "saldo_akhir" ,
                    "width": "110px",
                    "className": "text-right",
                    render: function (data, type, row, meta) {
                        if(row.currency_id==1){
                            return row.bank.ref_currencies.code+viewThousandsSeparator(data,0,0);
                        }else{
                            return row.bank.ref_currencies.code+viewThousandsSeparator(data,1,0);
                        }
                        
                    }
                },
                { 
                    "data": "invoice_count",
                    "width": "90px" 
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                        aksi += '<a data-toggle="modal" data-target="#ModalListGroupingTreasury" class="btn btn-sm btn-clean btn-icon mr-2 btn_list_grouping_invoice" uid="'+data+'" data-toggle="popover" title="Daftar Invoice" data-html="true" data-content="">'+
                                '<i class="fa fa-clipboard-list"></i>'+   
                            '</a>';

                        aksi += '<a data-toggle="modal" data-target="#ModalUpdateGroupingTreasury" class="btn btn-sm btn-clean btn-icon mr-2 btn_update_grouping_invoice" uid="'+data+'" data-toggle="popover" title="Update" data-html="true" data-content="">'+
                            '<i class="fa fa-edit"></i>'+   
                        '</a>';
                       
                        if(row.invoice_count==0){
                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_grouping" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</a>';
                        }
                        return aksi;
                    }
                },
            ]

		});

		
	};

	return {

		//main function to initiate the module
		init: function() {
            $.fn.dataTable.ext.errMode = 'none';
			initTableInvoice();
            initTableInboxInvoice();
            initTableGroupingInvoice();
            $('.datatable').show();
		}
	};
}();

function panel(param=""){
    if(param=="grid"){
        $('.panel-grid-invoice').show();
        $('.panel-form-invoice').hide();
        $('.panel-detail-invoice').hide();
        $('.panel-form-verifikator').hide();
    }
    else if(param=="detail"){
        $('.panel-grid-invoice').hide();
        $('.panel-detail-invoice').show();
        $('.panel-form-invoice').hide();
        $('.panel-form-verifikator').hide();
    }
    else if(param=="form_verifikator"){
        $('.panel-grid-invoice').hide();
        $('.panel-detail-invoice').hide();
        $('.panel-form-invoice').hide();
        $('.panel-form-verifikator').show();
    }
    else{
        $('.panel-grid-invoice').hide();
        $('.panel-detail-invoice').hide();
        $('.panel-form-verifikator').hide();
        $('.panel-form-invoice').show();
    } 
}


function ResetForm(){
    document.getElementById("form_invoice").reset();
    $("#InvoiceID").val("");
    $("#no_invoice").val("");
    $("#tgl_invoice").val("");
    $("#vendor").val("");
    $("#no_kontrak").val("");
    $("#uraian_pekerjaan").val("");
    $("#currency_id").val("").trigger('change');
    $("#kurs").val("");
    $("#kurs_mask").val("");
    $("#nilai_invoice").val("");
    $("#nilai_invoice_mask").val("");
    $("#nilai_invoice_idr").val("");
    $("#nilai_invoice_idr_mask").val("");
    $("#link_invoice").val("");
    $("#linkname_invoice").val("");
}

function ResetFormDokumen(){
    document.getElementById("form_upload_dokumen_invoice").reset();
    $("#file_invoice").val("");
}

function ResetFormVerifikator(){
    document.getElementById("form_verifikator_invoice").reset();
    $("#periode").val("");
    $("#sap").val("");
    $("#kategori_invoice");
    $("#pinalti_ver").val("");
    $("#pinalti_ver_mask").text("");
    $("#rounding_ver").val("");
    $("#rounding_ver_mask").text("");
    
    $("#netto_ver_show").val("");
    $("#netto_ver").val("");
    $("#note_ver").val("");
    $("#nama_bank_ver").val("");
    $("#norek_ver").val("");
    $("#nama_rekening_ver").val("");
    
}

function ResetFormVerifikasi(){
    document.getElementById("form_verifikasi_invoice").reset();
    $("#nilai_invoice_verifikasi_show").val("");
    $("#nilai_invoice_pjk").val("");
    $("#tipe_dpp").val("").trigger('change');
    $("#dpp").val("");
    $("#dpp_mask").val("");
    $("#tarif_pjk_ppn").val("");
    $("#nilai_pajak_ppn_show").val("");
    $("#nilai_pajak_ppn").val("");
    $("#pph_id").val("");
    $("#tarif_pjk_pph").val("");
    $("#nilai_pajak_pph_show").val("");
    $("#nilai_pajak_pph").val("");

    $("#klasifikasi_biaya_id").val("").trigger('change');
    $("#prk_id").val("");
    $("#unit").val("").trigger('change');

    $("#bank_id").val("").trigger('change');
    $("#no_dokumen_bayar").val("");
    $("#tgl_bayar_invoice").val("");
    $("#no_cek").val("");
    

    $("#keterangan_disposisi_id").val("").trigger('change');
    $("#bidang_id").val("").trigger('change');
    $("#keterangan_dikembalikan").val("").trigger('change');
    $("#kendala").val("").trigger('change');
    $("#keterangan_verifikasi").val("");
    
}

function HideButtonByAccessRole(role,tahapan_id){

    if(jv_disposisi=="true"){
        $(".btn_modal_disposisi_invoice").show();
    }else{
        $(".btn_modal_disposisi_invoice").hide();
    }

    
}

function HideButtonByTahapan(tahapan_id,role_id){
    // button disposisi
    if(tahapan_id==1 && role_id==3){
        $(".btn_modal_disposisi_invoice").show();
    }else{
        $(".btn_modal_disposisi_invoice").hide();
    }
    
}

async function setupForm(id="",show="form"){
    const response = await fetch('invoices/show', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            id: id
        })
    });
    let responseJson = await response.json();
    if(responseJson.id!=''){
        ResetForm();
        //--//
        $("#digit").val(responseJson.digit);
        $("#InvoiceID").val(responseJson.id);
        $("#InvoiceIDDoc").val(responseJson.id);
        $("#invid_print").val(responseJson.InvoiceIDEnc);
        $("#invid_export").val(responseJson.id);
        $("#no_invoice_edit").val(responseJson.no_invoice);
        $("#tgl_invoice_edit").val(responseJson.tgl_invoice);
        $("#vendor_edit").val(responseJson.nama_vendor);
        $("#no_kontrak_edit").val(responseJson.no_kontrak);
        $("#uraian_pekerjaan_edit").val(responseJson.uraian_pekerjaan);
        $("#nilai_invoice_edit").val(responseJson.nilai_invoice);
        $("#nilai_invoice_mask_edit").val(viewThousandsSeparator(responseJson.nilai_invoice,1,0));

        $("#currency_id_edit").val(responseJson.currency_id).trigger('change');
        $("#kurs_edit").val(responseJson.kurs);
        $("#kurs_edit_mask").val(viewThousandsSeparator(responseJson.kurs,1,0));
        $("#nilai_invoice_idr_edit").val(responseJson.nilai_invoice_idr);
        $("#nilai_invoice_idr_mask_edit").val(viewThousandsSeparator(responseJson.nilai_invoice_idr,0,0));
        
        $("#post_ket_tambahan").val(responseJson.ket_tambahan);

        $("#no_invoice_show").html(responseJson.no_invoice);
        $("#tgl_invoice_show").html(responseJson.tgl_invoice_custom);
        $("#no_vendor_show").html(responseJson.sapid?responseJson.sapid:'-');
        $("#vendor_show").html(responseJson.nama_vendor);
        $("#no_kontrak_show").html(responseJson.no_kontrak);
        $("#uraian_pekerjaan_show").html(responseJson.uraian_pekerjaan);
        $("#ket_tambahan_show").html(responseJson.ket_tambahan);
        $("#nilai_invoice_show").html(responseJson.nilai_invoice_formatted);
        $("#kurs_show").html(responseJson.kurs_formatted);
        $("#nilai_invoice_idr_show").html(responseJson.nilai_invoice_idr_formatted);

        $("#posisi_invoice_show").html(responseJson.disposisi_show);
        $("#checklist_status_show").html(responseJson.checklist_status);
        $("#status_payment_show").html(responseJson.is_status_payment);

        $("#group_reimburse_show").html(responseJson.group_reimburse);
        $("#no_arsip_show").html(responseJson.no_arsip);
        $("#sla_show").html(responseJson.sla.sla+' ( '+responseJson.sla.date+' )');
        $(".sla_date_show").html(responseJson.sla.date);
        $(".sla_total_hari_show").html(responseJson.sla.total_days);
        $(".sla_libur_nasional_show").html(responseJson.sla.national_days);
        $(".sla_weekend_show").html(responseJson.sla.weekdays);
        $(".sla_pending_show").html(responseJson.sla.pending);
        $(".sla_detail_show").html(responseJson.sla.daysleft);


        if(parseInt(responseJson.currency_id)>1){
            $(".panel-detail-kurs").show();
            $(".panel-kurs-edit").show();
        }else{
            $(".panel-detail-kurs").hide();
            $(".panel-kurs-edit").hide();
        }

        var tarif_ppn = responseJson.tarif_ppn?"("+responseJson.tarif_ppn+"%)":'';
        var tarif = responseJson.tarif_pph_formatted?"("+responseJson.tarif_pph_formatted+"%)":'';
        var jnpph = responseJson.jenis_pajak?responseJson.jenis_pajak:"PPH";
        //pajak
        $("#dpp_show").html(responseJson.dpp_formatted);
        $("#tarif_ppn_show").html(responseJson.ppn_type+" "+tarif_ppn);
        $("#nilai_pjk_ppn_show").html(responseJson.nilai_ppn_formatted);
        $("#pjk_pph_show").html(jnpph+tarif);
        $("#nilai_pjk_show").html(responseJson.nilai_pajak_formatted);

        $("#pinalty_show").html(responseJson.pinalty_formatted);
        $("#rounding_show").html(responseJson.rounding?viewThousandsSeparator(responseJson.rounding,1,0):'-');
        $("#netto_inv_show").html(responseJson.netto_formatted);

        if(responseJson.anggaran_verifikasi=='show'){
            $("#no_prk_show").html(responseJson.anggaran.no_prk);
            $("#uraian_prk_show").html(responseJson.anggaran.uraian);
            $("#klasifikasi_biaya_show").html(responseJson.anggaran.klasifikasi_biaya);
            $("#unit_show").html(responseJson.anggaran.unit);
            $("#nilai_invoice_ang_show").html(viewThousandsSeparator(responseJson.anggaran.nilai_invoice_idr,0,0));
            $("#catatan_lainnya_show").html(responseJson.anggaran.catatan);
            $("#download_attachment_show").html(responseJson.attachment);
            if(responseJson.anggaran.tipe=='Attachment'){
                $(".panel_attachment_ang").show();
                $(".panel_catatan_ang").hide();
            }else if(responseJson.anggaran.tipe=='Catatan Lainnya'){
                $(".panel_attachment_ang").hide();
                $(".panel_catatan_ang").show();
            }else{
                $(".panel_attachment_ang").hide();
                $(".panel_catatan_ang").hide();
            }
            if(responseJson.anggaran.prk_id==9999){
                $(".panel_saldo_ako_terpotong").hide();
            }else{
                $(".panel_saldo_ako_terpotong").show();
            }
        }else{
            $("#no_prk_show").html("");
            $("#uraian_prk_show").html("");
            $("#klasifikasi_biaya_show").html("");
            $("#unit_show").html("");
            $("#nilai_invoice_ang_show").html("");
            $("#catatan_lainnya_show").html("");
            $("#download_attachment_show").html("");
            $(".panel_attachment_ang").hide();
            $(".panel_catatan_ang").hide();
            $(".panel_saldo_ako_terpotong").show();
        }

        if(responseJson.tahapan_id==7 && jv_verifikator=='true'){
            $(".btn_form_verifikator").show();
        }else{
            $(".btn_form_verifikator").hide();
        }

        $("#bank_show").html(responseJson.bank);
        $("#no_dok_bayar_show").html(responseJson.no_dokumen_bayar);
        $("#tgl_bayar_show").html(responseJson.tgl_bayar_formatted);
        $("#no_cek_show").html(responseJson.no_cek);
        
        $("#list_dokumen_show").html(responseJson.dokumen_html);
        $("#checklist_kelengkapan_show").html(responseJson.checklist_kelengkapan);

        $("#periode_show").html(responseJson.periode);
        $("#sap_show").html(responseJson.sap);
        $("#klasifikasi_invoice_show").html(responseJson.jenis_tagihan);
        $("#note_show").html(responseJson.note);
        $("#nama_bank_show").html(responseJson.nama_bank);
        $("#no_rekening_show").html(responseJson.no_rekening);
        $("#nama_rekening_show").html(responseJson.nama_rekening);
        
        HideButtonByAccessRole(responseJson.role,responseJson.tahapan_id);
        
        panel(show);
        
        if(responseJson.btn_disposisi=="show"){
            $(".btn_modal_disposisi_invoice").show();
            $(".btn_modal_edit_invoice").show();
            $(".btn_modal_add_dokumen").show();
            
        }else{
            $(".btn_modal_disposisi_invoice").hide();
            $(".btn_modal_edit_invoice").hide();
            $(".btn_modal_add_dokumen").hide();
        }

        if(responseJson.tahapan_id==16){
            $(".btn_modal_disposisi_invoice").hide();
            $(".btn_modal_add_dokumen").hide();
            $(".btn_modal_add_linkdokumen").hide();
            $(".btn_modal_edit_invoice").hide();
        }

        if(responseJson.tahapan_id==16 && jv_verifikasi_treasury=='true'){
            $(".btn_modal_add_dokumen").show();
            $(".btn_modal_add_linkdokumen").show();
        }
        /*else{
            if(responseJson.btn_update=="true"){
                $(".btn_modal_add_dokumen").show();
            }else{
                $(".btn_modal_add_dokumen").hide();
            }
        }*/

        if(responseJson.tahapan_id>=7 && parseInt(responseJson.netto)>0 && responseJson.periode!="" && responseJson.periode!='NULL'){
            $(".btn-print-form-verifikator").show();
        }else{
            $(".btn-print-form-verifikator").hide();
        }

        if(responseJson.tahapan_id>=12 && responseJson.tahapan_id<=16  && jv_verifikasi_treasury=='true'){
            if(responseJson.is_cancel_payment=='1'){
                $(".btn_cancel_payment").hide();
                $(".btn_pending_payment").hide();
            }
            /*else if(responseJson.is_cancel_payment=='2'){
                $(".btn_cancel_payment").show();
                $(".btn_pending_payment").hide();
            }*/
            else{
                $(".btn_cancel_payment").show();
                $(".btn_pending_payment").show();
            }
            $(".btn_invoice_no_arsip").show();
        }
        /*else if(responseJson.tahapan_id==16  && jv_verifikasi_treasury=='true' && responseJson.is_cancel_payment=='0'){
            $(".btn_cancel_payment").show();
            $(".btn_pending_payment").hide();
        }*/
        else{
            $(".btn_cancel_payment").hide();
            $(".btn_pending_payment").hide();
            $(".btn_invoice_no_arsip").hide();
        }

        if(responseJson.tahapan_id>=7 && responseJson.tahapan_id<=12 && jv_update_verifikasi_pajak=='true'){
            $(".btn_modal_update_verifikasi_pajak").show();
        }else{
            $(".btn_modal_update_verifikasi_pajak").hide();
        }

        if((responseJson.tahapan_id>=7 && responseJson.tahapan_id<=16) && (jv_update_verifikasi_anggaran=='true')){
            $(".btn_modal_update_verifikasi_anggaran").show();
            $(".btn_modal_ket_tambahan_invoice").show();
        }else{
            $(".btn_modal_update_verifikasi_anggaran").hide();
            $(".btn_modal_ket_tambahan_invoice").hide();
        }

        if((responseJson.tahapan_id>=6 && responseJson.tahapan_id<=16) && (jv_verifikasi_anggaran=='true')){
            $(".btn_modal_ket_tambahan_invoice").show();
        }else{
            $(".btn_modal_ket_tambahan_invoice").hide();
        }

        if(responseJson.tahapan_id==6){
            $(".btn_modal_verifikasi_pajak").show();
            $(".btn_modal_verifikasi_anggaran").show();
        }else{
            $(".btn_modal_verifikasi_pajak").hide();
            $(".btn_modal_verifikasi_anggaran").hide();
        }


        if(responseJson.tahapan_id==12 && jv_verifikasi_treasury=='true'){
            $(".btn_modal_verifikasi_treasury").show();
            $(".btn_invoice_selesai").show();
            $(".btn_modal_disposisi_invoice").hide();
        }else{
            $(".btn_modal_verifikasi_treasury").hide();
            $(".btn_invoice_selesai").hide();
        }


        //$(".btn_modal_add_dokumen").hide();
        $(".btn_modal_add_linkdokumen").hide();

        if(parseInt(responseJson.reimburse_id)>0){
            $(".panel-btn-reimburse").show();
            $(".panel-btn-verifikasi").hide();
            $(".btn_modal_edit_invoice").hide();
            $(".panel-group-reimburse").show();
            
        }else{
            $(".panel-btn-reimburse").hide();
            $(".panel-btn-verifikasi").show();
            $(".panel-group-reimburse").hide();
        }

        if(responseJson.is_cancel_payment=='1'){
            $(".btn_modal_verifikasi_treasury").hide();
            $(".btn_modal_update_verifikasi_treasury").hide();
            $(".btn_cancel_payment").hide();
            $(".btn_pending_payment").hide();
            $(".btn_invoice_no_arsip").hide();
            $(".btn_invoice_selesai").hide();
            $(".btn_modal_add_dokumen").hide();
        }
    
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}




var _submitForm = function () {
    FormValidation.formValidation(
        document.getElementById('form_invoice'),
        {
            fields: {
                no_invoice: {
                    validators: {
                        notEmpty: {
                            message: 'No. Invoice harus diisi'
                        }
                    }
                },
                tgl_invoice: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal harus diisi'
                        }
                    }
                },
                vendor_add: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Vendor harus diisi'
                        }
                    }
                },
                no_kontrak: {
                    validators: {
                        notEmpty: {
                            message: 'No Kontrak harus diisi'
                        }
                    }
                },
                uraian_pekerjaan: {
                    validators: {
                        notEmpty: {
                            message: 'Uraian Pekerjaan harus diisi'
                        }
                    }
                },
                currency_id: {
                    validators: {
                        notEmpty: {
                            message: 'Mata Uang harus diisi'
                        }
                    }
                },
                kurs: {
                    validators: {
                        notEmpty: {
                            message: 'Kurs harus diisi'
                        }
                    }
                },
                nilai_invoice: {
                    validators: {
                        notEmpty: {
                            message: 'Nilai Invoice harus diisi'
                        }
                    }
                },
                nilai_invoice_idr: {
                    validators: {
                        notEmpty: {
                            message: 'Nilai Invoice IDR harus diisi'
                        }
                    }
                },
                link_invoice: {
                    validators: {
                        notEmpty: {
                            message: 'Link harus diisi'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {

        var formdata = new FormData(); 
        var formdata = new FormData($('#form_invoice')[0]);

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
        
                // Upload progress
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        Swal.fire({
                            title: 'Harap tunggu!',
                            html: `<progress value="${Math.round(percentComplete*100)}" max="100" style="width:300px;"></progress><br>${Math.round(percentComplete*100)}% Completed.`,// add html attribute if you want or remove
                            allowOutsideClick: false,
                            buttonsStyling: false, 
                            showClass: {
                                backdrop: 'swal2-noanimation', // disable backdrop animation
                                popup: '',                     // disable popup animation
                                icon: ''                       // disable icon animation
                            },
                            hideClass: {
                                popup: '',                     // disable popup fade-out animation
                            },
                            willOpen: () => {
                                Swal.showLoading()
                            },
                            showConfirmButton: false,
                        });
                    }
               }, false);
        
               return xhr;
            },
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url        : "invoices/submit",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(result){
                let response = result;
                if(response.success==='true'){
                    
                    $('#InvoiceID').val(response.InvoiceID);
                    ResetForm();
                    panel("grid");
                    $('#tbl_invoice').DataTable().ajax.reload( null, false );
                    $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                    
                    Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                        timer: 1500
                    });
                    
                }else{
                    Swal.fire({
                        title: "Peringatan!",
                        text: response.message,
                        //text: "Verifikasi gagal !",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    });
                }
            },
            error: function(result){
                Swal.fire({
                    title: "Peringatan!",
                    text: result.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
        });

    });
}


var _submitEditInvoice = function () {
    FormValidation.formValidation(
        document.getElementById('form-edit-invoice'),
        {
            fields: {
                no_invoice_edit: {
                    validators: {
                        notEmpty: {
                            message: 'No. Invoice harus diisi'
                        }
                    }
                },
                tgl_invoice_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal harus diisi'
                        }
                    }
                },
                vendor_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Vendor harus diisi'
                        }
                    }
                },
                no_kontrak_edit: {
                    validators: {
                        notEmpty: {
                            message: 'No Kontrak harus diisi'
                        }
                    }
                },
                uraian_pekerjaan_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Uraian Pekerjaan harus diisi'
                        }
                    }
                },
                nilai_invoice_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Nilai Invoice harus diisi'
                        }
                    }
                },
                currency_id_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Mata Uang harus diisi'
                        }
                    }
                },
                kurs_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Kurs harus diisi'
                        }
                    }
                },
                nilai_invoice_edit_idr: {
                    validators: {
                        notEmpty: {
                            message: 'Nilai Invoice IDR harus diisi'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {
        
        FormValidation.utils.fetch('invoices/update', {
            method: 'POST',
            params: {
                id: $('#InvoiceID').val(),
                no_invoice: $('#no_invoice_edit').val(),
                tgl_invoice: $('#tgl_invoice_edit').val(),
                vendor: $('#vendor_edit').val(),
                no_kontrak: $('#no_kontrak_edit').val(),
                uraian_pekerjaan: $('#uraian_pekerjaan_edit').val(),
                nilai_invoice: $('#nilai_invoice_edit').val(),
                nilai_invoice_idr: $('#nilai_invoice_idr_edit').val(),
                kurs: $('#kurs_edit').val(),
                currency_id: $('#currency_id_edit').val(),
                savevendor: $('input[name=savevendoredit]:checked').val(),
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#InvoiceID').val(response.id);
                //ResetForm();
                setupForm(response.id,'detail');
                //panel("detail");
                $('#EditInvoice').modal('hide');

                $('#tbl_invoice').DataTable().ajax.reload( null, false );
                $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                Swal.fire({
                    title: "Sukses!",
                    text: response.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    },
                    timer: 1500
                });
                

            }else{
                Swal.fire({
                    title: "Peringatan!",
                    text: response.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
            return false;
        });

    });
}

function _submitFormDokumen(){
  
    var formdataDoc = new FormData(); 

    formdataDoc = new FormData($('#form_upload_dokumen_invoice')[0]);

    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
    
            // Upload progress
            xhr.upload.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    Swal.fire({
                        title: 'Harap tunggu!',
                        html: `<progress value="${Math.round(percentComplete*100)}" max="100" style="width:300px;"></progress><br>${Math.round(percentComplete*100)}% Completed.`,// add html attribute if you want or remove
                        allowOutsideClick: false,
                        buttonsStyling: false, 
                        showClass: {
                            backdrop: 'swal2-noanimation', // disable backdrop animation
                            popup: '',                     // disable popup animation
                            icon: ''                       // disable icon animation
                        },
                        hideClass: {
                            popup: '',                     // disable popup fade-out animation
                        },
                        willOpen: () => {
                            Swal.showLoading()
                        },
                        showConfirmButton: false,
                    });
                }
           }, false);
    
           return xhr;
        },
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/submit-dokumen",
        type       : 'POST',
        contentType: false,
        cache      : false,
        processData: false,
        data       : formdataDoc,
        success: function(response){
            if(response.success==='true'){
                setupForm(response.InvoiceID,'detail');
                $('#UploadDokumenInvoice').modal('hide');
                
                Swal.fire({
                    title: "Sukses!",
                    text: response.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    },
                    timer: 1500
                });
                
            }else{
                Swal.fire({
                    title: "Peringatan!",
                    text: response.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
        },
        error: function(result){
            Swal.fire({
                title: "Peringatan!",
                text: result.message,
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }
    });

}

function _getDataVerifikasi(){
    var InvoiceID = $('#InvoiceID').val();
    ResetFormVerifikasi();
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/data-verifikasi",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'InvoiceID='+InvoiceID,
        success: function(resp){
            
            //$('#show_tbl_prk').html("");
            $('#next_tahapan').val(resp.next.id);
            //$('#kepada_show').html(resp.next.label);
            $('#kepada_show').html(resp.role_label);
            
            $('#nilai_netto_treasury_show').val(resp.netto_formatted);
            $('#prk_id').html(resp.combo_prk);
            $('#bank_id').html(resp.combo_bank);
            $("#nilai_invoice_verifikasi_show").val(resp.nilai_invoice_formatted);
            $("#nilai_invoice_pjk").val(resp.nilai_invoice);

            $('#show_tbl_prk').html("");
            $('#fv_show_tbl_prk').html("");
            
            if(resp.role=='show'){
                $('#is_verifikasi1').prop('checked', false);
                $('.radio_verikasiNo').show();
            }else{
                $('#is_verifikasi1').prop('checked', true);
                $('.radio_verikasiNo').hide();
            }
 
            
        },
        error: function(result){
            Swal.fire({
                title: "Peringatan!",
                text: result.message,
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }
    });

}

function SubmitVerifikasix(){
  
    var formdata = new FormData(); 
    
    var verifikasi = $('input[name=is_verifikasi]:checked').val();
    var keterangan_disposisi_id = $('#keterangan_disposisi_id').val();

    formdata.append("InvoiceID",  $('#InvoiceID').val());
    formdata.append("verifikasi", verifikasi);
    formdata.append("next_tahapan", $('#next_tahapan').val());
    formdata.append("keterangan_disposisi", keterangan_disposisi_id);
    formdata.append("bidang_id", $('#bidang_id').val());
    formdata.append("keterangan_dikembalikan", $('#keterangan_dikembalikan').val());
    formdata.append("keterangan_verifikasi", $('#keterangan_verifikasi').val());

    // verifikasi pajak
    formdata.append("dpp", $('#dpp').val());
    formdata.append("tarif_ppn", $('#tarif_pjk_ppn').val());
    formdata.append("nilai_pajak_ppn", $('#nilai_pajak_ppn').val());
    formdata.append("pph_id", $('#pph_id').val());
    formdata.append("tarif_pjk_pph", $('#tarif_pjk_pph').val());
    formdata.append("nilai_pajak_pph", $('#nilai_pajak_pph').val());

    // verifikasi anggaran
    formdata.append("klasifikasi_biaya_id", $('#klasifikasi_biaya_id').val());
    formdata.append("unit", $('#unit').val());
    formdata.append("prk_id", $('#prk_id').val());

    // verifikasi treasury
    formdata.append("bank_id", $('#bank_id').val());
    formdata.append("no_dokumen_bayar", $('#no_dokumen_bayar').val());
    formdata.append("tgl_bayar_invoice", $('#tgl_bayar_invoice').val());
    formdata.append("no_cek", $('#no_cek').val());


    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/submit-verifikasi",
        type       : 'POST',
        contentType: false,
        cache      : false,
        processData: false,
        data       : formdata,
        success: function(response){
            if(response.success==='true'){
                
                setupForm(response.id,'detail');
                document.getElementById("form_verifikasi_invoice").reset();
                $('#VerifikasiInvoice').modal('hide');

                $('#tbl_invoice').DataTable().ajax.reload( null, false );
                $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                
                ResetFormVerifikasi();

                Swal.fire({
                    title: "Sukses!",
                    text: response.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    },
                    timer: 1500
                });
                
            }else{
                Swal.fire({
                    title: "Peringatan!",
                    text: response.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
        },
        error: function(result){
            Swal.fire({
                title: "Peringatan!",
                text: result.message,
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }
    });

}

var SubmitVerifikasi = function () {
    //$('#btn-submit-verifikasi').html("menyimpan .... <span class='spinner spinner-white'></span>.");
    FormValidation.formValidation(
        document.getElementById('form_verifikasi_invoice'),
        {
            
            fields: {
                is_verifikasi: {
                    validators: {
                        notEmpty: {
                            message: 'disposisi/teruskan harus dipilih'
                        }
                    }
                },
                keterangan_disposisi_id: {
                    validators: {
                        notEmpty: {
                            message: 'Keterangan disposisi harus diisi'
                        }
                    }
                },
                
               
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        },
    ).on('core.form.valid', function() {
        
        var formdata = new FormData(); 
    
        var verifikasi = $('input[name=is_verifikasi]:checked').val();
        var keterangan_disposisi_id = $('#keterangan_disposisi_id').val();
    
        formdata.append("InvoiceID",  $('#InvoiceID').val());
        formdata.append("verifikasi", verifikasi);
        formdata.append("next_tahapan", $('#next_tahapan').val());
        formdata.append("keterangan_disposisi", keterangan_disposisi_id);
        formdata.append("bidang_id", $('#bidang_id').val());
        formdata.append("keterangan_dikembalikan", $('#keterangan_dikembalikan').val());
        formdata.append("kendala", $('#kendala').val());
        formdata.append("keterangan_verifikasi", $('#keterangan_verifikasi').val());
    
        if(verifikasi=='0' && $('#bidang_id').val()==""){
            //$('#bidang_id').class('is-invalid');
            $('.error_bidang').text('Harus pilih tujuan kembalikan/konfirmasi dokumen');
        }
        else if(verifikasi=='0' && $('#keterangan_dikembalikan').val()==""){
            $('.error_keterangan_dikem').text('Harus pilih Keterangan kembalikan/konfirmasi dokumen');
        }
        else if(verifikasi=='0' && $('#kendala').val()==""){
            $('.error_kendala').text('Harus pilih kendala');
        }
        else{
            $.ajax({
                headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url        : "invoices/submit-verifikasi",
                type       : 'POST',
                contentType: false,
                cache      : false,
                processData: false,
                data       : formdata,
                success: function(response){
                    if(response.success==='true'){
                        
                        setupForm(response.id,'detail');
                        document.getElementById("form_verifikasi_invoice").reset();
                        $('#VerifikasiInvoice').modal('hide');
    
                        $('#btn-submit-verifikasi').html("Kirim <i class='flaticon-paper-plane'></i>");
    
                        $('#tbl_invoice').DataTable().ajax.reload( null, false );
                        $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                        
                        GetInboxInvoice();
                        
                        ResetFormVerifikasi();
        
                        Swal.fire({
                            title: "Sukses!",
                            text: response.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            },
                            timer: 1500
                        });
                        
                    }else{
                        Swal.fire({
                            title: "Peringatan!",
                            text: response.message,
                            icon: "warning",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-warning"
                            }
                        });
                    }
                },
                error: function(result){
                    Swal.fire({
                        title: "Peringatan!",
                        text: result.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    });
                }
            });
        }
       

    });
}

async function setupRiwayat(id){
    const response = await fetch('invoices/history', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            id: id
        })
    });
    let responseJson = await response.json();
    if(responseJson.id!=''){
        
        $("#printinvid").val(responseJson.InvoiceIDEnc);
        $("#exportinvid").val(responseJson.InvoiceIDEnc);
        $("#no_invoice_rw").html(responseJson.no_invoice);
        $("#tgl_invoice_rw").html(responseJson.tgl_invoice_custom);
        $("#no_vendor_rw").html(responseJson.sapid?responseJson.sapid:'-');
        $("#vendor_rw").html(responseJson.nama_vendor);
        $("#no_kontrak_rw").html(responseJson.no_kontrak);
        $("#uraian_pekerjaan_rw").html(responseJson.uraian_pekerjaan);
        $("#nilai_invoice_rw").html(responseJson.nilai_invoice_formatted);

        $("#created_rw").html(responseJson.created+" ("+responseJson.created_date+")");
        $("#updated_rw").html(responseJson.updated);
        $("#sla_rw").html(responseJson.sla.sla+' ( '+responseJson.sla.date+' )');
        $("#detail_sla_rw").html(responseJson.detail_sla);
        $("#list_riwayat_show").html(responseJson.history_table);
        
        //--//
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}


async function ComboKlasifikasiBiaya(parent_id=""){
    let response = await fetch('invoices/combo/klasifikasi-biaya', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            parent_id:parent_id
        })
    });
    let responseText = await response.text();
    if(responseText!=''){
        
        $('#klasifikasi_biaya_id').html(responseText);
        $('#fv_klasifikasi_biaya_id').html(responseText);

    }
}

function _getSaldoPRK(InvoiceID,PrkID){
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/saldo-prk",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'InvoiceID='+InvoiceID+"&PrkID="+PrkID,
        success: function(resp){
            // if(resp.btn_save=='hide'){
            //     $('#btn-submit-verifikasi-anggaran').hide();
            // }else{
            //     $('#btn-submit-verifikasi-anggaran').show();
            // }
            $('#show_tbl_prk').html(resp.table_saldo_ako);
            $('#fv_show_tbl_prk').html(resp.table_saldo_ako);
        },
        error: function(result){
            Swal.fire({
                title: "Peringatan!",
                text: result.message,
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }
    });

}


function _getChecklistKlasifikasiInvoice(KateInvoice,InvoiceID){
    
    $('.spin-klasifikasi-invoice').show();
    $('#show_tbl_checklist_dokumen').html("");
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/checklist-kategori-invoice",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'InvoiceID='+InvoiceID+"&JenisTagihan="+KateInvoice,
        success: function(resp){
            $('.spin-klasifikasi-invoice').hide();
            $('#show_tbl_checklist_dokumen').html(resp);
            sum_data(KateInvoice);
        },
        error: function(result){
            Swal.fire({
                title: "Peringatan!",
                text: result.message,
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }
    });

}

async function setupFormVerifikator(id=""){
    const response = await fetch('invoices/show', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            id: id
        })
    });
    let responseJson = await response.json();
    if(responseJson.id!=''){
        ResetFormVerifikator();
        //--//
        
        $("#InvoiceIDFV").val(responseJson.id);
        $("#vendor_ver").val(responseJson.nama_vendor);
        $("#no_kontrak_ver").val(responseJson.no_kontrak);
        $("#uraian_pekerjaan_ver").val(responseJson.uraian_pekerjaan);
        $("#periode").val(responseJson.periode);
        $("#sap").val(responseJson.sap);
        $("#kategori_invoice").val(responseJson.jenis_tagihan).trigger('change');

        $("#note_ver").val(responseJson.note);
        $("#nama_bank_ver").val(responseJson.nama_bank);
        $("#norek_ver").val(responseJson.no_rekening);
        $("#nama_rekening_ver").val(responseJson.nama_rekening);
       
        $("#tagihan_ver_show").val(responseJson.nilai_invoice_formatted);
        $("#tagihan_ver").val(responseJson.nilai_invoice);
        $("#dpp_ver_show").val(responseJson.dpp_formatted);
        $("#dpp_ver").val(responseJson.dpp);

        if(parseInt(responseJson.tarif_ppn)>0){
            $("#tarif_ppn_ver_show").html("("+responseJson.tarif_ppn+"%)");
        }
        
        $("#pajak_ppn_ver_show").val(responseJson.nilai_ppn_formatted);
        $("#pajak_ppn_ver").val(responseJson.nilai_ppn);
        
        var jenis_pajak = "PPH";
        if(parseInt(responseJson.tarif)>0){
            jenis_pajak = responseJson.jenis_pajak+" ("+responseJson.tarif+"%)";
        }

        $("#is_min_ver").val(responseJson.is_min);
        $("#pph_id_ver").val(responseJson.pajak_id);

        $("#jenis_pajak_ver_show").html(jenis_pajak);
        $("#pajak_ver_show").val(responseJson.nilai_pajak_formatted);
        $("#pajak_ver").val(responseJson.nilai_pajak);

        $("#pinalti_ver").val(responseJson.pinalty);
        $("#pinalti_ver_mask").text(responseJson.pinalty);
        $("#rounding_ver").val(responseJson.rounding);
        $("#rounding_ver_mask").text(viewThousandsSeparator(responseJson.rounding,responseJson.digit,0));

        let nilai_ppn = parseFloat(responseJson.nilai_ppn);
        let nilai_pph = parseFloat(responseJson.nilai_pajak);

        if(responseJson.id_min==0){
            nilai_ppn = 0;
        }
        if(responseJson.pajak_id==100){
            nilai_pph = 0;
        }

        let nilai_netto = parseFloat(responseJson.nilai_invoice)-(nilai_ppn+nilai_pph);
        var netto_format = responseJson.netto?responseJson.netto:nilai_netto;
        var netto = responseJson.netto?responseJson.netto:nilai_netto.toFixed(responseJson.digit);
        $("#netto_ver_show").val(viewThousandsSeparator(netto_format,responseJson.digit,0));
        $("#netto_ver").val(netto);
        $("#select_rekening").html(responseJson.combo_rekening);

        setupSysTtd(id);
     
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}

var _submitFormVerifikator = function () {
    FormValidation.formValidation(
        document.getElementById('form_verifikator_invoice'),
        {
            fields: {
                periode: {
                    validators: {
                        notEmpty: {
                            message: 'Periode harus diisi'
                        }
                    }
                },
                sap: {
                    validators: {
                        notEmpty: {
                            message: 'SAP harus diisi'
                        }
                    }
                },
                kategori_invoice: {
                    validators: {
                        notEmpty: {
                            message: 'Klasifikasi Invoice harus dipilih'
                        }
                    }
                },
                nama_bank_ver: {
                    validators: {
                        notEmpty: {
                            message: 'Nama bank harus diisi'
                        }
                    }
                },
                norek_ver: {
                    validators: {
                        notEmpty: {
                            message: 'No. rekening harus diisi'
                        }
                    }
                },
                nama_rekening_ver: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Rekening harus diisi'
                        }
                    }
                },
                mengetahui_nama: {
                    validators: {
                        notEmpty: {
                            message: 'Nama harus diisi'
                        }
                    }
                },
                mengetahui_jabatan: {
                    validators: {
                        notEmpty: {
                            message: 'Jabatan harus diisi'
                        }
                    }
                },
                menyetujui_nama: {
                    validators: {
                        notEmpty: {
                            message: 'Nama harus diisi'
                        }
                    }
                },
                menyetujui_jabatan: {
                    validators: {
                        notEmpty: {
                            message: 'Jabatan harus diisi'
                        }
                    }
                },
               
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {

        var formdataVer = new FormData(); 
        var formdataVer = new FormData($('#form_verifikator_invoice')[0]);

        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url         : url_submit_verifikator_inv,
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdataVer,
            success: function(result){
                let response = result;
                if(response.success==='true'){
                    $('#InvoiceID').val(response.InvoiceID);
                    ResetForm();
                    //panel("detail");
                    setupForm(response.InvoiceID,'detail');
                    $('#tbl_invoice').DataTable().ajax.reload( null, false );
                    $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );

                    Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                        timer: 1500
                    });
                    
                }else{
                    Swal.fire({
                        title: "Peringatan!",
                        text: response.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    });
                }
            },
            error: function(result){
                Swal.fire({
                    title: "Peringatan!",
                    text: result.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
        });

    });
}

function sum_data(value){
    var id = [];
    var rows = document.getElementsByName('is_check[]');
     
     var selectedRows = [];
     for (var i = 0, l = rows.length; i < l; i++) {
         if (rows[i].checked) {
             selectedRows.push(rows[i]);
             //spb = rows[i].id.split("&");
             id.push(rows[i].id);
         }
     }
     //console.log(id.join());
     $('#is_checked').val(id.join());

}

function ResetFormLink(){
    document.getElementById("form_upload_link_invoice").reset();
    $("#link_invoice_edit").val("");
    $("#linkname_invoice_edit").val("");
}

var _submitFormLink = function () {
    FormValidation.formValidation(
        document.getElementById('form_upload_link_invoice'),
        {
            fields: {
                link_invoice_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Link harus diisi'
                        },
                        uri: {
                            message: 'link tidak valid'
                        }
                    }
                },
                linkname_invoice_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Keterangan harus diisi'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {

        var formdataVer = new FormData(); 
        formdataVer.append("InvoiceID",  $('#InvoiceID').val());
        formdataVer.append("DocID", $('#LinkID').val());
        formdataVer.append("link", $('#link_invoice_edit').val());
        formdataVer.append("keterangan", $('#linkname_invoice_edit').val());

        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //url        : "invoices/submit-link",
            url        : url_submit_link_inv,
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdataVer,
            success: function(result){
                let response = result;
                if(response.success==='true'){
                    $('#InvoiceID').val(response.InvoiceID);
                    ResetFormLink();
                    setupForm(response.InvoiceID,'detail');
                    //$('#tbl_invoice').DataTable().ajax.reload( null, false );
                    $('#UploadLinkInvoice').modal('hide');

                    Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                        timer: 1500
                    });
                    
                }else{
                    Swal.fire({
                        title: "Peringatan!",
                        text: response.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    });
                }
            },
            error: function(result){
                Swal.fire({
                    title: "Peringatan!",
                    text: result.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
        });

    });
}

function _getSaldoBank(BankID,ver="inv"){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "saldo/saldo-bank",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'BankID='+BankID,
        success: function(resp){
            var sisa_saldo = 0;
            if(ver=="grouping"){
                $('#gr_saldo_bank_show').html(resp.saldo);
                var nilai = $('#total_nilai_tagihan_pembayaran').val();
                if(parseFloat(nilai)>parseFloat(resp.saldo_ori)){
                    $('#gr_warning_saldo_bank').text("Saldo tidak mencukupi.");
                    $('#btn-submit-grouping-treasury').hide();
                }else{
                    $('#gr_warning_saldo_bank').text("");
                    $('#btn-submit-grouping-treasury').show();
                }
            }
            else if(ver=="grouping_up"){
                $('#gr_saldo_bank_show_up').html(resp.saldo);

                var bank_id = $('#gr_bank_id_up_hidden').val();
                var nilai_hid = parseFloat($('#total_nilai_tagihan_up_hidden').val());
                
                if(parseInt(bank_id)>0 && parseInt(bank_id)==parseInt(BankID)){
                    sisa_saldo = resp.saldo_ori+nilai_hid;
                    
                    if(nilai_hid>sisa_saldo){
                        $('#btn-update-grouping-treasury').hide();
                        $('#gr_warning_saldo_bank_up').html("Saldo tidak mencukupi.");
                    }else{
                        $('#btn-update-grouping-treasury').show();
                        $('#gr_warning_saldo_bank_up').html("");
                    }
                }else{
                    if(nilai_hid>resp.saldo_ori){
                        $('#btn-update-grouping-treasury').hide();
                        $('#gr_warning_saldo_bank_up').html("Saldo tidak mencukupi.");
                    }else{
                        $('#btn-update-grouping-treasury').show();
                        $('#gr_warning_saldo_bank_up').html("");
                    }
                }
            }
            else{
                $('#saldo_bank_show').html(resp.saldo);
                $('#fv_saldo_bank_show').html(resp.saldo);

                var bank_id = $('#fv_bank_id_treasury_hidden').val();
                var netto_hid = parseFloat($('#fv_nilai_netto_treasury_hidden').val());
                
                if(parseInt(bank_id)>0 && parseInt(bank_id)==parseInt(BankID)){
                    sisa_saldo = resp.saldo_ori+netto_hid;
                    
                    if(netto_hid>sisa_saldo){
                        $('#btn-submit-verifikasi-treasury').hide();
                        $('.warning_saldo_bank_minus').html("Saldo tidak mencukupi.");
                    }else{
                        $('#btn-submit-verifikasi-treasury').show();
                        $('.warning_saldo_bank_minus').html("");
                    }
                }else{
                    if(netto_hid>resp.saldo_ori){
                        $('#btn-submit-verifikasi-treasury').hide();
                        $('.warning_saldo_bank_minus').html("Saldo tidak mencukupi.");
                    }else{
                        $('#btn-submit-verifikasi-treasury').show();
                        $('.warning_saldo_bank_minus').html("");
                    }
                }
            }
            
            //if(parseFloat(resp.saldo)>0){
                //$('#btn-submit-verifikasi-treasury').show();
                //$('.warning_saldo_bank').html("");
            //}else{
                //$('.warning_saldo_bank').html("Harap segera isi saldo bank tersebut!");
                //$('#btn-submit-verifikasi-treasury').hide();   
            //}
        },
        error: function(result){
            Swal.fire({
                title: "Peringatan!",
                text: result.message,
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }
    });

}

function ResetFormUpdateDokumen(){
    document.getElementById("form_update_dokumen_invoice").reset();
    $("#file_invoice_edit").val("");
    $("#keterangan_dok_edit").val("");
}

var SubmitFormUpdateDokumen = function () {
    FormValidation.formValidation(
        document.getElementById('form_update_dokumen_invoice'),
        {
            fields: {
                file_invoice_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Dokumen harus diisi'
                        },
                    }
                },
                keterangan_dok_edit: {
                    validators: {
                        notEmpty: {
                            message: 'Keterangan harus diisi'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {

        var formdataDoc = new FormData(); 
        var dokumen = document.getElementById("file_invoice_edit").files[0];
        var InvoiceID = $('#InvoiceID').val();
        formdataDoc.append("InvoiceID",  InvoiceID);
        formdataDoc.append("DocID", $('#DocIDEdit').val());
        formdataDoc.append("dokumen", dokumen);
        formdataDoc.append("keterangan", $('#keterangan_dok_edit').val());

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
        
                // Upload progress
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        Swal.fire({
                            title: 'Harap tunggu!',
                            html: `<progress value="${Math.round(percentComplete*100)}" max="100" style="width:300px;"></progress><br>${Math.round(percentComplete*100)}% Completed.`,// add html attribute if you want or remove
                            allowOutsideClick: false,
                            buttonsStyling: false, 
                            showClass: {
                                backdrop: 'swal2-noanimation', // disable backdrop animation
                                popup: '',                     // disable popup animation
                                icon: ''                       // disable icon animation
                            },
                            hideClass: {
                                popup: '',                     // disable popup fade-out animation
                            },
                            willOpen: () => {
                                Swal.showLoading()
                            },
                            showConfirmButton: false,
                        });
                    }
               }, false);
        
               return xhr;
            },
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url        : "invoices/update-dokumen",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdataDoc,
            success: function(result){
                let response = result;
                if(response.success==='true'){
                    $('#InvoiceID').val(InvoiceID);
                    ResetFormUpdateDokumen();
                    setupForm(InvoiceID,'detail');
                    $('#UpdateDokumenInvoice').modal('hide');

                    Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                        timer: 1500
                    });
                    
                }else{
                    Swal.fire({
                        title: "Peringatan!",
                        text: response.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    });
                }
            },
            error: function(result){
                Swal.fire({
                    title: "Peringatan!",
                    text: result.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
        });

    });
}

function hitungNetto(){
    let digit = $("#digit").val();
    let is_min = $("#is_min_ver").val();
    let pph_id = $("#pph_id").val();
    let pinalti = $('#pinalti_ver').val()?$('#pinalti_ver').val():0;
    let rounding = $('#rounding_ver').val()?$('#rounding_ver').val():0;
    let tagihan = $("#tagihan_ver").val();
    let pajak_ppn_ver = $("#pajak_ppn_ver").val();
    let pajak_ver = $("#pajak_ver").val();
    
    $("#pinalti_ver_mask").text(viewThousandsSeparator(pinalti,digit,0));
    $("#rounding_ver_mask").text(viewThousandsSeparator(rounding,digit,0));

    if(is_min==0){
        pajak_ppn_ver = 0;
    }

    if(pph_id==100){
        pajak_ver = 0;
    }

    let netto = parseFloat(tagihan)-(parseFloat(pajak_ppn_ver)+parseFloat(pajak_ver)+parseFloat(pinalti))-(rounding);
    
    $("#netto_ver_show").val(viewThousandsSeparator(netto,digit,0));
    $("#netto_ver").val(netto.toFixed(digit));
}


jQuery(document).ready(function() {

    KTDatatablesInvoice.init();
    var digit = $("#digit").val();
    $(".btn-add-invoice").click(function() {
        panel("form");
        ResetForm();
        //comboVendor('add','');
    });
    $(".btn_modal_edit_invoice").click(function() {
        var id =$("#InvoiceID").val();
        //comboVendor('update',id);
    });
    
    $(".add-new-dokumen-invoice").click(function() {
        ResetFormDokumen();
    });

    $(".btn-back-invoice").click(function() {
        panel("grid");
    });

    $(".btn-backtodetail-invoice").click(function() {
        var id = $("#InvoiceID").val();
        setupForm(id,'detail');
    });

    $("#btn-submit-edit-invoice").click(function() {
        _submitEditInvoice();
    });

    $(".btn-save-form-invoice").one('click',function() {
        _submitForm();
    });

    $(".btn-save-form-verifikator").one('click',function() {
        _submitFormVerifikator();
    });

    $(document).on('click', '.btn_detail_invoice', function() {
        var id = $(this).attr('uid');
        setupForm(id,'detail');
    });

    $(document).on('click', '.btn_riwayat_invoice', function() {
        var id = $(this).attr('uid');
        setupRiwayat(id);
    });
    
    $("#btn-submit-dokumen").one('click',function() {
        _submitFormDokumen();
    });
    
    $(document).on('click', '#btn-submit-update-dokumen', function() {
        SubmitFormUpdateDokumen();
    });
    $("#btn-submit-link-dokumen").one('click',function() {
        _submitFormLink();
    });

    $("#btn-submit-verifikasix").one('click',function() {
        SubmitVerifikasi();
    });

    $("#btn-submit-verifikasi").one('click',function() {
        SubmitVerifikasi();
    });
   

    $(document).on('click', '.modal_verifikasi_invoice', function() {
        _getDataVerifikasi();
        //ComboKlasifikasiBiaya();
    });

    $(document).on('click', '.btn_form_verifikator', function() {
        panel("form_verifikator");
        var InvID = $("#InvoiceID").val();
        setupFormVerifikator(InvID);
    });

    $("#kurs").keyup(function(){
        let kurs = $(this).val();
        let nilai_inv = $("#nilai_invoice").val();
        const nilai_inv_idr = parseFloat(kurs)*parseFloat(nilai_inv);
        $("#kurs_mask").val(viewThousandsSeparator(kurs,2,0));
        $("#nilai_invoice_idr").val(nilai_inv_idr);
        $("#nilai_invoice_idr_mask").val(viewThousandsSeparator(nilai_inv_idr,2,0));
    });

    $("#nilai_invoice").keyup(function(){
        let nilai = $(this).val();
        $("#nilai_invoice_mask").val(viewThousandsSeparator(nilai,2,0));

        let kurs = $("#kurs").val();
        const nilai_inv_idr = parseFloat(kurs)*parseFloat(nilai);
        $("#nilai_invoice_idr").val(nilai_inv_idr);
        $("#nilai_invoice_idr_mask").val(viewThousandsSeparator(nilai_inv_idr,2,0));
        $("#nilai_invoice_currency_view").html(viewThousandsSeparator(nilai,2,0));
        
    });

    $("#nilai_invoice_idr").keyup(function(){
        let nilai = $(this).val();
        $("#nilai_invoice_idr_mask").val(viewThousandsSeparator(nilai,2,0));
    });
    

    $("#kurs_edit").keyup(function(){
        let kurse = $(this).val();
        let nilai_inve = $("#nilai_invoice_edit").val();
        const nilai_inv_idre = parseFloat(kurse)*parseFloat(nilai_inve);
        $("#kurs_edit_mask").val(viewThousandsSeparator(kurse,2,0));
        $("#nilai_invoice_idr_edit").val(nilai_inv_idre);
        $("#nilai_invoice_idr_mask_edit").val(viewThousandsSeparator(nilai_inv_idre,2,0));
    });

    $("#nilai_invoice_edit").keyup(function(){
        let nilai = $(this).val();
        $("#nilai_invoice_mask_edit").val(viewThousandsSeparator(nilai,2,0));

        let kurs = $("#kurs_edit").val();
        const nilai_inv_idre = parseFloat(kurs)*parseFloat(nilai);
        $("#nilai_invoice_idr_edit").val(nilai_inv_idre);
        $("#nilai_invoice_idr_mask_edit").val(viewThousandsSeparator(nilai_inv_idre,2,0));
    });

    $("#nilai_invoice_idr_edit").keyup(function(){
        let nilai = $(this).val();
        $("#nilai_invoice_idr_mask_edit").val(viewThousandsSeparator(nilai,2,0));
    });

    $("#tipe_dpp").change(function(){
        let tipe_dpp = $(this).val();
        let dpp = 0;
        let nilai_invoice = $("#nilai_invoice_pjk").val();
        if(tipe_dpp=='rumus10'){
            dpp = (100/110)*nilai_invoice;
            $("#dpp").val(dpp.toFixed(2));
            $("#dpp_mask").val(viewThousandsSeparator(dpp,1,0));
        }else if(tipe_dpp=='rumus11'){
            dpp = (100/111)*nilai_invoice;
            $("#dpp").val(dpp.toFixed(2));
            $("#dpp_mask").val(viewThousandsSeparator(dpp,1,0));
        }
        else{
            $("#dpp").val("");
            $("#dpp_mask").val("");
        }
        
    });

    $("#dpp").keyup(function(){
        let dpp = $(this).val()?$(this).val():0;
        let tarif = $("#tarif_pjk").val();

        $("#dpp_mask").val(viewThousandsSeparator(dpp,1,0));

        let tarifPjk = tarif?tarif:0;
        let nilai_pjk = parseFloat(dpp)*(parseFloat(tarifPjk)/100);
        $("#nilai_pajak_show").val(viewThousandsSeparator(nilai_pjk,1,0));
        $("#nilai_pajak").val(nilai_pjk.toFixed(2));
    });

    $("#tarif_pjk_pph").keyup(function(){
        let tarifPjk = $(this).val()?$(this).val():0;
        let dpp = $("#dpp").val()?$("#dpp").val():0;

        let nilai_pjk = parseFloat(dpp)*(parseFloat(tarifPjk)/100);
        
        $("#nilai_pajak_pph_show").val(viewThousandsSeparator(nilai_pjk,1,0));
        $("#nilai_pajak_pph").val(nilai_pjk.toFixed(2));
    });

    $("#tarif_pjk_ppn").change(function(){

        let tarifPjkPPn = $(this).val()?$(this).val():0;
        let dpp = $("#dpp").val()?$("#dpp").val():0;
        
        if(tarifPjkPPn=="manual"){
            $("#nilai_pajak_ppn_show").val("");
            $("#nilai_pajak_ppn").val("");
        }else{
            let nilai_pjk_ppn = parseFloat(dpp)*(parseFloat(tarifPjkPPn)/100);
            let nilai_pjk_ppn_show = nilai_pjk_ppn.toFixed(2);
            $("#nilai_pajak_ppn_show").val(viewThousandsSeparator(nilai_pjk_ppn_show,1,0));
            $("#nilai_pajak_ppn").val(nilai_pjk_ppn_show);
        }
        
    });

    $("#nilai_pajak_ppn").keyup(function(){
        let PPn = $(this).val()?$(this).val():0;
        $("#nilai_pajak_ppn_show").val(viewThousandsSeparator(PPn,1,0));
    });

    $("#nilai_pajak_pph").keyup(function(){
        let PPh = $(this).val()?$(this).val():0;
        $("#nilai_pajak_pph_show").val(viewThousandsSeparator(PPh,1,0));
    });
   
    $(".radio_verikasi").change(function(){
        let verifikasi = $('input[name=is_verifikasi]:checked').val();
        if(verifikasi=='0'){
            _getBidangInvoice( $('#InvoiceID').val());
            $('.form_bidang').show();
            $('.form_keterangan_dikembalikan').show();
            $('.form_pengelompokan_kendala').show();
            $('.panel_kepada').hide();
            $('#keterangan_disposisi_id').val("Dokumen dikembalikan/konfirmasi/pending").trigger("change");
            
        }else{
            $('.form_bidang').hide();
            $('.form_keterangan_dikembalikan').hide();
            $('.form_pengelompokan_kendala').hide();
            $('.panel_kepada').show();
            $('#keterangan_disposisi_id').val("").trigger("change");
        }
    });

    $("#prk_id").change(function(){
        let prk_id = $(this).val();
        let InvoiceID = $('#InvoiceID').val();
        if(parseInt(prk_id)>0 && parseInt(prk_id)!=9999){
            _getSaldoPRK(InvoiceID,prk_id);
        }
       
    });

    $("#kategori_invoice").change(function(){
        let kinv = $(this).val();
        let InvoiceID = $('#InvoiceID').val();
        _getChecklistKlasifikasiInvoice(kinv,InvoiceID);
    });

    $("#pinalti_ver").keyup(function(){
        hitungNetto();
        /*let pinalti = $(this).val()?$(this).val():0;
        let tagihan = $("#tagihan_ver").val();
        let pajak_ppn_ver = $("#pajak_ppn_ver").val();
        let pajak_ver = $("#pajak_ver").val();
        
        $("#pinalti_ver_mask").val(viewThousandsSeparator(pinalti,1,0));

        let netto = parseFloat(tagihan)-(parseFloat(pajak_ppn_ver)+parseFloat(pajak_ver)+parseFloat(pinalti));
        
        $("#netto_ver_show").val(viewThousandsSeparator(netto,1,0));
        $("#netto_ver").val(netto.toFixed(1));*/
    });

    $("#rounding_ver").keyup(function(){
        hitungNetto();
    });
    
    $("#bank_id").change(function(){
        var bank_id = $(this).val();
        if(parseInt(bank_id)>0){
            $('.panel_sisa_saldo').show();
        }else{
            $('.panel_sisa_saldo').hide();
        }
        _getSaldoBank(bank_id);
    });

    $("#currency_id").change(function(){
        var currency_id = $(this).val();
        if(parseInt(currency_id)>1){
            $('#kurs').val("");
            $('.panel-kurs').show();
        }else{
            $('#kurs').val(1);
            $('.panel-kurs').hide();
        }
    });

    $("#currency_id_edit").change(function(){
        var currency_id_ed = $(this).val();
        if(parseInt(currency_id_ed)>1){
            $('#kurs_edit').val("");
            $('.panel-kurs-edit').show();
        }else{
            $('#kurs_edit').val(1);
            $('.panel-kurs-edit').hide();
        }
    });

    $("#filter_nilai_start").keyup(function(){
        let nilai = $(this).val();
        $("#filter_nilai_start_currency_view").html(viewThousandsSeparator(nilai,2,0));
    });

    $("#filter_nilai_end").keyup(function(){
        let nilai = $(this).val();
        $("#filter_nilai_end_currency_view").html(viewThousandsSeparator(nilai,2,0));
    });

    $("#bidang_id").change(function(){
        $('.error_bidang').text("");
    });

    $("#keterangan_dikembalikan").change(function(){
        $('.error_keterangan_dikem').text("");
    });
    $("#kendala").change(function(){
        $('.error_keterangan_dikem').text("");
    });

    $(document).on('click', '#btn-submit-filter-invoice', function() {
        $('#FilterInvoice').modal('hide');
        $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
        $('#tbl_invoice').DataTable().ajax.reload( null, false );

        // start filter inbox
        $('#no_invoice_exp').val($('#filter_no_invoice').val());
        $('#nama_vendor_exp').val($('#filter_vendor').val());
        $('#no_kontrak_exp').val($('#filter_no_kontrak').val());
        
        $('#start_date_exp').val($('#filter_tgl_start').val());
        $('#end_date_exp').val($('#filter_tgl_end').val());
        
        $('#nilai_invoice_start_exp').val($('#filter_nilai_start').val());
        $('#nilai_invoice_end_exp').val($('#filter_nilai_end').val());
        
        $('#tgl_bayar_start_exp').val($('#filter_tgl_bayar_start').val());
        $('#tgl_bayar_end_exp').val($('#filter_tgl_bayar_end').val());

        $('#currency_id_exp').val($('#filter_currency_id').val());
        $('#tahapan_id_exp').val($('#filter_tahapan_id').val());
        $('#jenis_invoice_exp').val($('#filter_jenis_invoice').val());
        $('#no_prk_exp').val($('#filter_no_prk').val());
        $('#kendala_exp').val($('#filter_kendala').val());
        $('#jenis_prk_exp').val($('#filter_jenis_prk').val());
        // end filter inbox

        // start filter export tracking inbox
        $('#no_invoice_exp_track').val($('#filter_no_invoice').val());
        $('#nama_vendor_exp_track').val($('#filter_vendor').val());
        $('#no_kontrak_exp_track').val($('#filter_no_kontrak').val());
        
        $('#start_date_exp_track').val($('#filter_tgl_start').val());
        $('#end_date_exp_track').val($('#filter_tgl_end').val());
        
        $('#nilai_invoice_start_exp_track').val($('#filter_nilai_start').val());
        $('#nilai_invoice_end_exp_track').val($('#filter_nilai_end').val());
        
        $('#tgl_bayar_start_exp_track').val($('#filter_tgl_bayar_start').val());
        $('#tgl_bayar_end_exp_track').val($('#filter_tgl_bayar_end').val());

        $('#currency_id_exp_track').val($('#filter_currency_id').val());
        $('#tahapan_id_exp_track').val($('#filter_tahapan_id').val());
        $('#jenis_invoice_exp_track').val($('#filter_jenis_invoice').val());
        $('#no_prk_exp_track').val($('#filter_no_prk').val());
        $('#kendala_exp_track').val($('#filter_kendala').val());
        $('#jenis_prk_exp_track').val($('#filter_jenis_prk').val());
         // end filter export tracking inbox

         // start filter export outbox
        $('#no_invoice_exp_out').val($('#filter_no_invoice').val());
        $('#nama_vendor_exp_out').val($('#filter_vendor').val());
        $('#no_kontrak_exp_out').val($('#filter_no_kontrak').val());
        
        $('#start_date_exp_out').val($('#filter_tgl_start').val());
        $('#end_date_exp_out').val($('#filter_tgl_end').val());
        
        $('#nilai_invoice_start_exp_out').val($('#filter_nilai_start').val());
        $('#nilai_invoice_end_exp_out').val($('#filter_nilai_end').val());
        
        $('#tgl_bayar_start_exp_out').val($('#filter_tgl_bayar_start').val());
        $('#tgl_bayar_end_exp_out').val($('#filter_tgl_bayar_end').val());

        $('#currency_id_exp_out').val($('#filter_currency_id').val());
        $('#tahapan_id_exp_out').val($('#filter_tahapan_id').val());
        $('#jenis_invoice_exp_out').val($('#filter_jenis_invoice').val());
        $('#no_prk_exp_out').val($('#filter_no_prk').val());
        $('#kendala_exp_out').val($('#filter_kendala').val());
        $('#jenis_prk_exp_out').val($('#filter_jenis_prk').val());
        // end filter export outbox
        
        // end filter export tracking outbox
        $('#no_invoice_exp_track_out').val($('#filter_no_invoice').val());
        $('#nama_vendor_exp_track_out').val($('#filter_vendor').val());
        $('#no_kontrak_exp_track_out').val($('#filter_no_kontrak').val());
        
        $('#start_date_exp_track_out').val($('#filter_tgl_start').val());
        $('#end_date_exp_track_out').val($('#filter_tgl_end').val());
        
        $('#nilai_invoice_start_exp_track_out').val($('#filter_nilai_start').val());
        $('#nilai_invoice_end_exp_track_out').val($('#filter_nilai_end').val());
        
        $('#tgl_bayar_start_exp_track_out').val($('#filter_tgl_bayar_start').val());
        $('#tgl_bayar_end_exp_track_out').val($('#filter_tgl_bayar_end').val());

        $('#currency_id_exp_track_out').val($('#filter_currency_id').val());
        $('#tahapan_id_exp_track_out').val($('#filter_tahapan_id').val());
        $('#jenis_invoice_exp_track_out').val($('#filter_jenis_invoice').val());
        $('#no_prk_exp_track_out').val($('#filter_no_prk').val());
        $('#kendala_exp_track_out').val($('#filter_kendala').val());
        $('#jenis_prk_exp_track_out').val($('#filter_jenis_prk').val());
        // start filter export tracking outbox

    });

    $(document).on('click', '.btn_update_dokumen', function() {
        var id = $(this).attr('uid');
        $.ajax({
            type: "GET",
            url: "invoices/data-dokumen",
            data: 'id='+id,
            dataType: "json",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(result){
                if(result.success=='true'){
                    if(result.data.tipe_dok=='link'){
                        $('#LinkID').val(id);
                        $('#link_invoice_edit').val(result.data.dokumen);
                        $('#linkname_invoice_edit').val(result.data.keterangan);
                    }else{
                        $('#DocIDEdit').val(id);
                        $('#keterangan_dok_edit').val(result.data.keterangan);
                    }
                    
                }else{
                    Swal.fire({
                        title: "Peringatan!",
                        text: result.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    });
                    
                }
            },
            error: function(result){
                Swal.fire({
                    title: "Error!",
                    text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
                    icon: "danger",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.btn_delete_invoice', function() {
        var id = $(this).attr('uid');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data yang sudah dihapus tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus data!",
            cancelButtonText: "Batal!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "invoices/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_invoice').DataTable().ajax.reload( null, false );
                            $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                            GetInboxInvoice();
                            Swal.fire({
                                title: "Sukses!",
                                text: "Dokumen berhasil dihapus",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                                timer: 1500
                            });
                        }else{
                            Swal.fire({
                                title: "Peringatan!",
                                text: result.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-warning"
                                }
                            });
                            
                        }
                    },
                    error: function(result){
                        Swal.fire({
                            title: "Error!",
                            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
                            icon: "danger",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn_delete_dokumen', function() {
        var InvoiceID = $('#InvoiceID').val();
        var id = $(this).attr('uid');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data yang sudah dihapus tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus data!",
            cancelButtonText: "Batal!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "invoices/delete-dokumen",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            
                            setupForm(InvoiceID,'detail');
                            $('#tbl_invoice').DataTable().ajax.reload( null, false );
                            $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );

                            Swal.fire({
                                title: "Sukses!",
                                text: "Dokumen berhasil dihapus",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                                timer: 1500
                            });
                        }else{
                            Swal.fire({
                                title: "Peringatan!",
                                text: result.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-warning"
                                }
                            });
                            
                        }
                    },
                    error: function(result){
                        Swal.fire({
                            title: "Error!",
                            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
                            icon: "danger",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn_invoice_selesaix', function() {
        var InvoiceID = $('#InvoiceID').val();
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data yang sudah diselesaikan tidak bisa diupdate lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Selesaikan invoice ini!",
            cancelButtonText: "Batal!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "invoices/selesaikan",
                    data: 'InvoiceID='+InvoiceID,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){

                            setupForm(InvoiceID,'detail');
                            $('#tbl_invoice').DataTable().ajax.reload( null, false );
                            $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );

                            Swal.fire({
                                title: "Sukses!",
                                text: "Invoice telah selesai (PAID)",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                                timer: 1500
                            });
                        }else{
                            Swal.fire({
                                title: "Peringatan!",
                                text: result.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-warning"
                                }
                            });
                            
                        }
                    },
                    error: function(result){
                        Swal.fire({
                            title: "Error!",
                            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
                            icon: "danger",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                });
            }
        });
    });
    
    
});
