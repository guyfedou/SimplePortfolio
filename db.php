<?php

require_once __DIR__ . '/config.php';

class DB {

	private $pdo;
	private $projects;
	private $users;
	private $config;

	public function __construct() {

		$this->pdo = new PDO(
				"mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
				DB_USER,
				DB_PASS,
				[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
				]
				);

		$this->projects = DB_PREFIX . "projects";
		$this->users = DB_PREFIX . "users";
		$this->config = DB_PREFIX . "config";
	}

	//PROJECTS

	public function getProjects() {

		$stmt = $this->pdo->query("SELECT * FROM {$this->projects} ORDER BY created_at DESC");

		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

	//	foreach ($data as &$row) {
		//	$row['images'] = json_decode($row['images'], true);
		//}

		return $data;
	}

	public function getProject($id) {

		$stmt = $this->pdo->prepare("SELECT * FROM {$this->projects} WHERE id = ?");
		$stmt->execute([$id]);

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function createProject($title, $summary, $content, $images = []) {

		$stmt = $this->pdo->prepare("
				INSERT INTO {$this->projects}
				(title, summary, content, images)
				VALUES (?, ?, ?, ?)
				");

		$stmt->execute([
				$title,
				$summary,
				$content,
				json_encode($images)
		]);

		return $this->pdo->lastInsertId();
	}

	public function updateProject($id, $title, $summary, $content, $images = []) {

		$stmt = $this->pdo->prepare("
				UPDATE {$this->projects}
				SET title = ?, summary = ?, content = ?, images = ?
				WHERE id = ?
				");

		return $stmt->execute([
				$title,
				$summary,
				$content,
				json_encode($images),
				$id
		]);
	}

	public function deleteProject($id) {

		$stmt = $this->pdo->prepare("
				DELETE FROM {$this->projects}
				WHERE id = ?
				");

		return $stmt->execute([$id]);
	}


	//USERS

	public function createUser($username, $password) {

		$password = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $this->pdo->prepare("
				INSERT INTO {$this->users}
				(username, password)
				VALUES (?, ?)
				");

		return $stmt->execute([$username, $password]);
	}

	public function login($username, $password) {

		$stmt = $this->pdo->prepare("
				SELECT * FROM {$this->users}
				WHERE username = ?
				LIMIT 1
				");

		$stmt->execute([$username]);

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($user && password_verify($password, $user['password'])) {
			return $user;
		}

		return false;
	}

	//CONFIG

	public function getConfig($key) {

		$stmt = $this->pdo->prepare("
				SELECT value FROM {$this->config}
				WHERE `config_key` = ?
				");

		$stmt->execute([$key]);

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row ? $row['value'] : null;
	}

	public function setConfig($key, $value) {

		$stmt = $this->pdo->prepare("
				INSERT INTO {$this->config} (`config_key`, `value`)
				VALUES (?, ?)
				ON DUPLICATE KEY UPDATE value = VALUES(value)
				");

		return $stmt->execute([$key, $value]);
	}

	public function deleteConfig($key) {

		$stmt = $this->pdo->prepare("
				DELETE FROM {$this->config}
				WHERE `config_key` = ?
				");

		return $stmt->execute([$key]);
	}

	public function getAllConfig() {

		$stmt = $this->pdo->query("
				SELECT `config_key`, `value` FROM {$this->config}
				");

				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$config = [];

				foreach ($rows as $row) {
					$config[$row['config_key']] = $row['value'];
				}

				return $config;
	}

}
