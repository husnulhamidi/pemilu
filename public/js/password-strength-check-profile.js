$(document).ready(function () {
   
    $('#passkey').keyup(function () {
      var password = $('#passkey').val();
      if (checkStrength(password) == false) {
        $('#btn-update-profile').attr('disabled', true);
      }
      $('#btn-update-profile').attr('disabled', false);
    });
    
    $('#confirm-password').blur(function () {
      if ($('#password').val() !== $('#confirm-password').val()) {
        $('#popover-cpassword').removeClass('hide');
        $('#btn-update-profile').attr('disabled', true);
      } else {
        $('#popover-cpassword').addClass('hide');
        $('#btn-update-profile').attr('disabled', false);
      }
    });
  

  
    function checkStrength(password) {
      var strength = 0;
  
      if($('.fa-check').length < 4) {
        $('#btn-update-profile').addClass('disabled');
        console.log('contains both lower and uppercase', $('.fa-check').length);
      }else{
        $('#btn-update-profile').removeClass('disabled');
      }
  
      //If password contains both lower and uppercase characters, increase strength value.
      if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        strength += 2;
        $('.low-upper-case').addClass('text-success');
        $('.low-upper-case i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');
        $('#btn-update-profile').removeClass('disabled');
      } else {
        $('.low-upper-case').removeClass('text-success');
        $('.low-upper-case i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
        $('#btn-update-profile').addClass('disabled');
      }
  
      //If it has numbers and characters, increase strength value.
      if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
        strength += 2;
        $('.one-number').addClass('text-success');
        $('.one-number i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');
        $('#btn-update-profile').removeClass('disabled');
  
      } else {
        $('.one-number').removeClass('text-success');
        $('.one-number i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
        $('#btn-update-profile').addClass('disabled');
      }
  
      //If it has one special character, increase strength value.
      if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 2;
        $('.one-special-char').addClass('text-success');
        $('.one-special-char i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');
        $('#btn-update-profile').removeClass('disabled');
  
      } else {
        $('.one-special-char').removeClass('text-success');
        $('.one-special-char i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
        $('#btn-update-profile').addClass('disabled');
      }
  
      if (password.length >= 8) {
        strength += 2;
        $('.eight-character').addClass('text-success');
        $('.eight-character i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');
        $('#btn-update-profile').removeClass('disabled');
  
      } else {
        $('.eight-character').removeClass('text-success');
        $('.eight-character i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
        $('#btn-update-profile').addClass('disabled');
      }
  
  
  
  
      // If value is less than 2
  
      if (strength < 8) {
        $('#result').removeClass()
        $('#password-strength').addClass('progress-bar-danger');
        
        $('#result').addClass('text-danger').text('Very Week');
        $('#password-strength').css('width', '10%');
      } else if (strength == 2) {
        $('#result').addClass('good');
        $('#password-strength').removeClass('progress-bar-danger');
        $('#password-strength').addClass('progress-bar-warning');
        $('#result').addClass('text-warning').text('Week')
        $('#password-strength').css('width', '60%');
        return 'Week'
      } else if (strength == 4) {
        $('#result').removeClass()
        $('#result').addClass('strong');
        $('#password-strength').removeClass('progress-bar-warning');
        $('#password-strength').addClass('progress-bar-success');
        $('#result').addClass('text-success').text('Strength');
        $('#password-strength').css('width', '100%');
  
        return 'Strong'
      }
  
    }
  
  });