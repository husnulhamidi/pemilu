"use strict";

function checkStrength(password) {
    var strength = 0;
    var lowupp = 'false';
    var onenum = 'false';
    var special = 'false';
    var eight = 'false';

    //If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
      strength += 2;
      $('.low-upper-case').addClass('text-success');
      $('.low-upper-case i').removeClass('fas fa-file-alt').addClass('fas fa-check');
      //$('#kt_update_password_submit').removeClass('disabled');
      lowupp = "true";
    } else {
      $('.low-upper-case').removeClass('text-success');
      $('.low-upper-case i').addClass('fas fa-file-alt').removeClass('fas fa-check');
      //$('#kt_update_password_submit').addClass('disabled');
      lowupp = "false";
    }

    //If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
      strength += 2;
      $('.one-number').addClass('text-success');
      $('.one-number i').removeClass('fas fa-file-alt').addClass('fas fa-check');
      //$('#kt_update_password_submit').removeClass('disabled');
      onenum="true";
    } else {
      $('.one-number').removeClass('text-success');
      $('.one-number i').addClass('fas fa-file-alt').removeClass('fas fa-check');
      //$('#kt_update_password_submit').addClass('disabled');
      onenum="false";
    }

    //If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
      strength += 2;
      $('.one-special-char').addClass('text-success');
      $('.one-special-char i').removeClass('fas fa-file-alt').addClass('fas fa-check');
      //$('#kt_update_password_submit').removeClass('disabled');
        special ="true";
    } else {
      $('.one-special-char').removeClass('text-success');
      $('.one-special-char i').addClass('fas fa-file-alt').removeClass('fas fa-check');
      //$('#kt_update_password_submit').addClass('disabled');
      special ="false";
    }

    if (password.length >= 8) {
      strength += 2;
      $('.eight-character').addClass('text-success');
      $('.eight-character i').removeClass('fas fa-file-alt').addClass('fas fa-check');
      //$('#kt_update_password_submit').removeClass('disabled');
      eight = "true";

    } else {
      $('.eight-character').removeClass('text-success');
      $('.eight-character i').addClass('fas fa-file-alt').removeClass('fas fa-check');
      //$('#kt_update_password_submit').addClass('disabled');
      eight = "false";
    }

    if(lowupp=="true" && onenum=="true" && special=="true" && eight=="true"){
        return "true";
    }else{
        return "false";
    }

  }

// Class Initialization
jQuery(document).ready(function() {
   
    // $('#password_up').keyup(function () {
    //     actionButton();
    // });

    document.getElementById("password_up").addEventListener("input", actionButton);

    function actionButton() {
        var password = $('#password_up').val();
        if (checkStrength(password) == "true") {
            $('#kt_update_password_submit').show();
            $('#kt_update_password_submit_disabled').hide();
        }else{
            $('#kt_update_password_submit').hide();
            $('#kt_update_password_submit_disabled').show();
        }    
    }

    $('#kt_update_password_submit').on('click', function (e) {
        //const form = document.getElementById('form-update-password');
        const form =  KTUtil.getById('kt_update_password_form');
        FormValidation.formValidation(
            form,
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
                    cpassword: {
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
                    submitButton: new FormValidation.plugins.SubmitButton(),
                }
            }
        ).on('core.form.valid', function() {
            
            FormValidation.utils.fetch(update_password_url, {
                method: 'POST',
                params: {
                    password_up: $('#password_up').val()
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            }).then(function(response) {
                if(response.success=="true"){
                    
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

                    $('.panel-logout').show();
                    $('.login-signin').hide();
                    
    
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
    });

});
