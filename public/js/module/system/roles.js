"use strict";
var KTDatatablesRoles = function() {

	var initTableRoles = function() {

		var table = $('#tbl_roles');

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
                [1, 'asc']
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
                "url": "role/ajax-data",
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
                { "data": "role" },
                
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "220px",
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                       if(jv_update=='true'){
                            aksi += '<a href="javascript:;" class="btn btn-sm btn-primary  btn_privilege_roles" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 'Setting Akses Menu'+   
                                '</a>';
                            aksi += '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_roles" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                '<i class="fa fa-edit"></i>'+   
                               '</a>';
                       }
                       if(jv_delete && data>13){
                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_role" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
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
			initTableRoles();
            $('.datatable').show();
		}
	};
}();

function panel(param=""){
    if(param=="grid"){
        $('.panel-grid-roles').show();
        $('.panel-form-role').hide();
        $('.panel-form-create-role').hide();
    }else if(param=="create"){
        $('.panel-grid-roles').hide();
        $('.panel-form-role').hide();
        $('.panel-form-create-role').show();
    }
    else{
        $('.panel-grid-roles').hide();
        $('.panel-form-role').show();
        $('.panel-form-create-role').hide();
    } 
}


function ResetForm(){
    document.getElementById("form-roles").reset();
}

function ResetFormCreate(){
    document.getElementById("form-create-role").reset();
    $("#role_ct").val("");
}

function generate_access(role_id=''){
    $.ajax({
        type: "GET",
        url: url_generate_menu_access,
        data: 'role_id='+role_id,
        dataType: "html",
        success: function(result){
            $(".panel-group-access").empty().append(result);
        },
        error: function(result){
            $(".panel-group-access").empty();
        }
    });
}

async function setupForm(id="",act="form"){
    const response = await fetch('role/show', {
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
        ResetFormCreate();
        //--//
        $("#RoleID").val(responseJson.id);
        $("#RoleLabel").html(responseJson.role);

        $("#role_id").val(responseJson.id);
        $("#role_ct").val(responseJson.role);
        
        if(act=="form"){
            generate_access(responseJson.id);
        }
        
        if(responseJson.is_disposisi==1){
            $('#disposisi1').prop('checked', true);
        }else{
            $('#disposisi0').prop('checked', true);
        }

        if(responseJson.is_back_document==1){
            $('#kembalikan_dok1').prop('checked', true);
        }else{
            $('#kembalikan_dok0').prop('checked', true);
        }

        if(responseJson.is_confirm_document==1){
            $('#konfirmasi_dok1').prop('checked', true);
        }else{
            $('#konfirmasi_dok0').prop('checked', true);
        }

        if(responseJson.is_update_document==1){
            $('#edit_dok1').prop('checked', true);
        }else{
            $('#edit_dok0').prop('checked', true);
        }

        if(responseJson.is_update_text==1){
            $('#edit_text1').prop('checked', true);
        }else{
            $('#edit_text0').prop('checked', true);
        }
        
        panel(act);
        

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
        document.getElementById('form-roles'),
        {
            fields: {
                role_id: {
                    validators: {
                        notEmpty: {
                            message: 'Role harus diisi'
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
        
        var array = [];
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
        for (var i = 0; i < checkboxes.length; i++) {
            array.push(checkboxes[i].value)
        }
        
        FormValidation.utils.fetch('role/submit', {
            method: 'POST',
            params: {
                id: $('#RoleID').val(),
                MenuAccess: array,
                is_disposisi: $('input[name=disposisi]:checked').val(),
                is_back_document: $('input[name=kembalikan_dok]:checked').val(),
                is_confirm_document: $('input[name=konfirmasi_dok]:checked').val(),
                is_update_document: $('input[name=edit_dok]:checked').val(),
                is_update_text: $('input[name=edit_text]:checked').val(),
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#RoleID').val(response.id);
                ResetForm();
                panel("grid");

                $('#tbl_roles').DataTable().ajax.reload( null, false );
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

var _submitFormCreate = function () {
    FormValidation.formValidation(
        document.getElementById('form-create-role'),
        {
            fields: {
                role_ct: {
                    validators: {
                        notEmpty: {
                            message: 'Role harus diisi'
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
        
        FormValidation.utils.fetch('role/create', {
            method: 'POST',
            params: {
                id: $('#role_id').val(),
                role: $('#role_ct').val(),
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#role_id').val(response.id);
                ResetFormCreate();
                panel("grid");

                $('#tbl_roles').DataTable().ajax.reload( null, false );
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

    KTDatatablesRoles.init();
    
    $(".btn-add-role").click(function() {
        panel("form");
        ResetForm();
    });

    $(".btn-create-role").click(function() {
        panel("create");
        ResetFormCreate();
    });

    $(".btn-back-roles").click(function() {
        panel("grid");
    });

    $(".btn-save-form-roles").one('click',function() {
        _submitForm();
    });

    $(".btn-save-form-create-role").one('click',function() {
        _submitFormCreate();
    });

    $(document).on('click', '.btn_privilege_roles', function() {
        var id = $(this).attr('uid');
        setupForm(id);
    });

    $(document).on('click', '.btn_edit_roles', function() {
        var id = $(this).attr('uid');
        setupForm(id,'create');
    });

    
    $(document).on('click', '.btn_delete_role', function() {
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
                    url: "role/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_roles').DataTable().ajax.reload( null, false );
                            
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
    
    
});
