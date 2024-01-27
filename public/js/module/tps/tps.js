"use strict";
var KTDatatablescaleg = function() {

	var initTablecaleg = function() {


		var table = $('#tbl_caleg');

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
                "url": "caleg/data",
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
                { "data": "no" },
                { "data": "nama" },
                { "data": "partai" },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    //"visible":showAct,
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                       
                        aksi += '<a href="javascript:;" data-toggle="modal" data-target="#AddTps" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_caleg" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';

                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_caleg" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
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
			initTablecaleg();
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
    document.getElementById("form-tps").reset();
    $("#caleg_id").val("");
    $("#nama").val("");
    $("#no_urut").val("");
    $("#partai").val("").trigger("change");

}

async function setupForm(id=""){
    const response = await fetch('caleg/show', {
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
        $("#caleg_id").val(responseJson.id);
        $("#nama").val(responseJson.nama);
        $("#no_urut").val(responseJson.no);
        $("#partai").val(responseJson.partai).trigger('change');

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
        document.getElementById('form-tps'),
        {
            fields: {
                nama: {
                    validators: {
                        notEmpty: {
                            message: 'Nama caleg harus diisi'
                        }
                    }
                },
                no_urut: {
                    validators: {
                        notEmpty: {
                            message: 'No urut harus diisi'
                        }
                    }
                },
                partai: {
                    validators: {
                        notEmpty: {
                            message: 'Partai harus diisi'
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
        
        FormValidation.utils.fetch('caleg/submit', {
            method: 'POST',
            params: {
                id: $('#caleg_id').val(),
                nama: $('#nama').val(),
                no_urut: $('#no_urut').val(),
                partai: $('#partai').val()
               
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#caleg_id').val(response.id);
                ResetForm();
                setupForm(response.id);
                $('#AddTps').modal('hide');
                //panel("grid");

                $('#tbl_caleg').DataTable().ajax.reload( null, false );
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

function comboKecamatan(){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "tps/combo-kecamatan",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'invid=1',
        success: function(resp){
            if(resp.success=='true'){
                $('#kecamatan').html(resp.data);
            }else{
                Swal.fire({
                    title: "Peringatan!",
                    text: resp.message,
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
                text: result.responseJSON.message,
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

function comboDesa(kec_id,id=""){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "tps/combo-desa",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'kecamatan_id='+kec_id+"&desa_id"+id,
        success: function(resp){
            if(resp.success=='true'){
                $('#desa').html(resp.data);
            }else{
                Swal.fire({
                    title: "Peringatan!",
                    text: resp.message,
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
                text: result.responseJSON.message,
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


jQuery(document).ready(function() {

    KTDatatablescaleg.init();
    
    $(".btn-add-caleg").click(function() {
        ResetForm();
    });

    $("#btn-submit-caleg").one('click',function() {
        _submitForm();
    });

    $(document).on('click', '.btn_edit_caleg', function() {
        var id = $(this).attr('uid');
        setupForm(id);
    });
    
    $(document).on('click', '.btn_delete_caleg', function() {
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
                    url: "caleg/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_caleg').DataTable().ajax.reload( null, false );
                            
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


