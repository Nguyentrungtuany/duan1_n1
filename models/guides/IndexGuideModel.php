<?php
require_once './commons/function.php';

class GuidesModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function jobinformation($booking_id)
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
       JOIN GUIDE
========================= */
INNER JOIN guides g ON g.id = b.guide_id

/* =========================
       JOIN USER GUIDE
========================= */
INNER JOIN users u ON u.id = g.user_id

/* =========================
       ⭐ FILTER BY USER_ID
========================= */
WHERE g.user_id = $booking_id";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function getBookingById($booking_id)
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
    INNER JOIN guides g ON g.id = b.guide_id
    INNER JOIN users u ON u.id = g.user_id
    WHERE b.id = :booking_id"; // ← Filter theo booking_id

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // ← fetch() không phải fetchAll()
    }
    public function jobStatus($user_id)
    {
        $sql = "
        SELECT 
            COUNT(*) as total_records,
            SUM(CASE WHEN b.payment_status = 'unpaid' THEN 1 ELSE 0 END) as total_unpaid,
            SUM(CASE WHEN b.payment_status = 'paid' THEN 1 ELSE 0 END) as total_paid,
            SUM(CASE WHEN b.status = 'pending' THEN 1 ELSE 0 END) as total_pending,
            SUM(CASE WHEN b.status = 'confirmed' THEN 1 ELSE 0 END) as total_confirmed,
            SUM(CASE WHEN b.status = 'cancelled' THEN 1 ELSE 0 END) as total_cancelled,
            SUM(CASE WHEN b.status = 'completed' THEN 1 ELSE 0 END) as total_completed
        FROM bookings b
        INNER JOIN guides g ON g.id = b.guide_id
        WHERE g.user_id = $user_id
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function booking_people($booking_id)
    {
        $sql = "SELECT *
FROM bookings_people
WHERE booking_id = $booking_id;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
