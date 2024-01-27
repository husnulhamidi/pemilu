"use strict";

var SubmitAddGrouping = function () {
    FormValidation.formValidation(
        document.getElementById('form_add_grouping_treasury'),
        {
            
            fields: {
                gr_keterangan: {
                    validators: {
                        notEmpty: {
                            message: 'Deskripsi harus diisi'
                        }
                    }
                },    
                gr_bank_id: {
                    validators: {
                        notEmpty: {
                            message: 'Bank harus diisi'
                        }
                    }
                },    
                gr_tgl_bayar: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal Bayar harus diisi'
                        }
                    }
                },  
                gr_no_cek: {
                    validators: {
                        notEmpty: {
                            message: 'No Cek/BG harus diisi'
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
        formdata.append("total_nilai_tagihan", $('#total_nilai_tagihan_pembayaran').val());
        formdata.append("arr_inv_checked", $('#arr_inv_checked_pembayaran').val());
        formdata.append("keterangan", $('#gr_keterangan').val());
        formdata.append("bank_id", $('#gr_bank_id').val());
        formdata.append("tgl_bayar", $('#gr_tgl_bayar').val());
        formdata.append("no_cek", $('#gr_no_cek').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url         : "grouping/submit",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    document.getElementById("form_add_grouping_treasury").reset();
                    $('#ModalGroupingTreasury').modal('hide');
                    $('.btn_modal_grouping_treasury').hide();

                    $('#tbl_invoice').DataTable().ajax.reload( null, false );
                    $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                    $('#tbl_grouping').DataTable().ajax.reload( null, false );
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

function getListInvoice(id){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "grouping/list-invoice",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'id='+id,
        success: function(resp){
            $('.spin-list-invoice').hide();
            $('#list_grouping_pembayaran').html(resp.data.list_invoice);
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
function setupUpdateGroup(id){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "grouping/show",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'id='+id,
        success: function(resp){
            $('#grouping_id_up').html(resp.data.id);
            $('#gr_bank_id_up').html(resp.data.combo_bank);
            $('#grouping_id_up').val(resp.data.id);
            $('#gr_keterangan_up').val(resp.data.keterangan);
            $('#gr_tgl_bayar_up').val(resp.data.tgl_bayar);
            $('#gr_no_cek_up').val(resp.data.no_cek);
            $('#gr_bank_id_up').val(resp.data.bank_id).trigger('change');

            $('#total_nilai_tagihan_up_show').val(viewThousandsSeparator(resp.data.total_nilai,0,0));
            $('#gr_bank_id_up_hidden').val(resp.data.bank_id);
            $('#total_nilai_tagihan_up_hidden').val(resp.data.total_nilai);
            
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
var SubmitUpdateGrouping = function () {
    FormValidation.formValidation(
        document.getElementById('form_update_grouping_treasury'),
        {
            
            fields: {
                gr_keterangan_up: {
                    validators: {
                        notEmpty: {
                            message: 'Deskripsi harus diisi'
                        }
                    }
                },    
                gr_bank_id_up: {
                    validators: {
                        notEmpty: {
                            message: 'Bank harus diisi'
                        }
                    }
                },    
                gr_tgl_bayar_up: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal Bayar harus diisi'
                        }
                    }
                },  
                gr_no_cek_up: {
                    validators: {
                        notEmpty: {
                            message: 'No Cek/BG harus diisi'
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
        formdata.append("id", $('#grouping_id_up').val());
        formdata.append("keterangan", $('#gr_keterangan_up').val());
        formdata.append("bank_id", $('#gr_bank_id_up').val());
        formdata.append("tgl_bayar", $('#gr_tgl_bayar_up').val());
        formdata.append("no_cek", $('#gr_no_cek_up').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url         : "grouping/update",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    document.getElementById("form_update_grouping_treasury").reset();
                    $('#ModalUpdateGroupingTreasury').modal('hide');
                    $('#tbl_grouping').DataTable().ajax.reload( null, false );
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

function getComboBank(CurrencyID,act="add",BankIDTemp=""){

    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "saldo/combo-bank",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'currency_id='+CurrencyID,
        success: function(resp){
            $('#filter_gr_bank_id').html(resp);
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

var SubmitSelesaiPaymentGR = function () {
    FormValidation.formValidation(
        document.getElementById('form_selesai_payment_gr'),
        {
            
            fields: {
                no_dokumen_bayar_don_gr: {
                    validators: {
                        notEmpty: {
                            message: 'No dokumen bayar harus diisi'
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
        formdata.append("InvoiceID", $('#invoiceidgr').val());
        formdata.append("no_dokumen_bayar", $('#no_dokumen_bayar_don_gr').val());
        formdata.append("keterangan", $('#keterangan_don_gr').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url         : "invoices/selesaikan",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    document.getElementById("form_selesai_payment_gr").reset();
                    $('#ModalSelesaiPaymentgr').modal('hide');

                    $('.spin-list-invoice').show();
                    getListInvoice($('#invgrid').val());
    
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

var SubmituncheckInvoiceGR = function () {
    FormValidation.formValidation(
        document.getElementById('form_uncheck_invgr'),
        {
            
            fields: {
                is_unchecked_invoice_treasury: {
                    validators: {
                        notEmpty: {
                            message: 'harus diisi'
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
        formdata.append("grouping_id", $('#uncheckgrid').val());
        formdata.append("arr_inv_checked", $('#arr_unchecked_invoice_treasury').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url         : "grouping/submit-uncheck-gr",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    $('#btn_submit_ungrouping_treasury').hide();
                    $('#arr_unchecked_invoice_treasury').val("");

                    $('.spin-list-invoice').show();
                    getListInvoice($('#uncheckgrid').val());
                    

                    $('#tbl_invoice').DataTable().ajax.reload( null, false );
                    $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                    $('#tbl_grouping').DataTable().ajax.reload( null, false );
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


jQuery(document).ready(function() {
    
   
    $("#btn-submit-grouping-treasury").one('click',function() {
        SubmitAddGrouping();
    });
    $("#btn-update-grouping-treasury").one('click',function() {
        SubmitUpdateGrouping();
    });

    $(document).on('click', '.btn_list_grouping_invoice', function() {
        var id = $(this).attr('uid');
        $('#list_grouping_pembayaran').html("");
        $('.spin-list-invoice').show();
        $('#uncheckgrid').val(id);
        getListInvoice(id);
    });

    $(document).on('click', '.btn_detail_invoice_by_group', function() {
        $('#ModalListGroupingTreasury').modal('hide');
        var id = $(this).attr('uid');
        setupForm(id,'detail');
    });

    $(document).on('click', '.btn_update_grouping_invoice', function() {
        var id = $(this).attr('uid');
        setupUpdateGroup(id);
    });

    
    $(document).on('click', '#btn-submit-filter-grouping', function() {
        $('#FilterGroupingInvoice').modal('hide');
        $('#tbl_grouping').DataTable().ajax.reload( null, false );

        $('#gr_deskripsi_exp').val($('#filter_gr_deskripsi').val());
    
        $('#gr_tgl_bayar_start_exp').val($('#filter_gr_tgl_bayar_start').val());
        $('#gr_tgl_bayar_end_exp').val($('#filter_gr_tgl_bayar_end').val());

        $('#gr_currency_id_exp').val($('#filter_gr_currency_id').val());
        $('#gr_bank_id_exp').val($('#filter_gr_bank_id').val());
        $('#gr_cek_exp').val($('#filter_gr_cek').val());
        $('#gr_no_invoice_exp').val($('#filter_gr_no_invoice').val());
        
    });

    $("#filter_gr_currency_id").change(function(){
        var currency_id = $(this).val();
        getComboBank(currency_id);
    });

    $(document).on('click', '.btn_delete_grouping', function() {
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
                    url: "grouping/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success=='true'){
                            $('#tbl_grouping').DataTable().ajax.reload( null, false );
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

    
    $(document).on('click', '.btn_paid_invoice_by_group', function() {
        var uid = $(this).attr('uid');
        var id = uid.split('&');
        $('#invgrid').val(id[0]);
        $('#invoiceidgr').val(id[1]);
    });

    $("#btn-submit-selesai-gr").one('click',function() {
        SubmitSelesaiPaymentGR();
    });

    $(document).on('click', '.uncheck_invoice_gr', function() {
        var idgr = [];
        var rowsgr = document.getElementsByName('is_uncheck_invoice_gr[]');
         var selectedRowsgr = [];
         for (var i = 0, l = rowsgr.length; i < l; i++) {
             if (rowsgr[i].checked) {
                selectedRowsgr.push(rowsgr[i]);
                idgr.push(rowsgr[i].id);
             }
         }
        
         $('#arr_unchecked_invoice_treasury').val(idgr.join());
         $('#is_unchecked_invoice_treasury_total').html(selectedRowsgr.length);
         console.log(selectedRowsgr.length);
         
         if(selectedRowsgr.length>0){
             $('.btn_uncheckgrouping_treasury').show();
         }else{
             $('.btn_uncheckgrouping_treasury').hide();
         }
    });

    $("#btn_submit_ungrouping_treasury").one('click',function() {
        SubmituncheckInvoiceGR();
    });

    
    

});
