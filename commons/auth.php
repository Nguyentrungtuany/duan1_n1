<?php

class Auth
{

    public static function checkadmin()
    {
        // var_dump($_SESSION['user']['role']);
        // // exit(1);
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {

            header('Location: index.php?act=logout');
            exit();
        }
    }

    public static function checkguide()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'guide') {
            header('Location: index.php?act=logout');
            exit();
        }
    }
}
