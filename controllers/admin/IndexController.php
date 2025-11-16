<?php

require_once './models/admin/IndexModel.php';
class IndexController
{
    public $indexModel;
    public function __construct()
    {
        $this->indexModel = new IndexModel();
    }
    public function index()
    {
        require_once './views/admin/IndexAdmin.php';
    }
    public function QlTuor()
    {
        $DataQltour = $this->indexModel->QlTour();
        // print_r($DataQltour);
        require_once './views/admin/QlTour.php';
    }
    public function editQltour($id)
    {
        $DataQltour = $this->indexModel->QlTour();
        $id = $_GET['id'];
        $DataQltour = $this->indexModel->findTour($id);
        $allCategory = $this->indexModel->allCategory();
        require_once './views/admin/edit-qltour.php';
    }
    public function updateqltour()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'start_date' => $_POST['start_date'],
                'category_id' => $_POST['category_id'],
                'description' => $_POST['description'],
                'end_date' => $_POST['end_date'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
                'transports' => [],
                'accommodations' => [],
                'schedules' => [],
            ];
            $id = $_POST['id'];
            $return = $this->indexModel->updateqltour($id, $data);

            if (isset($_POST['transports'])) {
                foreach ($_POST['transports'] as $transport) {
                    $data = [
                        'type' => $transport['type'],
                        'company' => $transport['company'],
                        'seats' => $transport['seats'],
                    ];
                    $this->indexModel->updatetransports($id, $data);
                }
            }
            if (isset($_POST['accommodations'])) {
                foreach ($_POST['accommodations'] as $accommodation) {
                    $data = [
                        'name' => $accommodation['name'],
                        'address' => $accommodation['address'],
                        'type' => $accommodation['type'],
                    ];
                    $this->indexModel->updateaccommodations($id, $data);
                }
            }
            // echo "<pre>";
            // var_dump($_POST['schedules']);
            // echo "</pre>";
            // exit(1);
            if (isset($_POST['schedules'])) {
                $Idschedules = [];
                foreach ($_POST['schedules'] as $schedule) {
                    if (isset($schedule['id']) && !empty($schedule['id'])) {
                        $Idschedules[] = $schedule['id'];

                        $data = [
                            'day_number' => $schedule['day_number'],
                            'date' => $schedule['date'],
                            'location' => $schedule['location'],
                            'activities' => $schedule['activities'],
                            'notes' => $schedule['notes'],
                        ];
                        $this->indexModel->updateschedules($schedule['id'], $id, $data);
                    } else {
                        // DEBUG: Xem data trước khi insert
                        echo "<pre>Creating new schedule with data:";
                        print_r($schedule);
                        echo "</pre>";

                        $data = [
                            'tour_id' => $id,
                            'day_number' => $schedule['day_number'],
                            'date' => $schedule['date'],
                            'location' => $schedule['location'],
                            'activities' => $schedule['activities'],
                            'notes' => $schedule['notes'],
                        ];
                        $this->indexModel->createshedules($id, $data);
                        $newId = $this->indexModel->getLastInsertId();
                        $Idschedules[] = $newId;
                    }
                }
                $this->indexModel->deleteshedules($id, $Idschedules);
            }
            if ($return) {
                header("Location: index.php?act=QlTour");
            } else {
                echo "Cập nhật thất bại";
            }
        }
    }
    public function deleteQltour($id)
    {
        $id = $_GET['id'];
        $return = $this->indexModel->deleteQltour($id);
        if ($return) {
            header("Location: index.php?act=QlTour");
        } else {
            echo "Xóa thất bại";
        }
    }
    public function addQltour()
    {
        require_once './views/admin/add-qltour.php';
    }
    public function createQltour()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
            ];
            $id = $_POST['id'];
            $return = $this->indexModel->createQltour($data);
            if ($return) {
                header("Location: index.php?act=QlTour");
            } else {
                echo "Them moi that bai";
            }
        }
    }
    public function test()
    {
        $data = $this->indexModel->test();
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        require_once './views/admin/test.php';
    }
}
