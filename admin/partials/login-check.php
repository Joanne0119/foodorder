<?php
    if(!(isset($_SESSION['user']))){
        // if the user is not login
        $_SESSION['no-login-message'] = '<div class="fail">Please login to access Admin Panel</div>';
        header('location:'.SETURL.'admin/login.php');
    }

?>