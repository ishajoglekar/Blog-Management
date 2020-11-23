<link rel="stylesheet" href="<?=BASEASSETS?>css/plugins/toastr/toastr.min.css">
<script src="<?=BASEASSETS?>js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src ="<?=BASEASSETS?>js/plugins/toastr/toastr.min.js"></script>

<script>

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
"hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


<?php
// Util::dd("hi");
    if(Session::hasSession('EMAIL_ERROR')):
?>
    toastr.error("Entered Email is Invalid","INVALID");

<?php
    Session::unsetSession('EMAIL_ERROR');
    elseif(Session::hasSession('EMAIL_SENT')):
        
?>
toastr.success("RESET LINK HAS BEEN SENT TO YOUR EMAIL","SENT");

<?php
// Util::redirect("dashboard/forgot-password.php");

    Session::unsetSession('EMAIL_SENT');
    elseif(Session::hasSession('NETWORK_ERROR')):
?>

toastr.error("Please Try Again!","INVALID");
<?php
    
    Session::unsetSession('NETWORK_ERROR');
    elseif(Session::hasSession('csrf')):
?>

toastr.error("Unauthorized Access, Token Mismatch","Unauthorized Access");
<?php
    Session::unsetSession('csrf');

    endif;
?>

</script>