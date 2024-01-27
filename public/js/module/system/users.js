"use strict";
var KTDatatablesUsers = function() {

	var initTableUsers = function() {
      
		var table = $('#tbl_users');

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
                "url": "users/ajax-data",
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
                { "data": "nip" },
                { "data": "name" },
                { "data": "email" },
                { "data": "role" },
                { 
                    "data": "status_code" ,
                    render: function (data, type, row, meta) {
                        if(data=='active'){
                            return "<span class='badge badge-success'>"+data+"</span>";
                        }else{
                            return "<span class='badge badge-danger'>"+data+"</span>";
                        }
                    }
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                       
                        if(jv_update=='true'){
                            aksi += '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_user" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';
                        }
                        if(jv_delete){
                            aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_user" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
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
			initTableUsers();
            $('.datatable').show();
		}
	};
}();

function panel(param=""){
    if(param=="grid"){
        $('.panel-grid-users').show();
        $('.panel-form-users').hide();
        $('.panel-form-update-users').hide();
    }
    else if(param=="edit"){
        $('.panel-grid-users').hide();
        $('.panel-form-users').hide();
        $('.panel-form-update-users').show();
    }
    else{
        $('.panel-grid-users').hide();
        $('.panel-form-users').show();
        $('.panel-form-update-users').hide();
    } 
}


function ResetForm(){
    document.getElementById("form-users").reset();
    $("#nip").val("");
    $("#nama").val("");
    $("#email").val("");
    $("#role_id").val("");
}

async function setupForm(id="",$act=""){
    const response = await fetch('users/show', {
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
        $("#UserID").val(responseJson.id);
        $("#UserID_up").val(responseJson.id);
        $("#nip_up").val(responseJson.nip);
        $("#nama_up").val(responseJson.name);
        $("#email_up").val(responseJson.email);
        $("#role_id_up").val(responseJson.role_id).trigger('change');
        if(responseJson.status_code=='active'){
            $('#is_status1').prop('checked', true);
        }else{
            $('#is_status0').prop('checked', true);
        }
        panel("edit");
        

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
        document.getElementById('form-users'),
        {
            fields: {
                nip: {
                    validators: {
                        notEmpty: {
                            message: 'NIP harus diisi'
                        }
                    }
                },
                nama: {
                    validators: {
                        notEmpty: {
                            message: 'Nama harus diisi'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Email harus diisi'
                        },
                        emailAddress:{
                            message: 'Alamat Email harus valid'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'Password harus diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'Minimal 8 karakter',
                        },
                    }
                },
                role_id: {
                    validators: {
                        notEmpty: {
                            message: 'Role harus diisi'
                        }
                    }
                },
                is_status: {
                    validators: {
                        notEmpty: {
                            message: 'Status harus diisi'
                        }
                    }
                },
                
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
                passwordStrength: new FormValidation.plugins.PasswordStrength({
                    field: 'password',
                    message: 'The password is weak',
                    minimalScore: 2,
                    
                }),
            }
        }
    ).on('core.form.valid', function() {
        
        FormValidation.utils.fetch('users/submit', {
            method: 'POST',
            params: {
                id: $('#UserID').val(),
                nip: $('#nip').val(),
                nama: $('#nama').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                role_id: $('#role_id').val(),
                status_code: $('input[name=is_status]:checked').val()
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#UserID').val(response.id);
                ResetForm();
                panel("grid");

                $('#tbl_users').DataTable().ajax.reload( null, false );
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

var _submitFormUpdate = function () {
    FormValidation.formValidation(
        document.getElementById('form-update-users'),
        {
            fields: {
                nip_up: {
                    validators: {
                        notEmpty: {
                            message: 'NIP harus diisi'
                        }
                    }
                },
                nama_up: {
                    validators: {
                        notEmpty: {
                            message: 'Nama harus diisi'
                        }
                    }
                },
                email_up: {
                    validators: {
                        notEmpty: {
                            message: 'Email harus diisi'
                        },
                        emailAddress:{
                            message: 'Alamat Email harus valid'
                        }
                    }
                },
                password_up: {
                    validators: {
                        stringLength: {
                            min: 8,
                            message: 'Minimal 8 karakter',
                        },
                    }
                },
                role_id_up: {
                    validators: {
                        notEmpty: {
                            message: 'Role harus diisi'
                        }
                    }
                },
                is_status: {
                    validators: {
                        notEmpty: {
                            message: 'Status harus diisi'
                        }
                    }
                },
                
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
                passwordStrength: new FormValidation.plugins.PasswordStrength({
                    field: 'password_up',
                    message: 'The password is weak',
                    minimalScore: 2,
                    
                }),
            }
        }
    ).on('core.form.valid', function() {
        
        FormValidation.utils.fetch('users/submit', {
            method: 'POST',
            params: {
                id: $('#UserID_up').val(),
                nip: $('#nip_up').val(),
                nama: $('#nama_up').val(),
                email: $('#email_up').val(),
                password: $('#password_up').val(),
                role_id: $('#role_id_up').val(),
                status_code: $('input[name=is_status]:checked').val()
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#UserID_up').val(response.id);
                ResetForm();
                panel("grid");

                $('#tbl_users').DataTable().ajax.reload( null, false );
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


var submitUpdateProfile = function () {
    const form = document.getElementById('form-profile');
    const fv = FormValidation.formValidation(form,
        {
            fields: {
                passkey: {
                    validators: {
                        notEmpty: {
                            message: 'Password harus diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'Minimal 8 karakter',
                        },
                    }
                },
                konfirmasi_password: {
                    validators: {
                        notEmpty: {
                            message: 'Konfirmasi Password harus diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'Minimal 8 karakter',
                        },
                        identical: {
                            compare: function () {
                                return form.querySelector('[name="passkey"]').value;
                            },
                            message: 'Konfirmasi Password tidak sama dengan Password',
                        },
                    }
                },
                
                
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }
    ).on('core.form.valid', function() {
        
        FormValidation.utils.fetch('update-profile', {
            method: 'POST',
            params: {
                password: $('#passkey').val()
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){

                $('#passkey').val("");
                $('#konfirmasi_password').val("")
                
                
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

var submitUpdatePassword = function () {
    const form = document.getElementById('form-update-password');
    const fv = FormValidation.formValidation(form,
        {
            fields: {
                password_up: {
                    validators: {
                        notEmpty: {
                            message: 'Password harus diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'Minimal 8 karakter',
                        },
                    }
                },
                konfirmasi_password_up: {
                    validators: {
                        notEmpty: {
                            message: 'Konfirmasi Password harus diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'Minimal 8 karakter',
                        },
                        identical: {
                            compare: function () {
                                return form.querySelector('[name="password_up"]').value;
                            },
                            message: 'Konfirmasi Password tidak sama dengan Password',
                        },
                    }
                },
                
                
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }
    ).on('core.form.valid', function() {
        var pass = $('#password_up').val();
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url        : "submit-updatepass",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : 'password='+pass,
            success: function(resp){

                Swal.fire({
                    title: "Sukses!",
                    text: "Password berhasil diupdate.",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    },
                    timer: 1500
                });
                
            },
            error: function(result){
                Swal.fire({
                    title: "Peringatan!",
                    text: "Password gagal diupdate. Refresh dan coba kembali. Jika masih error hubungi Administrator.",
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

    KTDatatablesUsers.init();
    
    $(".btn-add-user").click(function() {
        panel("form");
        ResetForm();
        $('#is_status1').prop('checked', true);
    });

    $(".btn-back-users").click(function() {
        panel("grid");
    });

    $(".btn-save-form-user").one('click',function() {
        _submitForm();
    });

    $("#btn-update-form-user").one('click',function() {
        _submitFormUpdate();
    });

    $(document).on('click', '.btn_edit_user', function() {
        var id = $(this).attr('uid');
        setupForm(id,'edit');
    });

    $(".btn-update-profile").one('click',function() {
        submitUpdateProfile();
    });

    $("#btn-update-password").one('click',function() {
        submitUpdatePassword();
    });
    
    $(document).on('click', '.btn_delete_user', function() {
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
                    url: "users/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_users').DataTable().ajax.reload( null, false );
                            
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
