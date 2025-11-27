<?php
class BookingModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function getAllBookings()
    {
        $sql = "SELECT 
    b.*,

    /* =======================
            TOUR
    ======================== */
    JSON_OBJECT(
        'id', t.id,
        'name', t.name,
        'price', t.price,
        'status', t.status,
        'description', t.description
    ) AS tour,

    /* =======================
            CATEGORY
    ======================== */
    JSON_OBJECT(
        'id', c.id,
        'name', c.name,
        'description', c.description
    ) AS category,

    /* =======================
            DESTINATION
    ======================== */
    JSON_OBJECT(
        'id', d.id,
        'name', d.name,
        'location', d.location,
        'description', d.description
    ) AS destination,

    /* =======================
            CUSTOMER
    ======================== */
    JSON_OBJECT(
        'id', cu.id,
        'full_name', cu.full_name,
        'phone', cu.phone,
        'email', cu.email,
        'address', cu.address,
        'type', cu.type,
        'note', cu.note
    ) AS customer,

    /* =======================
            GUIDE (from guides)
    ======================== */
    JSON_OBJECT(
        'id', g.id,
        'full_name', g.full_name,
        'specialization', g.specialization,
        'experience_years', g.experience_years,
        'certificates', g.certificates,
        'languages', g.languages
    ) AS guide,

    /* =======================
            USER (from users)
    ======================== */
    JSON_OBJECT(
        'id', u.id,
        'username', u.username,
        'email', u.email,
        'phone', u.phone,
        'role', u.role,
        'status', u.status
    ) AS user,

    /* ========== SUB QUERY ========== */
    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', tr.id,
                'type', tr.type,
                'company', tr.company,
                'seats', tr.seats
            )
        )
        FROM transports tr
        WHERE tr.booking_id = b.id
    ) AS transports,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', bp.id,
                'fullname', bp.fullname,
                'phone', bp.phone,
                'date', bp.date
            )
        )
        FROM bookings_people bp
        WHERE bp.booking_id = b.id
    ) AS people,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', s.id,
                'day_number', s.day_number,
                'date', s.date,
                'location', s.location,
                'activities', s.activities,
                'guide_id', s.guide_id,
                'status', s.status,
                'notes', s.notes
            )
        )
        FROM schedules s
        WHERE s.booking_id = b.id
    ) AS schedules,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', cs.id,
                'customer_id', cs.customer_id,
                'guide_id', cs.guide_id,
                'message', cs.message,
                'status', cs.status,
                'created_at', cs.created_at
            )
        )
        FROM customer_support cs
        WHERE cs.booking_id = b.id
    ) AS customer_support,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', a.id,
                'tour_id', a.tour_id,
                'booking_id', a.booking_id,
                'name', a.name,
                'address', a.address,
                'type', a.type,
                'created_at', a.created_at,
                'updated_at', a.updated_at
            )
        )
        FROM accommodations a
        WHERE a.booking_id = b.id
    ) AS accommodations,

    (
        SELECT COUNT(*)
        FROM bookings_people bp
        WHERE bp.booking_id = b.id
    ) AS number_of_people

FROM bookings b
LEFT JOIN tours t ON t.id = b.tour_id
LEFT JOIN tour_categories c ON c.id = t.category_id
LEFT JOIN destinations d ON d.id = t.destination_id
LEFT JOIN customers cu ON cu.id = b.customer_id

/* =========================
       NEW: JOIN GUIDE
========================= */
LEFT JOIN guides g ON g.id = b.guide_id

/* =========================
       NEW: JOIN USER GUIDE
========================= */
LEFT JOIN users u ON u.id = g.user_id;

