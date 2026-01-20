<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByUsername($username) {
        $stmt = $this->conn->prepare("SELECT u.*, r.name AS role 
                                      FROM {$this->table} u 
                                      JOIN roles r ON u.role_id = r.id 
                                      WHERE u.username = ? LIMIT 1");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function create($username, $password, $roleId) {
        $sql = "INSERT INTO {$this->table} (username, password, role_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$username, $password, $roleId]);
    }

    public function getAll() {
        $sql = "SELECT u.id, u.username, r.name AS role 
                FROM {$this->table} u 
                JOIN roles r ON u.role_id = r.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT u.id, u.username, r.name AS role 
                                      FROM {$this->table} u 
                                      JOIN roles r ON u.role_id = r.id 
                                      WHERE u.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $roleId) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET username=?, role_id=? WHERE id=?");
        return $stmt->execute([$username, $roleId, $id]);
    }

    public function updatePassword($id, $password) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET password=? WHERE id=?");
        return $stmt->execute([$password, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
