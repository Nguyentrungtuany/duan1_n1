<?php
require_once './commons/function.php';
class IndexModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function QlTour()
    {
        $sql = "SELECT t.*, c.name AS category_name, 
        JSON_OBJECT('id', d.id, 'name', d.name, 'location', d.location)
        AS destination, (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', tr.id, 'type', tr.type, 'company', tr.company, 'seats', tr.seats)) 
        FROM transports tr WHERE tr.tour_id = t.id) 
        AS transports, (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', ac.id, 'name', ac.name, 'address', ac.address, 'type', ac.type)) 
        FROM accommodations ac WHERE ac.tour_id = t.id) AS accommodations, 
        (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', sc.id, 'day_number', sc.day_number, 'date', sc.date, 'location', sc.location, 'activities', sc.activities, 'notes', sc.notes)) 
        FROM schedules sc WHERE sc.tour_id = t.id) AS schedules 
        FROM tours t LEFT JOIN tour_categories c ON t.category_id = c.id LEFT JOIN destinations d ON t.destination_id = d.id;";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function findTour($id)
    {
        $sql = "SELECT 
    t.*, 
    c.name AS category_name, 
    JSON_OBJECT('id', d.id, 'name', d.name, 'location', d.location) AS destination,

    (SELECT JSON_ARRAYAGG(JSON_OBJECT(
        'id', tr.id, 
        'type', tr.type, 
        'company', tr.company, 
        'seats', tr.seats
    )) FROM transports tr WHERE tr.tour_id = t.id) AS transports,

    (SELECT JSON_ARRAYAGG(JSON_OBJECT(
        'id', ac.id, 
        'name', ac.name, 
        'address', ac.address, 
        'type', ac.type
    )) FROM accommodations ac WHERE ac.tour_id = t.id) AS accommodations,

    (SELECT JSON_ARRAYAGG(JSON_OBJECT(
        'id', sc.id, 
        'day_number', sc.day_number, 
        'date', sc.date, 
        'location', sc.location, 
        'activities', sc.activities, 
        'notes', sc.notes
    )) FROM schedules sc WHERE sc.tour_id = t.id) AS schedules

FROM tours t
LEFT JOIN tour_categories c ON t.category_id = c.id
LEFT JOIN destinations d ON t.destination_id = d.id
WHERE t.id = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateqltour($id, $data)
    {
        // update table tour
        $sql = "UPDATE `tours` SET `name`= :name ,
        `category_id`= :category_id,`description`= :description,
        `start_date`= :start_date,`end_date`= :end_date,
        `price`= :price,`status`= :status WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':category_id' => $data['category_id'],
            ':description' => $data['description'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':price' => $data['price'],
            ':status' => $data['status'],
            ':id' => $id
        ]);
        return $stmt->execute();
    }

    // public function 

    public function updatetransports($id, $data)
    {
        $sql = "UPDATE `transports` SET `type`= :typetran ,
        `company`= :companytran,`seats`= :seatstran
        WHERE `id` = :id AND `tour_id` = :tour_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':typetran' => $data['type'],
            ':companytran' => $data['company'],
            ':seatstran' => $data['seats'],
            ':id' => $id,
            ':tour_id' => $id
        ]);
        return $stmt->execute();
    }

    public function updateaccommodations($id, $data)
    {
        $sql = "UPDATE `accommodations` SET `name`= :nameacc ,
        `address`= :addressacc,`type`= :typeacc WHERE `id` = :id AND `tour_id` = :tour_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nameacc' => $data['name'],
            ':addressacc' => $data['address'],
            ':typeacc' => $data['type'],
            ':id' => $id,
            ':tour_id' => $id
        ]);
        return $stmt->execute();
    }

    public function updateschedules($Idschedules, $id, $data)
    {
        $sql = "UPDATE `schedules` SET `day_number`=:day_numbersche,
        `date`=:datesche,`location`=:locationsche,`activities`=:activitiessche,
        `notes`=:notessche
        WHERE id = :id AND `tour_id` = :tour_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':day_numbersche' => $data['day_number'],
            ':datesche' => $data['date'],
            ':locationsche' => $data['location'],
            ':activitiessche' => $data['activities'],
            ':notessche' => $data['notes'],
            ':id' => $Idschedules,
            ':tour_id' => $id
        ]);
        return $stmt->execute();
    }

    public function createshedules($id, $data)
    {
        $sql = "INSERT INTO `schedules`
        (`tour_id`, `day_number`, `date`, `location`, `activities`, 
        `notes`) 
        VALUES (:tour_id, :day_number, :date, :location, :activities, :notes)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tour_id' => $id,
            ':day_number' => $data['day_number'],
            ':date' => $data['date'],
            ':location' => $data['location'],
            ':activities' => $data['activities'],
            ':notes' => $data['notes'],
        ]);
    }
    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }
    public function deleteshedules($id, $Idschedules)
    {
        if (empty($Idschedules)) {
            $sql = "DELETE FROM `schedules` WHERE tour_id = :id ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } else {
            $placeholders = implode(',', array_fill(0, count($Idschedules), '?'));
            $sql = "DELETE FROM `schedules` 
                WHERE `tour_id` = ? 
                AND `id` NOT IN ($placeholders)";

            $params = array_merge([$id], $Idschedules);
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
        }
    }
    public function deleteQltour($id)
    {
        $sql = "DELETE FROM `tours` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function createQltour($data)
    {
        $sql = "INSERT INTO `tours`(`id`, `name`, `category`, `description`, `start_date`, `end_date`, `price`, `status`) 
        VALUES (:id,:name,:category,:description,:start_date,:end_date,:price,:status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public function allCategory()
    {
        $sql = "SELECT * FROM `tour_categories`";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function test()
    {
        $sql = "SELECT t.*, c.name AS category_name, JSON_OBJECT('id', d.id, 'name', d.name, 'location', d.location) AS destination, (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', tr.id, 'type', tr.type, 'company', tr.company, 'seats', tr.seats)) FROM transports tr WHERE tr.tour_id = t.id) AS transports, (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', ac.id, 'name', ac.name, 'address', ac.address, 'type', ac.type)) FROM accommodations ac WHERE ac.tour_id = t.id) AS accommodations, (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', sc.id, 'day_number', sc.day_number, 'date', sc.date, 'location', sc.location, 'activities', sc.activities, 'notes', sc.notes)) FROM schedules sc WHERE sc.tour_id = t.id) AS schedules FROM tours t LEFT JOIN tour_categories c ON t.category_id = c.id LEFT JOIN destinations d ON t.destination_id = d.id;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
}
