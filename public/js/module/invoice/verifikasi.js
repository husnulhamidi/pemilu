"use strict";

function ResetFormVerifikasiCommon(){
    document.getElementById("form_verifikasi_pajak").reset();
    document.getElementById("form_verifikasi_anggaran").reset();
    document.getElementById("form_verifikasi_treasury").reset();
    $("#fv_nilai_invoice_verifikasi_show").val("");
    $("#fv_nilai_invoice_pjk").val("");
    $("#fv_tipe_dpp").val("").trigger('change');
    $("#fv_dpp").val("");
    $("#fv_dpp_mask").val("");
    $("#fv_ppn_type").val("").trigger('change');
    $("#fv_tarif_pjk_ppn").val("");
    $("#fv_nilai_pajak_ppn_show").text("");
    $("#fv_nilai_pajak_ppn").val("");
    $("#fv_pph_id").val("");
    $("#fv_tarif_pjk_pph").val("");
    $("#fv_nilai_pajak_pph_show").text("");
    $("#fv_nilai_pajak_pph").val("");

    $("#fv_klasifikasi_biaya_id").val("").trigger('change');
    $("#fv_prk_id").val("");
    $("#fv_unit").val("").trigger('change');
    $("#ket_tambahan").val("");
    $("#catatan_lainnya_prk").val("");
    $(".panel-blank-tipe").hide();
    $(".panel-attachment-prk").hide();
    $(".panel-catatan-lainnya").hide();

    $("#fv_bank_id").val("");
    $("#fv_no_dokumen_bayar").val("");
    $("#fv_tgl_bayar_invoice").val("");
    $("#fv_no_cek").val("");
    
}

