<?php

class Auth
{
    public static function checkadmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header('Location: index.php?act=login');
            exit();
        }
    }
    public static function checkhdv()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'hdv') {
            header('Location: index.php?act=login');
            exit();
        }
    }
}
