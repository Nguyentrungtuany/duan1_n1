<?php
require_once './models/guides/IndexGuideModel.php';

class GuidesController
{
    public function index()
    {
        // $model = new IndexModel();
        // $data = $model->index();

        require_once './views/guides/indexGuide.php';
    }
}
