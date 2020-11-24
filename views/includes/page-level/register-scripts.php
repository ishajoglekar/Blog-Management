<link rel="stylesheet" href="<?=BASEASSETS?>css/plugins/toastr/toastr.min.css">

<script src ="<?=BASEASSETS?>js/plugins/toastr/toastr.min.js"></script>




<script>

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "100000",
  
  "timeOut": "100000",
  "extendedTimeOut": "100000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

<?php

    if(Session::hasSession(SIGNIN_ERROR)):
?>
    toastr.error("Invaid Login Credentials!!","INVALID");

<?php
    Session::unsetSession(SIGNIN_ERROR);

    elseif(Session::hasSession('csrf')):
?>

toastr.error("Unauthorized Access, Token Mismatch","Unauthorized Access");
<?php
    Session::unsetSession('csrf');

    endif;
?>

</script>