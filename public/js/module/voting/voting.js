"use strict";
var KTDatatablesvoting = function() {

	var initTablevoting = function() {


		var table = $('#tbl_voting');

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
                "url": "voting/data",
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
                { "data": "subdistrict.SubDistrictName" },
                { "data": "village.VillageName" },
                { "data": "caleg.nama" },
                { "data": "no_tps" },
                { "data": "suara" },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    //"visible":showAct,
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                       
                        aksi += '<a href="javascript:;" data-toggle="modal" data-target="#AddVoting" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_voting" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';

                        aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_voting" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
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
			initTablevoting();
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
    document.getElementById("form-voting").reset();
    $("#voting_id").val("");
    $("#suara").val("");
    $("#no_tps").val("");
    $("#kecamatan").val("").trigger("change");
    $("#desa").val("").trigger("change");
    $("#caleg_id").val("").trigger("change");

}

async function setupForm(id=""){
    const response = await fetch('voting/show', {
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
        $("#desa").val(responseJson.VillageID).trigger('change');
        $("#voting_id").val(responseJson.id);
        $("#no_tps").val(responseJson.no_tps);
        $("#suara").val(responseJson.suara);
        $("#kecamatan").val(responseJson.SubDistrictID).trigger('change');
        $("#caleg_id").val(responseJson.caleg_id).trigger('change');
        
        comboDesa(responseJson.SubDistrictID,responseJson.VillageID);

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
        document.getElementById('form-voting'),
        {
            fields: {
                kecamatan: {
                    validators: {
                        notEmpty: {
                            message: 'Kecamatan harus diisi'
                        }
                    }
                },
                desa: {
                    validators: {
                        notEmpty: {
                            message: 'Desa harus diisi'
                        }
                    }
                },
                voting: {
                    validators: {
                        notEmpty: {
                            message: 'Perolehan Suara harus diisi'
                        }
                    }
                },
                no_tps: {
                    validators: {
                        notEmpty: {
                            message: 'No TPS harus diisi'
                        }
                    }
                },
                caleg: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Caleg harus diisi'
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
        
        FormValidation.utils.fetch('voting/submit', {
            method: 'POST',
            params: {
                id: $('#voting_id').val(),
                kecamatan: $('#kecamatan').val(),
                desa: $('#desa').val(),
                caleg_id: $('#caleg_id').val(),
                suara: $('#suara').val(),
                no_tps: $('#no_tps').val()
               
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#voting_id').val(response.id);
                ResetForm();
                setupForm(response.id);
                $('#AddVoting').modal('hide');
                //panel("grid");

                $('#tbl_voting').DataTable().ajax.reload( null, false );
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
        url        : "voting/combo-desa",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'kecamatan_id='+kec_id+"&desa_id="+id,
        success: function(resp){
            
                $('#desa').html(resp);
            
            
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

    KTDatatablesvoting.init();
    
    $(".btn-add-voting").click(function() {
        ResetForm();
    });

    $("#btn-submit-voting").one('click',function() {
        _submitForm();
    });

    $(document).on('click', '.btn_edit_voting', function() {
        var id = $(this).attr('uid');
        setupForm(id);
    });

    $("#kecamatan").change(function(){
        let kec_id = $(this).val();
        let village_id = $("desa").val();
        comboDesa(kec_id,village_id);
        
    });
    
    $(document).on('click', '.btn_delete_voting', function() {
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
                    url: "voting/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_voting').DataTable().ajax.reload( null, false );
                            
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