function _getDataVerifikasiCommon(){
    var InvoiceID = $('#InvoiceID').val();
    var InvoiceIDEnc = $('#invid_print').val();
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/data-verifikasi",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'InvoiceID='+InvoiceID,
        success: function(resp){
            $("#fv_nilai_invoice_verifikasi_show").val(resp.nilai_invoice_formatted);
            $("#fv_nilai_invoice_pjk").val(resp.nilai_invoice);
            $('#fv_prk_id').html(resp.combo_prk);
            $('#fv_bank_id').html(resp.combo_bank);
            $('#fv_nilai_netto_treasury_show').val(resp.netto_formatted);

            //pajak 
            $("#fv_tipe_dpp").val(resp.tipe_dpp);
            $("#fv_dpp").val(resp.dpp);
            $("#fv_dpp_mask").text(viewThousandsSeparator(resp.dpp,resp.digit,0));
            $("#fv_ppn_type").val(resp.ppn_type_id);
            $("#fv_tarif_pjk_ppn").val(resp.tarif_ppn);
            $("#fv_nilai_pajak_ppn_show").text(viewThousandsSeparator(resp.nilai_ppn,resp.digit,0));
            $("#fv_nilai_pajak_ppn").val(resp.nilai_ppn);
            $("#fv_pph_id").val(resp.pajak_id);
            $("#fv_tarif_pjk_pph").val(resp.tarif);
            $("#fv_nilai_pajak_pph_show").text(viewThousandsSeparator(resp.nilai_pajak,resp.digit,0));
            $("#fv_nilai_pajak_pph").val(resp.nilai_pajak);
            
            //anggaran
            if(resp.anggaran_verifikasi=='show'){
                $("#fv_unit").val(resp.anggaran.unit).trigger('change');
                $("#fv_klasifikasi_biaya_id").val(resp.anggaran.klasifikasi_biaya_id).trigger('change');
                $("#fv_prk_id").val(resp.anggaran.prk_id).trigger('change');
                $("#ket_tambahan").val(resp.ket_tambahan);
                if(resp.anggaran.tipe=="Attachment"){
                    $('#is_blank_prk1').prop('checked', true);
                    $(".panel-attachment-prk").show();
                    $(".panel-catatan-lainnya").hide();
                }else if(resp.anggaran.tipe=="Catatan Lainnya"){
                    $('#is_blank_prk0').prop('checked', true);
                    $(".panel-attachment-prk").hide();
                    $(".panel-catatan-lainnya").show();
                }else{
                    $('#is_blank_prk1').prop('checked', false);
                    $('#is_blank_prk0').prop('checked', false);
                    $(".panel-attachment-prk").hide();
                    $(".panel-catatan-lainnya").hide();
                }
                $("#fv_prk_id").val(resp.anggaran.prk_id).trigger('change');
                $("#catatan_lainnya_prk").val(resp.anggaran.catatan);
            }

            //treasury
            $("#fv_nilai_netto_treasury_hidden").val(resp.netto);
            $("#fv_bank_id_treasury_hidden").val(resp.bank_id);
            $("#fv_bank_id").val(resp.bank_id).trigger('change');
            $("#fv_no_dokumen_bayar").val(resp.no_dokumen_bayar);
            $("#fv_tgl_bayar_invoice").val(resp.tgl_bayar);
            $("#fv_no_cek").val(resp.no_cek);
            
            
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

var SubmitVerifikasiPajak = function () {
    FormValidation.formValidation(
        document.getElementById('form_verifikasi_pajak'),
        {
            
            fields: {
                fv_tipe_dpp: {
                    validators: {
                        notEmpty: {
                            message: 'Tipe harus dipilih'
                        }
                    }
                },
                fv_dpp: {
                    validators: {
                        notEmpty: {
                            message: 'DPP harus diisi'
                        }
                    }
                },
                fv_nilai_pajak_ppn: {
                    validators: {
                        notEmpty: {
                            message: 'Nilai PPN harus diisi'
                        }
                    }
                },    
                fv_type_ppn: {
                    validators: {
                        notEmpty: {
                            message: 'Type PPN harus diisi'
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
        
        var formdata = new FormData(); 
        formdata.append("InvoiceID", $('#InvoiceID').val());
        // verifikasi pajak
        formdata.append("tipe_dpp", $('#fv_tipe_dpp').val());
        formdata.append("dpp", $('#fv_dpp').val());
        formdata.append("ppn_type_id", $('#fv_ppn_type').val());
        formdata.append("tarif_ppn", $('#fv_tarif_pjk_ppn').val());
        formdata.append("nilai_pajak_ppn", $('#fv_nilai_pajak_ppn').val());
        formdata.append("pph_id", $('#fv_pph_id').val());
        formdata.append("tarif_pjk_pph", $('#fv_tarif_pjk_pph').val());
        formdata.append("nilai_pajak_pph", $('#fv_nilai_pajak_pph').val());
        if(parseFloat($('#fv_tarif_pjk_pph').val())>0 && parseFloat($('#fv_nilai_pajak_pph').val())>0 && $('#fv_pph_id').val()==""){
            $('.error_pph').text('belum pilih PPh');
        }else{
            $.ajax({
                headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url        : "invoices/submit-verifikasi-pajak",
                type       : 'POST',
                contentType: false,
                cache      : false,
                processData: false,
                data       : formdata,
                success: function(response){
                    if(response.success==='true'){
                        
                        setupForm(response.id,'detail');
                        document.getElementById("form_verifikasi_pajak").reset();
                        $('#VerifikasiPajakInvoice').modal('hide');
        
                        $('#tbl_invoice').DataTable().ajax.reload( null, false );
                        $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                        
                        ResetFormVerifikasiCommon();
        
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

var SubmitVerifikasiAnggaran = function () {
    FormValidation.formValidation(
        document.getElementById('form_verifikasi_anggaran'),
        {
            
            fields: {
                fv_unit: {
                    validators: {
                        notEmpty: {
                            message: 'Unit harus dipilih'
                        }
                    }
                },
                fv_klasifikasi_biaya_id: {
                    validators: {
                        notEmpty: {
                            message: 'Kategori Mar harus diisi'
                        }
                    }
                },
                fv_prk_id: {
                    validators: {
                        notEmpty: {
                            message: 'Kategori Biaya harus diisi'
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
        formdata.append("InvoiceID", $('#InvoiceID').val());
        let prk_id = $('#fv_prk_id').val();
        let blank_tipe = $('input[name=is_blank_prk]:checked').val();
        var attachment = document.getElementById("attachment_blank_prk").files[0];
        //var attachment_count = "";
        var attachment_count = $('#attachment_blank_prk')[0].files.length;

        // verifikasi anggaran
        formdata.append("klasifikasi_biaya_id", $('#fv_klasifikasi_biaya_id').val());
        formdata.append("unit", $('#fv_unit').val());
        formdata.append("prk_id", $('#fv_prk_id').val());
        formdata.append("ket_tambahan", $('#ket_tambahan').val());
        formdata.append("blank_tipe", blank_tipe);
        formdata.append("attachment", attachment);
        formdata.append("catatan", $('#catatan_lainnya_prk').val());
   
        if(parseInt(prk_id)==9999 && (blank_tipe=="" || blank_tipe=="undefined" || blank_tipe==undefined)){
            $('.error_blank_prk').text('Silahkan pilih evidence !');
        }
        else if(parseInt(prk_id)==9999 && blank_tipe=="Catatan Lainnya" && $('#catatan_lainnya_prk').val()==""){
            $('.error_catatan_lainnya_prk').text('Catatan Lainnya harus di isi');
        }
        else if(parseInt(prk_id)==9999 && blank_tipe=="Attachment" && attachment_count===0){
            $('.error_attachment_prk').text('Attachment harus di isi');
        }
        else{
            $.ajax({
                headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url        : "invoices/submit-verifikasi-anggaran",
                type       : 'POST',
                contentType: false,
                cache      : false,
                processData: false,
                data       : formdata,
                success: function(response){
                    if(response.success==='true'){
                        
                        setupForm(response.id,'detail');
                        document.getElementById("form_verifikasi_anggaran").reset();
                        $('#VerifikasiAnggaranInvoice').modal('hide');
        
                        $('#tbl_invoice').DataTable().ajax.reload( null, false );
                        $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                        
                        ResetFormVerifikasiCommon();
        
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

var SubmitVerifikasiTreasury = function () {
    FormValidation.formValidation(
        document.getElementById('form_verifikasi_treasury'),
        {
            
            fields: {
                fv_bank_id: {
                    validators: {
                        notEmpty: {
                            message: 'Bank harus dipilih'
                        }
                    }
                },
                fv_tgl_bayar_invoice: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal Bayar harus diisi'
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
        formdata.append("InvoiceID", $('#InvoiceID').val());

        // verifikasi treasury
        formdata.append("bank_id", $('#fv_bank_id').val());
        formdata.append("no_dokumen_bayar", $('#fv_no_dokumen_bayar').val());
        formdata.append("tgl_bayar_invoice", $('#fv_tgl_bayar_invoice').val());
        formdata.append("no_cek", $('#fv_no_cek').val());
        formdata.append("action", $('#fv_action').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url        : "invoices/submit-verifikasi-treasury",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    setupForm(response.id,'detail');
                    document.getElementById("form_verifikasi_treasury").reset();
                    $('#VerifikasiTreasuryInvoice').modal('hide');
    
                    $('#tbl_invoice').DataTable().ajax.reload( null, false );
                    $('#tbl_inbox_invoice').DataTable().ajax.reload( null, false );
                    
                    ResetFormVerifikasiCommon();
    
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

var SubmitCancelPayment = function () {
    FormValidation.formValidation(
        document.getElementById('form_cancel_payment'),
        {
            
            fields: {
                keterangan_cp: {
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
        
        var formdata = new FormData(); 
        formdata.append("InvoiceID", $('#InvoiceID').val());
        formdata.append("keterangan", $('#keterangan_cp').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url        : "invoices/cancel-payment",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    setupForm(response.id,'detail');
                    document.getElementById("form_cancel_payment").reset();
                    $('#ModalCancelPayment').modal('hide');
    
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

var SubmitPendingPayment = function () {
    FormValidation.formValidation(
        document.getElementById('form_pending_payment'),
        {
            
            fields: {
                keterangan_pend: {
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
        
        var formdata = new FormData(); 
        formdata.append("InvoiceID", $('#InvoiceID').val());
        formdata.append("keterangan", $('#keterangan_pend').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url        : "invoices/pending-payment",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    setupForm(response.id,'detail');
                    document.getElementById("form_pending_payment").reset();
                    $('#ModalPendingPayment').modal('hide');
    
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

var SubmitSelesaiPayment = function () {
    FormValidation.formValidation(
        document.getElementById('form_selesai_payment'),
        {
            
            fields: {
                no_dokumen_bayar_don: {
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
        formdata.append("InvoiceID", $('#InvoiceID').val());
        formdata.append("no_dokumen_bayar", $('#no_dokumen_bayar_don').val());
        formdata.append("keterangan", $('#keterangan_don').val());
    
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
                    
                    setupForm(response.id,'detail');
                    document.getElementById("form_selesai_payment").reset();
                    $('#ModalSelesaiPayment').modal('hide');
    
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

var SubmitNoArsip = function () {
    FormValidation.formValidation(
        document.getElementById('form_no_arsip'),
        {
            
            fields: {
                no_arsip_done: {
                    validators: {
                        notEmpty: {
                            message: 'No. Arsip harus diisi'
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
        formdata.append("InvoiceID", $('#InvoiceID').val());
        formdata.append("no_arsip", $('#no_arsip_done').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url        : "invoices/submit-no-arsip",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    setupForm(response.id,'detail');
                    document.getElementById("form_no_arsip").reset();
                    $('#ModalNoArsip').modal('hide');
    
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


function _getBidangInvoice(InvoiceID){
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/bidang",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'InvoiceID='+InvoiceID,
        success: function(resp){
            $('#bidang_id').html(resp);
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

function hitungPPnPPh(digit){
      
    let dpp = $("#fv_dpp").val()?$("#fv_dpp").val():0;
    let tarif_pjk_pph = $("#fv_tarif_pjk_pph").val()?$("#fv_tarif_pjk_pph").val():0;
    let tarif_pjk_ppn = $("#fv_tarif_pjk_ppn").val()?$("#fv_tarif_pjk_ppn").val():0;
    
    let nilai_pph = parseFloat(dpp)*(parseFloat(tarif_pjk_pph)/100);
    $("#fv_nilai_pajak_pph_show").text(viewThousandsSeparator(nilai_pph,digit,0));
    $("#fv_nilai_pajak_pph").val(nilai_pph.toFixed(digit));
    //console.log("pph:"+nilai_pph);
    if(tarif_pjk_ppn=="manual"){
        $("#fv_nilai_pajak_ppn_show").text("");
        $("#fv_nilai_pajak_ppn").val("");
    }else{
        let nilai_pjk_ppn = parseFloat(dpp)*(parseFloat(tarif_pjk_ppn)/100);
        let nilai_pjk_ppn_show = nilai_pjk_ppn.toFixed(digit);
        $("#fv_nilai_pajak_ppn_show").text(viewThousandsSeparator(nilai_pjk_ppn_show,digit,0));
        $("#fv_nilai_pajak_ppn").val(nilai_pjk_ppn_show);
       // console.log("ppn:"+nilai_pjk_ppn);
    }
    
    
}

function confirmBeforeReimburse(){
    var checked_invoice =  $("#is_checked_invoice").val();
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "reimburse/confirm-invoice",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'checked_invoice='+checked_invoice,
        success: function(resp){
            $('#total_nilai_tagihan_show').html(viewThousandsSeparator(resp.data.total_netto));
            $('#total_nilai_tagihan').val(resp.data.total_netto);
            $('#arr_inv_checked').val(resp.data.inv_checked);
            $('#list_invoice_checked').html(resp.data.list_invoice);
            $('#reimburse_id').html(resp.data.reimburse);
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

var SubmitAddReimburse = function () {
    FormValidation.formValidation(
        document.getElementById('form_add_reimburse'),
        {
            
            fields: {
                uraian_reimburse: {
                    validators: {
                        notEmpty: {
                            message: 'Deskripsi harus diisi'
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
        formdata.append("reimburse_id", $('#reimburse_id').val());
        formdata.append("total_nilai_tagihan", $('#total_nilai_tagihan').val());
        formdata.append("arr_inv_checked", $('#arr_inv_checked').val());
        formdata.append("uraian_reimburse", $('#uraian_reimburse').val());
    
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url         : "reimburse/submit",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdata,
            success: function(response){
                if(response.success==='true'){
                    
                    document.getElementById("form_add_reimburse").reset();
                    $('#ModalGroupingReimburse').modal('hide');
                    $('.btn_grouping_invoice').hide();
                    GetInboxInvoice();
                    GetInboxReimburse();
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

function getReimburse(reimburse_id){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "reimburse/show-reimburse",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'reimburse_id='+reimburse_id,
        success: function(resp){
            $('#uraian_reimburse').val(resp.data.uraian);
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

function submitKetTambahan(){
   
    var formdata = new FormData(); 
    formdata.append("InvoiceID", $('#InvoiceID').val());
    formdata.append("ket_tambahan", $('#post_ket_tambahan').val());

    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/submit_ket_tambahan",
        type       : 'POST',
        contentType: false,
        cache      : false,
        processData: false,
        data       : formdata,
        success: function(response){
            if(response.success==='true'){
                    
                $('#ModalKetTambahan').modal('hide');
                setupForm($('#InvoiceID').val(),'detail');

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

function getUraianPekerjaan(invid){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/show-invoice",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'invid='+invid,
        success: function(resp){
            $('#InvoiceIDupd').val(resp.id);
            $('#post_update_deskripsi').val(resp.uraian_pekerjaan);
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

var submitUpdateDeskripsi = function () {
    FormValidation.formValidation(
        document.getElementById('form-update-deskripsi'),
        {
            fields: {
                post_update_deskripsi: {
                    validators: {
                        notEmpty: {
                            message: 'Uraian Pekerjaan harus diisi'
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
        
        FormValidation.utils.fetch('invoices/update-deskripsi', {
            method: 'POST',
            params: {
                id: $('#InvoiceIDupd').val(),
                uraian_pekerjaan: $('#post_update_deskripsi').val()
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
               
                $('#ModalUpdateDeskripsi').modal('hide');

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

function setupSysTtd(invid){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/ttd",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'invid='+invid,
        success: function(resp){
           $('#mengetahui_nama').val(resp.mengetahui.nama);
           $('#mengetahui_jabatan').val(resp.mengetahui.jabatan);
           //console.log("mengetahui_nama:"+resp.mengetahui.nama);

           $('#menyetujui_nama').val(resp.menyetujui.nama);
           $('#menyetujui_jabatan').val(resp.menyetujui.jabatan);
           //console.log("mengetahui_nama:"+resp.menyetujui.nama);
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

function comboVendor(act="add",invid=""){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/combo-vendor",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'invid='+invid,
        success: function(resp){
            if(resp.success=='true'){
                if(act=='add'){
                    $('#vendor').html(resp.data);
                }else{
                    $('#vendor_edit').html(resp.data);
                }
                
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

function ResetFormVendor(){
    document.getElementById("form-add-vendor").reset();
    $("#VendorID").val("");
    $("#no_vendor").val("");
    $("#nama_vendor").val("");
    $("#nama_bank").val("");
    $("#no_rekening").val("");
    $("#nama_rekening").val("");
}

function getNoVendor(){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "referensi/vendor/no-vendor",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'no=',
        success: function(resp){
            $('#no_vendor').val(resp);
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

var _submitFormVendor = function () {
    FormValidation.formValidation(
        document.getElementById('form-add-vendor'),
        {
            fields: {
                no_vendor: {
                    validators: {
                        notEmpty: {
                            message: 'No vendor harus diisi'
                        }
                    }
                },
                nama_vendor: {
                    validators: {
                        notEmpty: {
                            message: 'Nama vendor harus diisi'
                        }
                    }
                },
                nama_bank: {
                    validators: {
                        notEmpty: {
                            message: 'Nama bank harus diisi'
                        }
                    }
                },
                no_rekening: {
                    validators: {
                        notEmpty: {
                            message: 'No.rekening harus diisi'
                        }
                    }
                },
                nama_rekening: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Rekening harus diisi'
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
        
        FormValidation.utils.fetch('referensi/vendor/create', {
            method: 'POST',
            params: {
                id: $('#VendorID').val(),
                no_vendor: $('#no_vendor').val(),
                nama_vendor: $('#nama_vendor').val(),
                nama_bank: $('#nama_bank').val(),
                no_rekening: $('#no_rekening').val(),
                nama_rekening: $('#nama_rekening').val()
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response) {
            if(response.success=="true"){
                $('#VendorID').val(response.id);
                ResetFormVendor();
                $('#ModalAddVendor').modal('hide');

                comboVendor();

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

function confirmBeforeGroupingTreasury(){
    var checked_invoice =  $("#is_checked_invoice_treasury").val();
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "invoices/confirm-grouping-pembayaran-invoice",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'checked_invoice='+checked_invoice,
        success: function(resp){
            $('#total_nilai_tagihan_pembayaran_show').html(viewThousandsSeparator(resp.data.total_netto));
            $('#total_nilai_tagihan_pembayaran').val(resp.data.total_netto);
            $('#arr_inv_checked_pembayaran').val(resp.data.inv_checked);
            $('#list_invoice_checked_pembayaran').html(resp.data.list_invoice);
            //$('#grouping_id').html(resp.data.reimburse);
            $('#gr_bank_id').html(resp.data.combo_bank);
            
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

function getRekeningVendor(id){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "referensi/vendor/rekening-vendor",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'id='+id,
        success: function(resp){
            $('#nama_bank_ver').val(resp.data.nama_bank);
            $('#norek_ver').val(resp.data.no_rekening);
            $('#nama_rekening_ver').val(resp.data.nama_rekening);
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

function ResetFormImportVerifikator(){
    document.getElementById("form_import_klasifikasi_invoice").reset();
    $("#excel_klasifikasi_inv").val("");
}


var _submitFormImportVerifikator = function () {
    FormValidation.formValidation(
        document.getElementById('form_import_klasifikasi_invoice'),
        {
            fields: {
                excel_klasifikasi_inv: {
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
        
        var formdataiv = new FormData(); 
        var dokumen = document.getElementById("excel_klasifikasi_inv").files[0];
        var InvoiceID = $('#InvoiceID').val();
        var kategori_invoice = $('#kategori_invoice').val();
        formdataiv.append("InvoiceID",  InvoiceID);
        formdataiv.append("dokumen", dokumen);
        
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
            url        : "invoices/import/klasifikasi-biaya",
            type       : 'POST',
            contentType: false,
            cache      : false,
            processData: false,
            data       : formdataiv,
            success: function(result){
                let response = result;
                if(response.success==='true'){
                    ResetFormImportVerifikator();
                    _getChecklistKlasifikasiInvoice(kategori_invoice,InvoiceID);
                    $('#ImportKlasifikasiInvoice').modal('hide');
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
    
    $(document).on('click', '.btn_modal_verifikasi_pajak', function() {
        ResetFormVerifikasiCommon();
        _getDataVerifikasiCommon();
    });
    $(document).on('click', '.btn_modal_update_verifikasi_pajak', function() {
        ResetFormVerifikasiCommon();
        _getDataVerifikasiCommon();
    });
    $("#btn-submit-verifikasi-pajak").one('click',function() {
        SubmitVerifikasiPajak();
    });

    $(document).on('click', '.btn_modal_verifikasi_anggaran', function() {
        ResetFormVerifikasiCommon();
        ComboKlasifikasiBiaya();
        _getDataVerifikasiCommon();
        
    });
    $(document).on('click', '.btn_modal_update_verifikasi_anggaran', function() {
        ResetFormVerifikasiCommon();
        ComboKlasifikasiBiaya();
        _getDataVerifikasiCommon();
        
    });
    
    $("#btn-submit-verifikasi-anggaran").one('click',function() {
        SubmitVerifikasiAnggaran();
    });

    $("#post_ket_tambahan").keyup(function(){
        sessionStorage.setItem("sess_ket_tambahan", $('#post_ket_tambahan').val());
    });

    $(".btn_modal_ket_tambahan_invoice").on('click',function() {
        var ket = sessionStorage.getItem("sess_ket_tambahan");
        $('#post_ket_tambahan').val(ket);
    });

    $(".btn-reset-ket-tambahan").on('click',function() {
        window.sessionStorage.clear();
    });

    $("#btn-submit-ket-tambahan").on('click',function() {
        submitKetTambahan();
    });

    $(document).on('click', '.btn_modal_verifikasi_treasury', function() {
        ResetFormVerifikasiCommon();
        _getDataVerifikasiCommon();
        $('.panel-no-dok-bayar').hide();
        $('#fv_action').val("add");
    });

    $(document).on('click', '.btn_modal_update_verifikasi_treasury', function() {
        ResetFormVerifikasiCommon();
        _getDataVerifikasiCommon();
        $('.panel-no-dok-bayar').show();
        $('#fv_action').val("update");
    });
    
    $("#btn-submit-verifikasi-treasury").one('click',function() {
        SubmitVerifikasiTreasury();
    });

    $("#btn-submit-cancel-payment").one('click',function() {
        SubmitCancelPayment();
    });

    $("#btn-submit-pending-payment").one('click',function() {
        SubmitPendingPayment();
    });

    $("#btn-submit-selesai").one('click',function() {
        SubmitSelesaiPayment();
    });

    $("#btn-submit-no-arsip").on('click',function() {
        SubmitNoArsip();
    });

    $("#fv_tipe_dpp").change(function(){
        let tipe_dpp = $(this).val();
        let dpp = 0;
        let nilai_invoice = $("#fv_nilai_invoice_pjk").val();
        var digit = $("#digit").val();
        if(tipe_dpp=='rumus10'){
            dpp = (100/110)*nilai_invoice;
            $("#fv_dpp").val(dpp.toFixed(digit));
            $("#fv_dpp_mask").text(viewThousandsSeparator(dpp,digit,0));
        }else if(tipe_dpp=='rumus11'){
            dpp = (100/111)*nilai_invoice;
            
            $("#fv_dpp").val(dpp.toFixed(digit));
            $("#fv_dpp_mask").text(viewThousandsSeparator(dpp,digit,0));
        }
        else{
            $("#fv_dpp").val("");
            $("#fv_dpp_mask").text("");
        }
        //console.log('dpp:'+dpp);
        hitungPPnPPh(digit);
        
    });

    $("#fv_dpp").keyup(function(){
        let digit = $("#digit").val();
        let dpp = $(this).val()?$(this).val():0;
        let tarif = $("#fv_tarif_pjk").val();
        $("#fv_dpp_mask").text(viewThousandsSeparator(dpp,digit,0));

        let tarifPjk = tarif?tarif:0;
        let nilai_pjk = parseFloat(dpp)*(parseFloat(tarifPjk)/100);
        $("#fv_nilai_pajak_show").text(viewThousandsSeparator(nilai_pjk,digit,0));
        $("#fv_nilai_pajak").val(nilai_pjk.toFixed(digit));

        hitungPPnPPh();
    });

    $("#fv_tarif_pjk_pph").keyup(function(){
        let digit = $("#digit").val();
        let tarifPjk = $(this).val()?$(this).val():0;
        let dpp = $("#fv_dpp").val()?$("#fv_dpp").val():0;

        let nilai_pjk = parseFloat(dpp)*(parseFloat(tarifPjk)/100);
        
        $("#fv_nilai_pajak_pph_show").text(viewThousandsSeparator(nilai_pjk,digit,0));
        $("#fv_nilai_pajak_pph").val(nilai_pjk.toFixed(digit));
    });

    $("#fv_tarif_pjk_ppn").change(function(){
        let digit = $("#digit").val();
        let tarifPjkPPn = $(this).val()?$(this).val():0;
        let dpp = $("#fv_dpp").val()?$("#fv_dpp").val():0;
        
        if(tarifPjkPPn=="manual"){
            $("#fv_nilai_pajak_ppn_show").text("");
            $("#fv_nilai_pajak_ppn").val("");
        }else{
            let nilai_pjk_ppn = parseFloat(dpp)*(parseFloat(tarifPjkPPn)/100);
            let nilai_pjk_ppn_show = nilai_pjk_ppn.toFixed(digit);
            $("#fv_nilai_pajak_ppn_show").text(viewThousandsSeparator(nilai_pjk_ppn_show,digit,0));
            $("#fv_nilai_pajak_ppn").val(nilai_pjk_ppn_show);
        }
        
    });

    $("#fv_nilai_pajak_ppn").keyup(function(){
        let PPn = $(this).val()?$(this).val():0;
        let digit = $("#digit").val();
        $("#fv_nilai_pajak_ppn_show").text(viewThousandsSeparator(PPn,digit,0));
    });

    $("#fv_nilai_pajak_pph").keyup(function(){
        let PPh = $(this).val()?$(this).val():0;
        let digit = $("#digit").val();
        $("#fv_nilai_pajak_pph_show").text(viewThousandsSeparator(PPh,digit,0));
    });

    $("#fv_pph_id").change(function(){
        let pph_id = $(this).val()?$(this).val():0;
        $.ajax({
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url         : "invoices/tarif-pph",
            type       : 'GET',
            contentType: false,
            cache      : false,
            processData: false,
            data       : 'id='+pph_id,
            success: function(resp){
                if(parseFloat(resp.data.tarif)>0){
                    $("#fv_tarif_pjk_pph").val(resp.data.tarif).trigger('keyup');
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

    $("#fv_prk_id").change(function(){
        let prk_id = $(this).val();
        let InvoiceID = $('#InvoiceID').val();
        $("#fv_show_tbl_prk").html("");
        if(parseInt(prk_id)>0 && parseInt(prk_id)!=9999){
            _getSaldoPRK(InvoiceID,prk_id);
        }
        
        if(parseInt(prk_id)==9999){
            $(".panel-blank-tipe").show();
            $("#fv_show_tbl_prk").html("");
        }else{
            $(".panel-blank-tipe").hide();
            $(".panel-attachment-prk").hide();
            $(".panel-catatan-lainnya").hide();
            
        }
    });

    $("#blank_tipe").change(function(){
        let tipe = $(this).val();
        if(tipe=='Attachment'){
            $(".panel-attachment-prk").show();
            $(".panel-catatan-lainnya").hide();
        }else{
            $(".panel-attachment-prk").hide();
            $(".panel-catatan-lainnya").show();
        }
    });

    $(".radio_blank_prk").change(function(){
        let evidence = $('input[name=is_blank_prk]:checked').val();
        if(evidence=='Attachment'){
            $(".panel-attachment-prk").show();
            $(".panel-catatan-lainnya").hide();
        }else{
            $(".panel-attachment-prk").hide();
            $(".panel-catatan-lainnya").show();
        }
    });
    
    $("#fv_bank_id").change(function(){
        var bank_id = $(this).val();
        if(parseInt(bank_id)>0){
            $('.fv_panel_sisa_saldo').show();
        }else{
            $('.fv_panel_sisa_saldo').hide();
        }
        _getSaldoBank(bank_id);
    });

    $("#gr_bank_id").change(function(){
        var bank_id = $(this).val();
        if(parseInt(bank_id)>0){
            $('.gr_panel_sisa_saldo').show();
        }else{
            $('.gr_panel_sisa_saldo').hide();
        }
        _getSaldoBank(bank_id,"grouping");
    });

    $("#gr_bank_id_up").change(function(){
        var bank_id = $(this).val();
        if(parseInt(bank_id)>0){
            $('.gr_panel_sisa_saldo_up').show();
        }else{
            $('.gr_panel_sisa_saldo_up').hide();
        }
        _getSaldoBank(bank_id,"grouping_up");
    });

    $(document).on('click', '.checklist_reimburse', function() {
        var id = [];
        var rows = document.getElementsByName('is_check_reimburse[]');
         var selectedRows = [];
         for (var i = 0, l = rows.length; i < l; i++) {
             if (rows[i].checked) {
                 selectedRows.push(rows[i]);
                 id.push(rows[i].id);
             }
         }
        
         $('#is_checked_invoice').val(id.join());
         $('#is_checked_invoice_total').html(selectedRows.length);
         
         if(selectedRows.length>0){
             $('.btn_grouping_invoice').show();
         }else{
             $('.btn_grouping_invoice').hide();
         }
    });

    $(document).on('click', '.btn_modal_reimburse', function() {
        confirmBeforeReimburse();
    });

    $("#btn-submit-reimburse").one('click',function() {
        SubmitAddReimburse();
    });
    
    $("#reimburse_id").change(function(){
        let reimburse_id = $(this).val();
        if(parseInt(reimburse_id)>0){
            getReimburse(reimburse_id);
        }else{
            $('#uraian_reimburse').val("")
        }
        
    });

    $(document).on('click', '.btn_update_deskripsi_invoice', function() {
        var invid = $(this).attr('uid');
        getUraianPekerjaan(invid);
    });

    $("#btn-submit-update-deskripsi").click(function() {
        submitUpdateDeskripsi();
    });

    $(".panel-inbox").click(function() {
        $(".btn-export-panel-outbox").hide();
        $(".btn-export-panel-inbox").show();
        $(".btn-export-grouping").hide();
        $(".btn-filter").show();
        $(".filter_prk").hide();
        $(".btn-filter-grouping").hide();
        $(".btn-export-panel-trackinginvoice-inbox").show();
        $(".btn-export-panel-trackinginvoice-outbox").hide();
        //$("#btn-submit-filter-invoice").show();
        //$("#btn-submit-filter-invoice-outbox").hide();
    });

    $(".panel-outbox").click(function() {
        $(".btn-export-panel-outbox").show();
        $(".btn-export-panel-inbox").hide();
        $(".btn-export-grouping").hide();
        $(".btn-filter").show();
        $(".filter_prk").show();
        $(".btn-filter-grouping").hide();
        $(".btn-export-panel-trackinginvoice-inbox").hide();
        $(".btn-export-panel-trackinginvoice-outbox").show();
        //$("#btn-submit-filter-invoice").hide();
        //$("#btn-submit-filter-invoice-outbox").show();
    });

    $(".panel-grouping").click(function() {
        $(".btn-export-panel-outbox").hide();
        $(".btn-export-panel-inbox").hide();
        $(".btn-filter").hide();
        $(".btn-filter-grouping").show();
        $(".btn-export-grouping").show();
        $(".btn-export-panel-trackinginvoice-inbox").hide();
        $(".btn-export-panel-trackinginvoice-outbox").hide();

    });

    
    $(".btn-modal-add-vendor").click(function() {
        getNoVendor();
    });

    $("#btn-submit-add-vendor").click(function() {
        _submitFormVendor();
    });

    $(document).on('click', '.checklist_treasury', function() {
        var id = [];
        var rows = document.getElementsByName('is_check_treasury[]');
         var selectedRows = [];
         for (var i = 0, l = rows.length; i < l; i++) {
             if (rows[i].checked) {
                 selectedRows.push(rows[i]);
                 id.push(rows[i].id);
             }
         }
        
         $('#is_checked_invoice_treasury').val(id.join());
         $('#is_checked_invoice_treasury_total').html(selectedRows.length);
         
         if(selectedRows.length>0){
             $('.btn_grouping_treasury').show();
         }else{
             $('.btn_grouping_treasury').hide();
         }
    });

    $(document).on('click', '.btn_modal_grouping_treasury', function() {
        confirmBeforeGroupingTreasury();
    });

    $("#select_rekening").change(function(){
        let rek_id = $(this).val();
        if(parseInt(rek_id)>0){
            getRekeningVendor(rek_id);
        }
        
    });

    $(".export-klasifikasi-biaya").click(function() {
        let InvoiceID = $("#InvoiceID").val();
        let JenisTagihan = $("#kategori_invoice").val();
        if(JenisTagihan==""){
            Swal.fire({
                title: "Peringatan!",
                text: "Silahkan pilih klasifikasi invoice terlebih dahulu !.",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-warning"
                }
            });
        }else{
            window.location.href=url_export_klasifikasi_inv+"?InvoiceID="+InvoiceID+"&JenisTagihan="+JenisTagihan;
        }
        
    });

    $("#btn-submit-import-verifikator").one('click',function() {
        _submitFormImportVerifikator();
    });

    $(".radio_checklist_inbox").change(function(){
        let check = $('input[name=is_cecklist_inbox]:checked').val();
        if(check=='1'){
            $('#checkbox_tgl_masuk_dok').prop('checked', true);
            $('#checkbox_no_invoice').prop('checked', true);
            $('#checkbox_tgl_invoice').prop('checked', true);
            $('#checkbox_vendor').prop('checked', true);
            $('#checkbox_no_kontrak').prop('checked', true);
            $('#checkbox_no_doc_sap').prop('checked', true);
            $('#checkbox_uraian').prop('checked', true);
            $('#checkbox_bank').prop('checked', true);
            $('#checkbox_mata_uang').prop('checked', true);
            $('#checkbox_nominal').prop('checked', true);
            $('#checkbox_kurs').prop('checked', true);
            $('#checkbox_nominal_idr').prop('checked', true);
            $('#checkbox_ppn').prop('checked', true);
            $('#checkbox_pph21').prop('checked', true);
            $('#checkbox_pph4_2').prop('checked', true);
            $('#checkbox_pph15').prop('checked', true);
            $('#checkbox_pph22').prop('checked', true);
            $('#checkbox_pph23').prop('checked', true);
            $('#checkbox_pinalty').prop('checked', true);
            $('#checkbox_netto').prop('checked', true);

            $('#checkbox_tgl_bayar').prop('checked', true);
            $('#checkbox_no_doc_bayar').prop('checked', true);
            $('#checkbox_jenis_invoice').prop('checked', true);
            $('#checkbox_kendala').prop('checked', true);
            $('#checkbox_status_payment').prop('checked', true);
            $('#checkbox_sla').prop('checked', true);
            $('#checkbox_arsip').prop('checked', false);
        }else{
            $('#checkbox_tgl_masuk_dok').prop('checked', false);
            $('#checkbox_no_invoice').prop('checked', false);
            $('#checkbox_tgl_invoice').prop('checked', false);
            $('#checkbox_vendor').prop('checked', false);
            $('#checkbox_no_kontrak').prop('checked', false);
            $('#checkbox_no_doc_sap').prop('checked', false);
            $('#checkbox_uraian').prop('checked', false);
            $('#checkbox_bank').prop('checked', false);
            $('#checkbox_mata_uang').prop('checked', false);
            $('#checkbox_nominal').prop('checked', false);
            $('#checkbox_kurs').prop('checked', false);
            $('#checkbox_nominal_idr').prop('checked', false);
            $('#checkbox_ppn').prop('checked', false);
            $('#checkbox_pph21').prop('checked', false);
            $('#checkbox_pph4_2').prop('checked', false);
            $('#checkbox_pph15').prop('checked', false);
            $('#checkbox_pph22').prop('checked', false);
            $('#checkbox_pph23').prop('checked', false);
            $('#checkbox_pinalty').prop('checked', false);
            $('#checkbox_netto').prop('checked', false);

            $('#checkbox_tgl_bayar').prop('checked', false);
            $('#checkbox_no_doc_bayar').prop('checked', false);
            $('#checkbox_jenis_invoice').prop('checked', false);
            $('#checkbox_kendala').prop('checked', false);
            $('#checkbox_status_payment').prop('checked', false);
            $('#checkbox_sla').prop('checked', false);
            $('#checkbox_arsip').prop('checked', false);
        }
    });

    $(".radio_checklist_outbox").change(function(){
        let check = $('input[name=is_cecklist_outbox]:checked').val();
        if(check=='1'){
            $('#check_tgl_masuk_dok').prop('checked', true);
            $('#check_no_invoice').prop('checked', true);
            $('#check_tgl_invoice').prop('checked', true);
            $('#check_vendor').prop('checked', true);
            $('#check_no_kontrak').prop('checked', true);
            $('#check_no_doc_sap').prop('checked', true);
            $('#check_uraian').prop('checked', true);
            $('#check_bank').prop('checked', true);
            $('#check_mata_uang').prop('checked', true);
            $('#check_nominal').prop('checked', true);
            $('#check_kurs').prop('checked', true);
            $('#check_nominal_idr').prop('checked', true);
            $('#check_ppn').prop('checked', true);
            $('#check_pph21').prop('checked', true);
            $('#check_pph4_2').prop('checked', true);
            $('#check_pph15').prop('checked', true);
            $('#check_pph22').prop('checked', true);
            $('#check_pph23').prop('checked', true);
            $('#check_pinalty').prop('checked', true);
            $('#check_netto').prop('checked', true);
            $('#check_no_prk').prop('checked', true);
            $('#check_tgl_bayar').prop('checked', true);
            $('#check_no_doc_bayar').prop('checked', true);
            $('#check_jenis_invoice').prop('checked', true);
            $('#check_kendala').prop('checked', true);
            $('#check_status_payment').prop('checked', true);
            $('#check_sla').prop('checked', true);
            $('#check_arsip').prop('checked', true);
        }else{
            $('#check_tgl_masuk_dok').prop('checked', false);
            $('#check_no_invoice').prop('checked', false);
            $('#check_tgl_invoice').prop('checked', false);
            $('#check_vendor').prop('checked', false);
            $('#check_no_kontrak').prop('checked', false);
            $('#check_no_doc_sap').prop('checked', false);
            $('#check_uraian').prop('checked', false);
            $('#check_bank').prop('checked', false);
            $('#check_mata_uang').prop('checked', false);
            $('#check_nominal').prop('checked', false);
            $('#check_kurs').prop('checked', false);
            $('#check_nominal_idr').prop('checked', false);
            $('#check_ppn').prop('checked', false);
            $('#check_pph21').prop('checked', false);
            $('#check_pph4_2').prop('checked', false);
            $('#check_pph15').prop('checked', false);
            $('#check_pph22').prop('checked', false);
            $('#check_pph23').prop('checked', false);
            $('#check_pinalty').prop('checked', false);
            $('#check_netto').prop('checked', false);
            $('#check_no_prk').prop('checked', false);
            $('#check_tgl_bayar').prop('checked', false);
            $('#check_no_doc_bayar').prop('checked', false);
            $('#check_jenis_invoice').prop('checked', false);
            $('#check_kendala').prop('checked', false);
            $('#check_status_payment').prop('checked', false);
            $('#check_sla').prop('checked', false);
            $('#check_arsip').prop('checked', false);
        }
    });

    
    
    
});
