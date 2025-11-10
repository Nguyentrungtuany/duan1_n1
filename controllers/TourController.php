<?php
require_once './models/ProductModel.php';
class TourController
{
    public function Index()
    {
        require_once './views/home.php';
    }
    public function Login()
    {
        require_once './views/login.php';
    }
}
