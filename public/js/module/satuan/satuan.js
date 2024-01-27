"use strict";

var KTDatatablesSatuan = function () {
    var initTableSatuan = function () {
        var table = $('#tbl_satuan');

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
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "Semua"]
            ],
            "pageLength": 25,
            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
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
                "url": "satuan/data",
                "type": "GET",
                "data": function (d) {

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
                { "data": "nama_satuan" },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    "orderable": false,
                    render: function (data, type, row, meta) {
                        var aksi = '';

                        aksi += '<a href="javascript:;" data-toggle="modal" data-target="#ModalSatuan" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_satuan" uid="' + data + '" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">' +
                            '<i class="fa fa-edit"></i>' +
                            '</a>';

                        aksi += '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_satuan" uid="' + data + '" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">' +
                            '<i class="fas fa-trash"></i>' +
                            '</a>';

                        return aksi;
                    }
                },
            ]
        });
    };

    return {
        init: function () {
            $.fn.dataTable.ext.errMode = 'none';
            initTableSatuan();
            $('.datatable').show();
        }
    };
}();

function panel(param = "") {
    if (param == "grid") {
        $('.panel-grid-satuan').show();
        $('.panel-form-satuan').hide();
    } else {
        $('.panel-grid-satuan').hide();
        $('.panel-form-satuan').show();
    }
}

function ResetForm() {
    document.getElementById("form-submit-satuan").reset();
    $("#satuan_id").val("");
}

async function editForm(id = "") {
    const response = await fetch("satuan/" + id + "/show", {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let responseJson = await response.json();
    console.log(responseJson);

    if (responseJson.success) {
        ResetForm();
        const satuanData = responseJson.data;
        $("#satuan_id").val(satuanData.id);
        $("#nama_satuan").val(satuanData.nama_satuan);

    } else {
        console.log('Failed to retrieve data. Message:', responseJson.message);
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

var submitForm = function () {
    FormValidation.formValidation(
        document.getElementById('form-submit-satuan'),
        {
            fields: {
                nama_satuan: {
                    validators: {
                        notEmpty: {
                            message: 'Nama satuan harus diisi'
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
    )
    .on('core.form.valid', function () {

        FormValidation.utils.fetch('satuan/submit', {
            method: 'POST',
            params: {
                id: $('#satuan_id').val(),
                nama_satuan: $('#nama_satuan').val()
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        }).then(function (response) {
            if (response.code == "200") {
                $('#satuan_id').val(response.id);
                ResetForm();
                $('#ModalSatuan').modal('hide');
                $('#tbl_satuan').DataTable().ajax.reload(null, false);
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

            } else {
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

jQuery(document).ready(function () {

    KTDatatablesSatuan.init();

    $(".btn_back_satuan").click(function () {
        panel("grid");
    });

    $("#btn_submit_satuan").one('click', function () {
        submitForm();
    });

    $(document).on('click', '.btn_edit_satuan', function () {
        var id = $(this).attr('uid');
        editForm(id);
    });

    $(document).on('click', '.btn_delete_satuan', function () {
        var id = $(this).attr('uid');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data yang sudah dihapus tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus data!",
            cancelButtonText: "Batal!",
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "satuan/" + id + "/delete",
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (result) {
                        if (result.success == true) {
                            $('#tbl_satuan').DataTable().ajax.reload(null, false);
    
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                                timer: 1500
                            });
                        } else {
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
                    error: function (result) {
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
