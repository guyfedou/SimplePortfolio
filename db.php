<?php

require_once 'config.php';

class DB {

    private $pdo;
    private $table;

    public function __construct() {

        $this->pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );

        $this->table = DB_PREFIX . "projects";
    }

    // CREATE
    public function create($title, $summary, $content, $images = []) {

        $sql = "INSERT INTO {$this->table} 
                (title, summary, content, images)
                VALUES (:title, :summary, :content, :images)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'title' => $title,
            'summary' => $summary,
            'content' => $content,
            'images' => json_encode($images)
        ]);

        return $this->pdo->lastInsertId();
    }

    // READ ALL
    public function getAll() {

        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$row) {
            $row['images'] = json_decode($row['images'], true);
        }

        return $results;
    }

    // READ ONE
    public function get($id) {

        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $row['images'] = json_decode($row['images'], true);
        }

        return $row;
    }

    // UPDATE
    public function update($id, $title, $summary, $content, $images = []) {

        $sql = "UPDATE {$this->table} 
                SET title = :title,
                    summary = :summary,
                    content = :content,
                    images = :images
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'summary' => $summary,
            'content' => $content,
            'images' => json_encode($images)
        ]);
    }

    // DELETE
    public function delete($id) {

        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    public function login($username, $password) {

	    $table = DB_PREFIX . "users";

	    $sql = "SELECT * FROM {$table} WHERE username = :username LIMIT 1";
	    $stmt = $this->pdo->prepare($sql);

	    $stmt->execute(['username' => $username]);

	    $user = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($user && password_verify($password, $user['password'])) {
		    return $user;
	    }

	    return false;
    }

}
