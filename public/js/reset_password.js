"use strict";


function checkEmail(email){
    $('.checking-email').html("<div class='spinner spinner-warning'></div>");
    
    $.ajax({
        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url        : url_verifyemail,
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : "email="+email,
        success: function(resp){
            
            if(resp.status=='true'){
                $('.checking-email').html(resp.message);
                $('#kt_form_submit_reset_password').show();
                $('#kt_form_submit_reset_password_disabled').hide();
            }else{
                $('#kt_form_submit_reset_password').hide();
                $('#kt_form_submit_reset_password_disabled').show();
                $('.checking-email').html("");
            }
        },
        error: function(result){
            
        }
    });
}


jQuery(document).ready(function() {
    
    $("#email").keyup(function(){
        let email = $(this).val();
        checkEmail(email);
    });
});
