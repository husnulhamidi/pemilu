"use strict";
var KTDatatablespemilih = function() {

	var initTablepemilih = function() {

        var showAct = false;
        if(jv_update=='true' || jv_delete=='true'){
            showAct = true;
        }

		var table = $('#tbl_pemilih');

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
                "url": "pemilih/data",
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
                { "data": "nama" },
                { "data": "nik" },
                { 
                    "data": "telp" ,
                    render: function (data, type, row, meta) {
                        return data?data:"";
                    } 
                },
                { 
                    "data": "umur",
                    render: function (data, type, row, meta) {
                        var umur = data?data:'';
                        var status = row.status?" | "+row.status:'';
                        return umur+status;
                    } 
                },
                { "data": "alamat" },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    //"visible":showAct,
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                       
                        aksi += '<a href="javascript:;" data-toggle="modal" data-target="#AddPemilih" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_pemilih" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';

                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_pemilih" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
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
			initTablepemilih();
            $('.datatable').show();
		}
	};
}();

function panel(param=""){
    if(param=="grid"){
        $('.panel-grid-pemilih').show();
        $('.panel-form-pemilih').hide();
    }
    else{
        $('.panel-grid-pemilih').hide();
       
        $('.panel-form-pemilih').show();
    } 
}


function ResetForm(){
    document.getElementById("form-submit-pemilih").reset();
    $("#pemilih_id").val("");
    $("#nama").val("");
    $("#nik").val("");
    $("#telp").val("");
    $("#umur").val("");
    $("#status").val("").trigger("change");
    $("#alamat").val("");
}

async function setupForm(id=""){
    const response = await fetch('pemilih/show', {
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
        $("#pemilih_id").val(responseJson.id);
        $("#nama").val(responseJson.nama);
        $("#nik").val(responseJson.nik);
        $("#telp").val(responseJson.telp);
        $("#umur").val(responseJson.umur);
        $("#status").val(responseJson.status).trigger('change');
        $("#alamat").val(responseJson.alamat);

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
        document.getElementById('form-submit-pemilih'),
        {
            fields: {
                nama: {
                    validators: {
                        notEmpty: {
                            message: 'Nama pemilih harus diisi'
                        }
                    }
                },
                nik: {
                    validators: {
                        notEmpty: {
                            message: 'NIK harus diisi'
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
        
        FormValidation.utils.fetch('pemilih/submit', {
            method: 'POST',
            params: {
                id: $('#pemilih_id').val(),
                nama: $('#nama').val(),
                nik: $('#nik').val(),
                umur: $('#umur').val(),
                telp: $('#telp').val(),
                status: $('#status').val(),
                alamat: $('#alamat').val()
               
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#pemilih_id').val(response.id);
                ResetForm();
                setupForm(response.id);
                $('#AddPemilih').modal('hide');
                //panel("grid");

                $('#tbl_pemilih').DataTable().ajax.reload( null, false );
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

function ResetFormImport(){
    document.getElementById("form-import-pemilih").reset();
    $("#dokumen_pemilih").val("");
}

var _submitFormImport = function () {
    FormValidation.formValidation(
        document.getElementById('form-import-pemilih'),
        {
            fields: {
                dokumen_pemilih: {
                    validators: {
                        notEmpty: {
                            message: 'File excel harus diisi'
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
        var formdata = new FormData($('#form-import-pemilih')[0]);

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
            url        : "pemilih/import_excel",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(result){
                let response = result;

                if(response.success === true){
                    ResetFormImport();
                    $('#tbl_pemilih').DataTable().ajax.reload( null, false );

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
                console.log('result', result);
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



jQuery(document).ready(function() {

    KTDatatablespemilih.init();
    
    $(".btn-import-pemilih").click(function() {
        ResetForm();
    });

    $(".btn-add-pemilih").click(function() {
        ResetForm();
    });

    $("#btn-submit-pemilih").one('click',function() {
        _submitForm();
    });

    $(document).on('click', '.btn_edit_pemilih', function() {
        var id = $(this).attr('uid');
        setupForm(id);
    });

    $("#btn-submit-import").one('click',function() {
        _submitFormImport();
    });

    
    $(document).on('click', '.btn_delete_pemilih', function() {
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
                    url: "pemilih/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_pemilih').DataTable().ajax.reload( null, false );
                            
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


