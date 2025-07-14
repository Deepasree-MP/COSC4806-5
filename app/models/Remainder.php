<?php
require_once 'app/database.php';

class Remainder {
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function get_all_remainders() {
        $stmt = $this->db->prepare("SELECT * FROM remainders");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_all_remainders_by_id($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM remainders WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_remainder_by_id($id) {
        $stmt = $this->db->prepare("SELECT * FROM remainders WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create_remainder($user_id, $subject, $description) {
        $stmt = $this->db->prepare(
            "INSERT INTO remainders (user_id, subject, description, status) 
             VALUES (:user_id, :subject, :description, 1)"
        );
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update_remainder($id, $subject, $description) {
        $stmt = $this->db->prepare(
            "UPDATE remainders 
             SET subject = :subject, 
                 description = :description, 
                 updated_at = CURRENT_TIMESTAMP, 
                 status = 1, 
                 deleted_at = CASE WHEN status = 2 THEN NULL ELSE deleted_at END 
             WHERE id = :id"
        );
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete_remainder($id) {
        $stmt = $this->db->prepare(
            "UPDATE remainders 
             SET deleted_at = CURRENT_TIMESTAMP, status = 2 
             WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function complete_remainder($id) {
        $stmt = $this->db->prepare(
            "UPDATE remainders 
             SET completed_at = CURRENT_TIMESTAMP, status = 0 
             WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getReminderCountsPerUser() {
        $stmt = $this->db->prepare("
            SELECT users.username, COUNT(remainders.id) AS total_reminders
            FROM users
            LEFT JOIN remainders ON users.id = remainders.user_id
            GROUP BY users.username
            ORDER BY total_reminders DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
