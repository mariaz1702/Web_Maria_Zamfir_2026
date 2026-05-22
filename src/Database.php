<?php
class Database {
    private $pdo;

    public function __construct() {
        $host = 'mysql_db'; $db = 'travel_blog'; $user = 'root'; $pass = 'toor';
        try {
            $this->pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
            $this->pdo->exec("USE $db");
            $this->initializeSchema();
            $this->initializeAdvancedFeatures();
        } catch (PDOException $e) { die("DB Error: " . $e->getMessage()); }
    }

    public function getConnection() { return $this->pdo; }

    private function initializeSchema() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS trips (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            location_name VARCHAR(255),
            image_path TEXT,
            uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS travel_audit (
            id INT AUTO_INCREMENT PRIMARY KEY,
            action_type VARCHAR(50),
            details TEXT,
            action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Admin default: travel123
        $stmt = $this->pdo->query("SELECT * FROM users WHERE username='admin'");
        if($stmt->rowCount() == 0) {
            $hash = password_hash('travel123', PASSWORD_DEFAULT);
            $this->pdo->exec("INSERT INTO users (username, password, role) VALUES ('admin', '$hash', 'admin')");
        }
    }

    private function initializeAdvancedFeatures() {
        $this->pdo->exec("DROP TRIGGER IF EXISTS trg_LogTripDelete;");
        $this->pdo->exec("CREATE TRIGGER trg_LogTripDelete AFTER DELETE ON trips FOR EACH ROW 
            BEGIN INSERT INTO travel_audit (action_type, details) VALUES ('DELETE', OLD.location_name); END;");
    }
}