";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBookingById($id)
    {
        $sql = "SELECT 
    b.*,

    /* =======================
            TOUR
    ======================== */
    JSON_OBJECT(
        'id', t.id,
        'name', t.name,
        'price', t.price,
        'status', t.status,
        'description', t.description
    ) AS tour,

    /* =======================
            CATEGORY
    ======================== */
    JSON_OBJECT(
        'id', c.id,
        'name', c.name,
        'description', c.description
    ) AS category,

    /* =======================
            DESTINATION
    ======================== */
    JSON_OBJECT(
        'id', d.id,
        'name', d.name,
        'location', d.location,
        'description', d.description
    ) AS destination,

    /* =======================
            CUSTOMER
    ======================== */
    JSON_OBJECT(
        'id', cu.id,
        'full_name', cu.full_name,
        'phone', cu.phone,
        'email', cu.email,
        'address', cu.address,
        'type', cu.type,
        'note', cu.note
    ) AS customer,

    /* =======================
            GUIDE (from guides)
    ======================== */
    JSON_OBJECT(
        'id', g.id,
        'full_name', g.full_name,
        'specialization', g.specialization,
        'experience_years', g.experience_years,
        'certificates', g.certificates,
        'languages', g.languages
    ) AS guide,

    /* =======================
            USER (from users)
    ======================== */
    JSON_OBJECT(
        'id', u.id,
        'username', u.username,
        'email', u.email,
        'phone', u.phone,
        'role', u.role,
        'status', u.status
    ) AS user,

    /* ========== SUB QUERY ========== */
    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', tr.id,
                'type', tr.type,
                'company', tr.company,
                'seats', tr.seats
            )
        )
        FROM transports tr
        WHERE tr.booking_id = b.id
    ) AS transports,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', bp.id,
                'fullname', bp.fullname,
                'phone', bp.phone,
                'date', bp.date
            )
        )
        FROM bookings_people bp
        WHERE bp.booking_id = b.id
    ) AS people,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', s.id,
                'day_number', s.day_number,
                'date', s.date,
                'location', s.location,
                'activities', s.activities,
                'guide_id', s.guide_id,
                'status', s.status,
                'notes', s.notes
            )
        )
        FROM schedules s
        WHERE s.booking_id = b.id
    ) AS schedules,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', cs.id,
                'customer_id', cs.customer_id,
                'guide_id', cs.guide_id,
                'message', cs.message,
                'status', cs.status,
                'created_at', cs.created_at
            )
        )
        FROM customer_support cs
        WHERE cs.booking_id = b.id
    ) AS customer_support,

    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', a.id,
                'tour_id', a.tour_id,
                'booking_id', a.booking_id,
                'name', a.name,
                'address', a.address,
                'type', a.type,
                'created_at', a.created_at,
                'updated_at', a.updated_at
            )
        )
        FROM accommodations a
        WHERE a.booking_id = b.id
    ) AS accommodations,

    (
        SELECT COUNT(*)
        FROM bookings_people bp
        WHERE bp.booking_id = b.id
    ) AS number_of_people

FROM bookings b
LEFT JOIN tours t ON t.id = b.tour_id
LEFT JOIN tour_categories c ON c.id = t.category_id
LEFT JOIN destinations d ON d.id = t.destination_id
LEFT JOIN customers cu ON cu.id = b.customer_id

/* =========================
       NEW: JOIN GUIDE
========================= */
LEFT JOIN guides g ON g.id = b.guide_id

/* =========================
       NEW: JOIN USER GUIDE
========================= */
LEFT JOIN users u ON u.id = g.user_id

