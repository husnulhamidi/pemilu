"use strict";


function viewThousandsSeparator(x, y=0, show='') {
    //remove commas
    let retVal=0;
    if(x==null || x=='' || x==undefined){
        if(show=='0'){
            var ret = show;
        }else{
            var ret = '';
        }
        return ret;
    }
    const string = ""+x;
    const substring = ".";
    if(!string.includes(substring)){
        x += '.00';
    }
    x = parseFloat(x).toFixed(y);

    var koma = x.split('.');

    retVal = x ? parseFloat(koma[0].replace(/,/g, '')) : 0;
    //apply formatting
    var ret =  retVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    if(ret=='NaN'){
        if(show!=''){
            var ret = show;
        }else{
            var ret = '';
        }
        return ret;
    }else{
        if(koma.length > 1 && y > 0){
            if(koma[1].length > 2){
                var a = parseFloat('0,'+koma[1]).toFixed(y);
                var b = a.split(',');
                var com = ',' + b[1];
            }else{
                var com = ',' + koma[1];
            }
        }else{
            var com = '';
        }
        var ret = ret+com;
        if(show!='' && ret==''){
            var ret = show;
        }
        return ret;
    }
}

function inputThousandsSeparator(x, y=0) {
    //remove commas
    if(x==null || x=='' || x==undefined){
        return '';
    }
    var koma = x.split('.');

    retVal = x ? parseFloat(koma[0].replace(/,/g, '')) : 0;
    //apply formatting
    var ret =  retVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if(ret=='NaN'){
        return '';
    }else{
        if(koma.length > 1 && y > 0){
            if(koma[1].length > 2){
                var a = parseFloat('0.'+koma[1]).toFixed(y);
                var b = a.split('.');
                var com = '.' + b[1];
            }else{
                var com = '.' + koma[1];
            }
        }else{
            var com = '';
        }
        return ret+com;
    }
}

function tanggalIndo(tgl=''){
    if(tgl!='' && tgl!=null && tgl!=undefined){
        var t = tgl.toString().split("-");
        var indo = t[2]+'-'+t[1]+'-'+t[0];
    }else{
        var indo = '';
    }
    return indo;
}

function GetInboxInvoice(){
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //url        : "invoices/total-inbox",
        url        : total_inbox_invoice,
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : "InvoiceID=",
        success: function(result){
            if(parseInt(result)>0){
                $('.total_invoice').html(result);
                $('.total_invoice').show();
            }else{
                $('.total_invoice').html(result);
                $('.total_invoice').show();
            }
            
        },
        error: function(result){
            
        }
    });
}

function GetInboxReimburse(){
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : total_inbox_reimburse,
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : "reimburse_id=",
        success: function(result){
            if(parseInt(result)>0){
                $('.total_reimburse').html(result);
                $('.total_reimburse').show();
            }else{
                $('.total_reimburse').html(result);
                $('.total_reimburse').show();
            }
            
        },
        error: function(result){
            
        }
    });
}

function GetInboxPajak(){

    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //url        : "pajak/total-inbox",
        url        : total_inbox_pajak,
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : "PajakID=",
        success: function(result){
            if(parseInt(result)>0){
                $('.total_pajak').html(result);
                $('.total_pajak').show();
            }else{
                $('.total_pajak').html(result);
                $('.total_pajak').show();
            }
            
        },
        error: function(result){
            
        }
    });
}

function GetInboxTransaksi(){
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //url        : "invoices/total-inbox",
        url        : total_inbox_transaksi,
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : "InvoiceID=",
        success: function(result){
            if(parseInt(result)>0){
                $('.total_transaksi').html(result);
                $('.total_transaksi').show();
            }else{
                $('.total_transaksi').html(result);
                $('.total_transaksi').show();
            }
            
        },
        error: function(result){
            
        }
    });
}


jQuery(document).ready(function() {
    


    /*$(document).idle({
        onIdle: function(){
            window.location=logout_url;                
        },
        idle: 900000
        //15 menit
    });*/

});
