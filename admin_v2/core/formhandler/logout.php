<?php
    session_start();
    include '../../core/config.php';

    unset($_SESSION['user_id']);
    header("Location: " . $config['adminPath'] );
?>