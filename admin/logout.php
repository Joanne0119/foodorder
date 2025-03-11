<?php
    include('../config/constants.php');
    session_destroy(); //unset the username session (other had already unset)
    header('location:'.SETURL.'admin/login.php');
?>