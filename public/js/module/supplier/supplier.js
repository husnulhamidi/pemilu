"use strict";
var KTDatatablesSupplier = function() {

	var initTableSupplier = function() {

        var showAct = false;
        if(jv_update=='true' || jv_delete=='true'){
            showAct = true;
        }

		var table = $('#tbl_supplier');

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
                "url": "supplier/data",
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
                { "data": "nama_supplier" },
                { "data": "telp" },
                { "data": "alamat" },
                { "data": "no_rekening" },
                { "data": "nama_rekening" },
                { "data": "nama_bank" },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    //"visible":showAct,
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                       
                        aksi += '<a href="javascript:;" data-toggle="modal" data-target="#AddSupplier" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_supplier" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';

                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_supplier" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</a>';
                       
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
			initTableSupplier();
            $('.datatable').show();
		}
	};
}();

function panel(param=""){
    if(param=="grid"){
        $('.panel-grid-supplier').show();
        $('.panel-form-supplier').hide();
    }
    else{
        $('.panel-grid-supplier').hide();
       
        $('.panel-form-supplier').show();
    } 
}


function ResetForm(){
    document.getElementById("form-submit-supplier").reset();
    $("#SupplierID").val("");
    $("#nama_supplier").val("");
    $("#telp").val("");
    $("#alamat").html("");
    $("#no_rekening").val("");
    $("#nama_rekening").val("");
    $("#nama_bank").val("");
}

async function setupForm(id=""){
    const response = await fetch('supplier/show', {
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
        $("#SupplierID").val(responseJson.id);
        $("#nama_supplier").val(responseJson.nama_supplier);
        $("#telp").val(responseJson.telp);
        $("#alamat").val(responseJson.alamat);
        $("#no_rekening").val(responseJson.no_rekening);
        $("#nama_rekening").val(responseJson.nama_rekening);
        $("#nama_bank").val(responseJson.nama_bank);

        //panel("form");
        

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


var _submitForm = function () {
    FormValidation.formValidation(
        document.getElementById('form-submit-supplier'),
        {
            fields: {
                nama_supplier: {
                    validators: {
                        notEmpty: {
                            message: 'Nama supplier harus diisi'
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
        
        FormValidation.utils.fetch('supplier/submit', {
            method: 'POST',
            params: {
                id: $('#SupplierID').val(),
                nama_supplier: $('#nama_supplier').val(),
                telp: $('#telp').val(),
                alamat: $('#alamat').val(),
                nama_bank: $('#nama_bank').val(),
                no_rekening: $('#no_rekening').val(),
                nama_rekening: $('#nama_rekening').val()
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#SupplierID').val(response.id);
                ResetForm();
                setupForm(response.id);
                $('#AddSupplier').modal('hide');
                //panel("grid");

                $('#tbl_supplier').DataTable().ajax.reload( null, false );
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



jQuery(document).ready(function() {

    KTDatatablesSupplier.init();
    
    $(".btn-add-vendor").click(function() {
        $(".panel-btn-add-rek").hide();
        panel("form");
        ResetForm();
        //getNoVendor();
    });

    $(".btn-back-vendor").click(function() {
        panel("grid");
    });

    $("#btn-submit-supplier").one('click',function() {
        _submitForm();
    });

    $(document).on('click', '.btn_edit_supplier', function() {
        var id = $(this).attr('uid');
        setupForm(id);
    });
    
    $(document).on('click', '.btn_delete_supplier', function() {
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
                    url: "supplier/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_supplier').DataTable().ajax.reload( null, false );
                            
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
                            text: result.responseJSON.message,
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