WHERE b.id = :id;
";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateBooking($id, $data)
    {
        $sql = "UPDATE `bookings` SET 
            `tour_id` = :tour_id,
            `guide_id` = :guide_id,
            `payment_status` = :payment_status,
            `status` = :status,
            `special_request` = :special_request,
            `start_date` = :start_date,
            `end_date` = :end_date,
            `updated_at` = NOW()
        WHERE `id` = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tour_id' => $data['tour_id'],
            ':guide_id' => $data['guide_id'],
            ':payment_status' => $data['payment_status'],
            ':status' => $data['status'],
            ':special_request' => $data['special_request'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':id' => $id
        ]);
    }

    // ===== TRANSPORTS METHODS =====

    public function updateTransports($transportId, $bookingId, $data)
    {
        $sql = "UPDATE `transports` SET 
            `type` = :type,
            `company` = :company,
            `seats` = :seats
        WHERE `id` = :id AND `booking_id` = :booking_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':type' => $data['type'],
            ':company' => $data['company'],
            ':seats' => $data['seats'],
            ':id' => $transportId,
            ':booking_id' => $bookingId
        ]);
    }

    public function createTransports($bookingId, $data)
    {
        $sql = "INSERT INTO `transports` 
            (`booking_id`, `type`, `company`, `seats`) 
        VALUES (:booking_id, :type, :company, :seats)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':booking_id' => $bookingId,
            ':type' => $data['type'],
            ':company' => $data['company'],
            ':seats' => $data['seats'],
        ]);
    }

    public function deleteTransports($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM `transports` WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $bookingId]);
        } else {
            $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
            $sql = "DELETE FROM `transports` 
                WHERE `booking_id` = ? 
                AND `id` NOT IN ($placeholders)";

            $params = array_merge([$bookingId], $keepIds);
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        }
    }

    // ===== ACCOMMODATIONS METHODS =====

    public function updateAccommodations($accommodationId, $bookingId, $data)
    {
        $sql = "UPDATE `accommodations` SET 
            `name` = :name,
            `address` = :address,
            `type` = :type
        WHERE `id` = :id AND `booking_id` = :booking_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':type' => $data['type'],
            ':id' => $accommodationId,
            ':booking_id' => $bookingId
        ]);
    }

    public function createAccommodations($bookingId, $data)
    {
        $sql = "INSERT INTO `accommodations` 
            (`booking_id`, `name`, `address`, `type`) 
        VALUES (:booking_id, :name, :address, :type)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':booking_id' => $bookingId,
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':type' => $data['type'],
        ]);
    }

    public function deleteAccommodations($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM `accommodations` WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $bookingId]);
        } else {
            $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
            $sql = "DELETE FROM `accommodations` 
                WHERE `booking_id` = ? 
                AND `id` NOT IN ($placeholders)";

            $params = array_merge([$bookingId], $keepIds);
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        }
    }

    // ===== SCHEDULES METHODS =====

    public function updateSchedules($scheduleId, $bookingId, $data)
    {
        $sql = "UPDATE `schedules` SET 
            `day_number` = :day_number,
            `date` = :date,
            `location` = :location,
            `activities` = :activities,
            `notes` = :notes
        WHERE `id` = :id AND `booking_id` = :booking_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':day_number' => $data['day_number'],
            ':date' => $data['date'],
            ':location' => $data['location'],
            ':activities' => $data['activities'],
            ':notes' => $data['notes'],
            ':id' => $scheduleId,
            ':booking_id' => $bookingId
        ]);
    }

    public function createSchedules($bookingId, $data)
    {
        $sql = "INSERT INTO `schedules` 
            (`booking_id`, `day_number`, `date`, `location`, `activities`, `notes`) 
        VALUES (:booking_id, :day_number, :date, :location, :activities, :notes)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':booking_id' => $bookingId,
            ':day_number' => $data['day_number'],
            ':date' => $data['date'],
            ':location' => $data['location'],
            ':activities' => $data['activities'],
            ':notes' => $data['notes'],
        ]);
    }

    public function deleteSchedules($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM `schedules` WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $bookingId]);
        } else {
            $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
            $sql = "DELETE FROM `schedules` 
                WHERE `booking_id` = ? 
                AND `id` NOT IN ($placeholders)";

            $params = array_merge([$bookingId], $keepIds);
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        }
    }

    // ===== HELPER METHODS =====

    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function createBooking($data)
    {
        $sql = "INSERT INTO bookings (tour_id, start_date, end_date, special_request)
            VALUES (:tour_id, :start_date, :end_date, :special_request)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);

        return $this->conn->lastInsertId();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addPerson($data)
    {
        $sql = "INSERT INTO bookings_people (booking_id, fullname, date, phone)
            VALUES (:booking_id, :fullname, :date, :phone)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }


    public function allCategory()
    {
        $sql = "SELECT * FROM `tour_categories`";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function allDestination()
    {
        $sql = "SELECT * FROM `destinations`";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function allTour()
    {
        $sql = "SELECT 
    t.*,
    c.name AS category_name,
    d.name AS destination_name
    FROM tours t
    LEFT JOIN tour_categories c ON t.category_id = c.id
    LEFT JOIN destinations d ON t.destination_id = d.id
    ORDER BY t.id DESC;
    ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function allGuide()
    {
        $sql = "SELECT 
    g.*,
    u.id AS user_id,
    u.username,
    u.full_name AS user_full_name,
    u.email,
    u.phone,
    u.role,
    u.status
FROM guides g
LEFT JOIN users u ON u.id = g.user_id;
";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
}
