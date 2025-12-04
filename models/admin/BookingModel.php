<?php
class BookingModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }
    // ==========================================
    // HELPER METHOD
    // ==========================================

    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    // ==========================================
    // LẤY DANH SÁCH VÀ CHI TIẾT BOOKING
    // ==========================================

    public function getAllBookings()
    {
        $sql = "SELECT 
            b.*,
            JSON_OBJECT(
                'id', t.id,
                'name', t.name,
                'price', t.price,
                'status', t.status,
                'description', t.description
            ) AS tour,
            JSON_OBJECT(
                'id', c.id,
                'name', c.name,
                'description', c.description
            ) AS category,
            JSON_OBJECT(
                'id', d.id,
                'name', d.name,
                'location', d.location,
                'description', d.description
            ) AS destination,
            JSON_OBJECT(
                'id', cu.id,
                'full_name', cu.full_name,
                'phone', cu.phone,
                'email', cu.email,
                'address', cu.address,
                'type', cu.type,
                'note', cu.note
            ) AS customer,
            JSON_OBJECT(
                'id', g.id,
                'full_name', g.full_name,
                'specialization', g.specialization,
                'experience_years', g.experience_years,
                'certificates', g.certificates,
                'languages', g.languages
            ) AS guide,
            JSON_OBJECT(
                'id', u.id,
                'username', u.username,
                'email', u.email,
                'phone', u.phone,
                'role', u.role,
                'status', u.status
            ) AS user,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', tr.id, 'type', tr.type, 'company', tr.company, 'seats', tr.seats)
            ) FROM transports tr WHERE tr.booking_id = b.id) AS transports,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', bp.id, 'fullname', bp.fullname, 'phone', bp.phone, 'date', bp.date, 'cccd', bp.cccd)
            ) FROM bookings_people bp WHERE bp.booking_id = b.id) AS people,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', s.id, 'day_number', s.day_number, 'date', s.date, 
                'location', s.location, 'activities', s.activities, 'guide_id', s.guide_id, 
                'status', s.status, 'notes', s.notes)
            ) FROM schedules s WHERE s.tour_id = b.tour_id) AS schedules,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', cs.id, 'customer_id', cs.customer_id, 'guide_id', cs.guide_id, 
                'message', cs.message, 'status', cs.status, 'created_at', cs.created_at)
            ) FROM customer_support cs WHERE cs.booking_id = b.id) AS customer_support,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', a.id, 'tour_id', a.tour_id, 'booking_id', a.booking_id, 
                'name', a.name, 'address', a.address, 'type', a.type, 
                'created_at', a.created_at, 'updated_at', a.updated_at)
            ) FROM accommodations a WHERE a.booking_id = b.id) AS accommodations,
            (SELECT COUNT(*) FROM bookings_people bp WHERE bp.booking_id = b.id) AS number_of_people
        FROM bookings b
        LEFT JOIN tours t ON t.id = b.tour_id
        LEFT JOIN tour_categories c ON c.id = t.category_id
        LEFT JOIN destinations d ON d.id = t.destination_id
        LEFT JOIN customers cu ON cu.id = b.customer_id
        LEFT JOIN guides g ON g.id = b.guide_id
        LEFT JOIN users u ON u.id = g.user_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingById($id)
    {
        $sql = "SELECT 
            b.*,
            JSON_OBJECT(
                'id', t.id,
                'name', t.name,
                'price', t.price,
                'status', t.status,
                'description', t.description
            ) AS tour,
            JSON_OBJECT(
                'id', c.id,
                'name', c.name,
                'description', c.description
            ) AS category,
            JSON_OBJECT(
                'id', d.id,
                'name', d.name,
                'location', d.location,
                'description', d.description
            ) AS destination,
            JSON_OBJECT(
                'id', cu.id,
                'full_name', cu.full_name,
                'phone', cu.phone,
                'email', cu.email,
                'address', cu.address,
                'type', cu.type,
                'note', cu.note
            ) AS customer,
            JSON_OBJECT(
                'id', g.id,
                'full_name', g.full_name,
                'specialization', g.specialization,
                'experience_years', g.experience_years,
                'certificates', g.certificates,
                'languages', g.languages
            ) AS guide,
            JSON_OBJECT(
                'id', u.id,
                'username', u.username,
                'email', u.email,
                'phone', u.phone,
                'role', u.role,
                'status', u.status
            ) AS user,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', tr.id, 'type', tr.type, 'company', tr.company, 'seats', tr.seats)
            ) FROM transports tr WHERE tr.booking_id = b.id) AS transports,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', bp.id, 'fullname', bp.fullname, 'phone', bp.phone, 'date', bp.date ,'cccd', bp.cccd)
            ) FROM bookings_people bp WHERE bp.booking_id = b.id) AS people,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', s.id, 'day_number', s.day_number, 'date', s.date, 
                'location', s.location, 'activities', s.activities, 'guide_id', s.guide_id, 
                'status', s.status, 'notes', s.notes)
            ) FROM schedules s WHERE s.tour_id = b.tour_id) AS schedules,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', cs.id, 'customer_id', cs.customer_id, 'guide_id', cs.guide_id, 
                'message', cs.message, 'status', cs.status, 'created_at', cs.created_at)
            ) FROM customer_support cs WHERE cs.booking_id = b.id) AS customer_support,
            (SELECT JSON_ARRAYAGG(
                JSON_OBJECT('id', a.id, 'tour_id', a.tour_id, 'booking_id', a.booking_id, 
                'name', a.name, 'address', a.address, 'type', a.type, 
                'created_at', a.created_at, 'updated_at', a.updated_at)
            ) FROM accommodations a WHERE a.booking_id = b.id) AS accommodations,
            (SELECT COUNT(*) FROM bookings_people bp WHERE bp.booking_id = b.id) AS number_of_people
        FROM bookings b
        LEFT JOIN tours t ON t.id = b.tour_id
        LEFT JOIN tour_categories c ON c.id = t.category_id
        LEFT JOIN destinations d ON d.id = t.destination_id
        LEFT JOIN customers cu ON cu.id = b.customer_id
        LEFT JOIN guides g ON g.id = b.guide_id
        LEFT JOIN users u ON u.id = g.user_id
        WHERE b.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // CRUD BOOKING CHÍNH
    // ==========================================

    public function createBooking($data)
    {
        // ✅ THÊM guide_id VÀO SQL
        $sql = "INSERT INTO bookings (tour_id, guide_id, start_date, end_date, special_request)
            VALUES (:tour_id, :guide_id, :start_date, :end_date, :special_request)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $this->conn->lastInsertId();
    }

    public function updateBooking($id, $data)
    {
        $sql = "UPDATE bookings SET 
                tour_id = :tour_id,
                guide_id = :guide_id,
                payment_status = :payment_status,
                status = :status,
                special_request = :special_request,
                start_date = :start_date,
                end_date = :end_date,
                updated_at = NOW()
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ==========================================
    // TRANSPORTS - Phương tiện
    // ==========================================

    public function updateTransports($transportId, $bookingId, $data)
    {
        $sql = "UPDATE transports SET 
                type = :type,
                company = :company,
                seats = :seats
                WHERE id = :id AND booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'type' => $data['type'],
            'company' => $data['company'],
            'seats' => $data['seats'],
            'id' => $transportId,
            'booking_id' => $bookingId
        ]);
        return true;
    }

    public function createTransports($bookingId, $data)
    {
        $sql = "INSERT INTO transports (booking_id, type, company, seats) 
                VALUES (:booking_id, :type, :company, :seats)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $bookingId,
            'type' => $data['type'],
            'company' => $data['company'],
            'seats' => $data['seats']
        ]);
        return $this->conn->lastInsertId();
    }

    public function deleteTransports($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            // Xóa tất cả
            $sql = "DELETE FROM transports WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $bookingId]);
        }

        // Xóa những cái không có trong danh sách giữ lại
        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $sql = "DELETE FROM transports 
                WHERE booking_id = ? AND id NOT IN ($placeholders)";

        $params = array_merge([$bookingId], $keepIds);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ==========================================
    // ACCOMMODATIONS - Chỗ ở
    // ==========================================

    public function updateAccommodations($accommodationId, $bookingId, $data)
    {
        $sql = "UPDATE accommodations SET 
                name = :name,
                address = :address,
                type = :type
                WHERE id = :id AND booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $data['name'],
            'address' => $data['address'],
            'type' => $data['type'],
            'id' => $accommodationId,
            'booking_id' => $bookingId
        ]);
        return true;
    }

    public function createAccommodations($bookingId, $data)
    {
        $sql = "INSERT INTO accommodations (booking_id, name, address, type) 
                VALUES (:booking_id, :name, :address, :type)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $bookingId,
            'name' => $data['name'],
            'address' => $data['address'],
            'type' => $data['type']
        ]);
        return $this->conn->lastInsertId();
    }

    public function deleteAccommodations($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM accommodations WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $bookingId]);
        }

        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $sql = "DELETE FROM accommodations 
                WHERE booking_id = ? AND id NOT IN ($placeholders)";

        $params = array_merge([$bookingId], $keepIds);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ==========================================
    // PEOPLE - Người tham gia
    // ==========================================

    public function updatePeople($personId, $bookingId, $data)
    {
        $sql = "UPDATE bookings_people SET 
                fullname = :fullname,
                phone = :phone,
                date = :date,   
                cccd = :cccd
                WHERE id = :id AND booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'fullname' => $data['fullname'],
            'phone' => $data['phone'],
            'date' => $data['date'],
            'cccd' => $data['cccd'],
            'id' => $personId,
            'booking_id' => $bookingId
        ]);
        return true;
    }

    public function createPeople($bookingId, $data)
    {
        $sql = "INSERT INTO bookings_people (booking_id, fullname, phone, date, cccd) 
                VALUES (:booking_id, :fullname, :phone, :date, :cccd)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'booking_id' => $bookingId,
            'fullname' => $data['fullname'],
            'phone' => $data['phone'],
            'date' => $data['date'] ?? date('Y-m-d'),
            'cccd' => $data['cccd']
        ]);
        return $this->conn->lastInsertId();
    }

    public function deletePeople($bookingId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM bookings_people WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $bookingId]);
        }

        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $sql = "DELETE FROM bookings_people 
                WHERE booking_id = ? AND id NOT IN ($placeholders)";

        $params = array_merge([$bookingId], $keepIds);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ==========================================
    // SCHEDULES - Lịch trình
    // ==========================================

    public function updateSchedules($scheduleId, $tourId, $data)
    {
        $sql = "UPDATE schedules SET 
                day_number = :day_number,
                date = :date,
                location = :location,
                activities = :activities,
                notes = :notes
                WHERE id = :id AND tour_id = :tour_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'day_number' => $data['day_number'],
            'date' => $data['date'],
            'location' => $data['location'],
            'activities' => $data['activities'],
            'notes' => $data['notes'],
            'id' => $scheduleId,
            'tour_id' => $tourId
        ]);
        return true;
    }

    public function createSchedules($tourId, $data)
    {
        $sql = "INSERT INTO bookings (
        tour_id, 
        guide_id, 
        start_date, 
        end_date, 
        special_request, 
        status,
        created_at
    ) VALUES (
        :tour_id, 
        :guide_id, 
        :start_date, 
        :end_date, 
        :special_request, 
        :status,
        NOW()
    )";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':tour_id' => $data['tour_id'],
            ':guide_id' => $data['guide_id'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':special_request' => $data['special_request'] ?? '',
            ':status' => $data['status'] ?? 'pending'
        ]);

        return $this->conn->lastInsertId();
    }

    public function deleteSchedules($tourId, $keepIds)
    {
        if (empty($keepIds)) {
            $sql = "DELETE FROM schedules WHERE tour_id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute(['id' => $tourId]);
        }

        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $sql = "DELETE FROM schedules 
            WHERE tour_id = ? AND id NOT IN ($placeholders)";

        $params = array_merge([$tourId], $keepIds);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // ==========================================
    // LẤY DANH SÁCH CHO FORM
    // ==========================================

    public function allCategory()
    {
        $sql = "SELECT * FROM tour_categories";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function allDestination()
    {
        $sql = "SELECT * FROM destinations";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function allTour()
    {
        $sql = "SELECT 
                t.*, 
                c.name AS category_name, 
                d.name AS destination_name,
                (SELECT JSON_ARRAYAGG(
                    JSON_OBJECT('id', s.id, 'day_number', s.day_number, 'date', s.date, 
                    'location', s.location, 'activities', s.activities, 'notes', s.notes, 
                    'status', s.status, 'guide_id', s.guide_id)
                ) FROM schedules s WHERE s.tour_id = t.id ORDER BY s.day_number) AS schedules
                FROM tours t
                LEFT JOIN tour_categories c ON t.category_id = c.id
                LEFT JOIN destinations d ON t.destination_id = d.id
                ORDER BY t.id DESC";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                LEFT JOIN users u ON u.id = g.user_id";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
}
