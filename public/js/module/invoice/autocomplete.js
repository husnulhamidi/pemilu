"use strict";
function getdatalist(field,datalist,keywords){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "autocomplete/key",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'field='+field+'&keyword='+keywords,
        success: function(resp){
            $("#"+datalist).html(resp);
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

function getdatalistKet(field,datalist,keywords){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "autocomplete/keterangan",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'field='+field+'&keyword='+keywords,
        success: function(resp){
            $("#"+datalist).html(resp);
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

function ketfunc(id){
    let keywords = $('#keterangan_check'+id).val();
    if(keywords.length>2){
        getdatalistKet('keterangan','list_keterangan'+id,keywords);
    }
}

function getdatalistVendor(field,datalist,keywords){
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : "autocomplete/vendor",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'field='+field+'&keyword='+keywords,
        success: function(resp){
            $("#"+datalist).html(resp.data);
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

jQuery(document).ready(function() {
    
    $("#periode").keyup(function(){
        let keywords = $(this).val();
        if(keywords.length>0){
            getdatalist('periode','list_periode',keywords)
        }
    });

    $("#sap").keyup(function(){
        let keywords = $(this).val();
        if(keywords.length>2){
            getdatalist('sap','list_doc_sap',keywords)
        }
    });

    $("#nama_bank_ver").keyup(function(){
        let keywords = $(this).val();
        if(keywords.length>1){
            getdatalist('nama_bank','list_bank',keywords)
        }
    });

    // $("#norek_ver").keyup(function(){
    //     let keywords = $(this).val();
    //     if(keywords.length>2){
    //         getdatalist('no_rekening','list_norek',keywords)
    //     }
    // });

    // $("#nama_rekening_ver").keyup(function(){
    //     let keywords = $(this).val();
    //     if(keywords.length>2){
    //         getdatalist('nama_rekening','list_rekening',keywords)
    //     }
    // });

    $(document).on('keyup', '.checklist_keterangan', function() {
        let uid = $(this).attr('uid');
        let id = $(this).attr('id');
    });

    $("#vendor_add").keyup(function(){
        let keywords = $(this).val();
        if(keywords.length>1){
            getdatalistVendor('vendor','list_vendor',keywords)
        }
    });

    $("#vendor_edit").keyup(function(){
        let keywords = $(this).val();
        if(keywords.length>1){
            getdatalistVendor('vendor','list_vendor_edit',keywords)
        }
    });

    

    

});
