<?php
require_once './models/admin/BookingModel.php';
class BookingController
{
    public $BookingModel;
    public function __construct()
    {
        $this->BookingModel = new BookingModel();
    }
    public function index()
    {
        $bookings = $this->BookingModel->getAllBookings();
        // var_dump($bookings);
        require_once './views/admin/booking/list.php';
    }
    public function edit()
    {
        $id = $_GET['id'];
        $booking = $this->BookingModel->getBookingById($id);
        $allCategory = $this->BookingModel->allCategory();
        $allDestination = $this->BookingModel->allDestination();
        $allTour = $this->BookingModel->allTour();
        $allGuide = $this->BookingModel->allGuide();
        require_once './views/admin/booking/edit.php';
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: index.php?act=bookings");
            exit;
        }

        try {
            $id = $_POST['id'];

            // Cập nhật booking chính
            $bookingData = [
                'tour_id' => $_POST['tour_id'],
                'category_id' => $_POST['category_id'],
                'guide_id' => $_POST['guide_id'],
                'payment_status' => $_POST['payment_status'],
                'special_request' => $_POST['special_request'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
            ];

            $this->BookingModel->updateBooking($id, $bookingData);

            // ===== XỬ LÝ TRANSPORTS =====
            if (isset($_POST['transports'])) {
                $keepIds = [];

                foreach ($_POST['transports'] as $transport) {
                    if (!empty($transport['type']) || !empty($transport['company'])) {

                        if (isset($transport['id']) && !empty($transport['id'])) {
                            // UPDATE existing
                            $keepIds[] = $transport['id'];
                            $data = [
                                'type' => $transport['type'],
                                'company' => $transport['company'],
                                'seats' => $transport['seats'],
                            ];
                            $this->BookingModel->updateTransports($transport['id'], $id, $data);
                        } else {
                            // CREATE new
                            $data = [
                                'type' => $transport['type'],
                                'company' => $transport['company'],
                                'seats' => $transport['seats'],
                                'booking_id' => $id,
                            ];
                            $this->BookingModel->createTransports($id, $data);
                            $keepIds[] = $this->BookingModel->getLastInsertId();
                        }
                    }
                }

                // DELETE những cái không còn trong form
                $this->BookingModel->deleteTransports($id, $keepIds);
            }

            // ===== XỬ LÝ ACCOMMODATIONS =====
            if (isset($_POST['accommodations'])) {
                $keepIds = [];

                foreach ($_POST['accommodations'] as $accommodation) {
                    if (!empty($accommodation['name'])) {

                        if (isset($accommodation['id']) && !empty($accommodation['id'])) {
                            // UPDATE
                            $keepIds[] = $accommodation['id'];
                            $data = [
                                'name' => $accommodation['name'],
                                'address' => $accommodation['address'],
                                'type' => $accommodation['type'],
                            ];
                            $this->BookingModel->updateAccommodations($accommodation['id'], $id, $data);
                        } else {
                            // CREATE
                            $data = [
                                'name' => $accommodation['name'],
                                'address' => $accommodation['address'],
                                'type' => $accommodation['type'],
                                'booking_id' => $id,
                            ];
                            $this->BookingModel->createAccommodations($id, $data);
                            $keepIds[] = $this->BookingModel->getLastInsertId();
                        }
                    }
                }

                $this->BookingModel->deleteAccommodations($id, $keepIds);
            }

            // ===== XỬ LÝ SCHEDULES =====
            if (isset($_POST['schedules'])) {
                $keepIds = [];

                foreach ($_POST['schedules'] as $schedule) {
                    if (!empty($schedule['location']) || !empty($schedule['activities'])) {

                        if (isset($schedule['id']) && !empty($schedule['id'])) {
                            // UPDATE
                            $keepIds[] = $schedule['id'];
                            $data = [
                                'day_number' => $schedule['day_number'],
                                'date' => $schedule['date'],
                                'location' => $schedule['location'],
                                'activities' => $schedule['activities'],
                                'notes' => $schedule['notes'],
                            ];
                            $this->BookingModel->updateSchedules($schedule['id'], $id, $data);
                        } else {
                            // CREATE
                            $data = [
                                'booking_id' => $id,
                                'day_number' => $schedule['day_number'],
                                'date' => $schedule['date'],
                                'location' => $schedule['location'],
                                'activities' => $schedule['activities'],
                                'notes' => $schedule['notes'],
                            ];
                            $this->BookingModel->createSchedules($id, $data);
                            $keepIds[] = $this->BookingModel->getLastInsertId();
                        }
                    }
                }

                $this->BookingModel->deleteSchedules($id, $keepIds);
            }

            header("Location: index.php?act=bookings&msg=success");
            exit;
        } catch (Exception $e) {
            echo "Lỗi cập nhật: " . $e->getMessage();
            error_log("Booking Update Error: " . $e->getMessage());
        }
    }

    public function add()
    {
        $allTour = $this->BookingModel->allTour();
        require_once './views/admin/booking/add.php';
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $tour_id = $_POST['tour_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $special_request = $_POST['special_request'];



            // 1. Lưu booking vào bảng bookings
            $booking_id = $this->BookingModel->createBooking([
                'tour_id' => $tour_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'special_request' => $special_request
            ]);
            $people = [
                'booking_id' => $booking_id,
                'fullname' => $_POST['fullname'],
                'date' => $_POST['date'],
                'phone' => $_POST['phone'],
            ];


            // 2. Lưu danh sách người đi vào bảng bookings_people
            $this->BookingModel->addPerson($people);

            header("Location: index.php?act=bookings");
            exit();
        }
    }
    public function delete()
    {
        $id = $_GET['id'];
        $return = $this->BookingModel->delete($id);
        if ($return) {
            header("Location: index.php?act=bookings");
        } else {
            echo "Xóa thất bại";
        }
    }
    public function detail()
    {
        $id = $_GET['id'];
        $booking = $this->BookingModel->getBookingById($id);
        require_once './views/admin/booking/detail.php';
    }
}
