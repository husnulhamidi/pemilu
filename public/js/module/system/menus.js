"use strict";
var KTDatatablesMenus = function() {

	var initTableRoles = function() {

		var table = $('#tbl_grid_menu');

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
                "url": "menu/ajax-data",
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
                { "data": "title" },
                { "data": "page" },
                {  
                    "data": "id",
                    render:function (data, type, row, meta) {
                        let parent="";
                        if(row.parent){
                            parent=row.parent.title;
                        }
                        return parent;
                    } 
                },
                { "data": "order" },
                
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                        //if(jv_update=='true'){
                            aksi += '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_menu" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';
                        //}
                        if(jv_delete){
                            /*aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_user" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</a>';*/
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
        $('.panel-grid-menu').show();
        $('.panel-form-menu').hide();
    }
    else if(param=="edit"){
        $('.panel-grid-menu').hide();
        $('.panel-form-menu').hide();
    }
    else{
        $('.panel-grid-menu').hide();
        $('.panel-form-menu').show();
    } 
}


function ResetForm(){
    document.getElementById("form_menu").reset();
    generate_access();
}


function generate_access(MenuID=''){
    $.ajax({
        type: "GET",
        url: url_generate_menu_action,
        data: 'MenuID='+MenuID,
        dataType: "html",
        success: function(result){
            $(".panel-menu-action").empty().append(result);
        },
        error: function(result){
            $(".panel-menu-action").empty();
        }
    });
}

async function setupForm(id="",act="form"){
    const response = await fetch('menu/show', {
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
        $('#MenuID').val(responseJson.id);
        $("#MenuParentID").val(responseJson.parent_id).trigger('change');
        $('#MenuName').val(responseJson.title);
        $('#MenuModule').val(responseJson.page);
        $('#MenuOrder').val(responseJson.order);
        $('#MenuIcon').val(responseJson.icon);
        
        if(act=="form"){
            generate_access(responseJson.id);
        }
        
        if(responseJson.is_parent==1){
            $('#IsParent1').prop('checked', true);
        }else{
            $('#IsParent2').prop('checked', true);
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

var _submitFormMenu = function () {
    FormValidation.formValidation(
        document.getElementById('form_menu'),
        {
            fields: {
                MenuName: {
                    validators: {
                        notEmpty: {
                            message: 'Nama menu harus diisi'
                        }
                    }
                },
                MenuModule: {
                    validators: {
                        notEmpty: {
                            message: 'Module harus diisi'
                        }
                    }
                },
                IsParent: {
                    validators: {
                        notEmpty: {
                            message: 'Is Parent harus diisi'
                        }
                    }
                },
                MenuOrder: {
                    validators: {
                        notEmpty: {
                            message: 'Is Parent harus diisi'
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
        
        FormValidation.utils.fetch('menu/submit', {
            method: 'POST',
            params: {
                id: $('#MenuID').val(),
                MenuActionID: array,
                MenuParentID: $('#MenuParentID').val(),
                MenuName: $('#MenuName').val(),
                MenuModule: $('#MenuModule').val(),
                IsParent: $('input[name=IsParent]:checked').val(),
                MenuOrder: $('#MenuOrder').val(),
                MenuIcon: $('#MenuIcon').val(),
                
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#MenuID').val(response.id);
                ResetForm();
                panel("grid");

                $('#tbl_grid_menu').DataTable().ajax.reload( null, false );
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

    KTDatatablesMenus.init();
    
    $(".btn-add-menu").click(function() {
        panel("form");
        ResetForm();
    });

    $(".btn-back-menu").click(function() {
        panel("grid");
    });

    $(".btn-save-form-menu").one('click',function() {
        _submitFormMenu();
    });

    $(document).on('click', '.btn_privilege_roles', function() {
        var id = $(this).attr('uid');
        setupForm(id);
    });

    $(document).on('click', '.btn_edit_menu', function() {
        var id = $(this).attr('uid');
        setupForm(id,'form');
    });

    
    $(document).on('click', '.btn_delete_menu', function() {
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
                    url: "menu/delete",
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
