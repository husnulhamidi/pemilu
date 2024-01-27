"use strict";
function RememberEmail() {
    if ( $('#rememberemail').is(':checked') ) { 
        localStorage.setItem("remember-email", $('#email').val());
    }else{
        localStorage.setItem("remember-email", "");
        window.sessionStorage.clear();
        window.localStorage.clear();
    }
}

function checkRememberEmail(){
    var localEmail = localStorage.getItem("remember-email");
    if(localEmail!="" && localEmail!="null" && localEmail!=null && localEmail!="undefined"){
        $('#email').val(localEmail);
        $('#rememberemail').attr('checked', 'checked');
    }else{
        $('#email').val("");
        $('#rememberemail').removeAttr('checked');
    }
}

jQuery(document).ready(function() {

      checkRememberEmail();
      $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });

});
