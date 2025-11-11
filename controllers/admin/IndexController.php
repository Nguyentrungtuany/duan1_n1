<?php
require_once './models/admin/IndexModel.php';
class IndexController
{
    public function index()
    {
        require_once './views/admin/IndexAdmin.php';
    }
    public function tables()
    {
        require_once './views/admin/tables.php';
    }
}
