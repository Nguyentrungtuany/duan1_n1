<?php
require_once './commons/function.php';

class GuidesModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
}
