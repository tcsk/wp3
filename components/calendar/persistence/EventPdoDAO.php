<?php


namespace app\components\calendar\persistence;

use app\components\calendar\persistence\contracts\EventDAO;
use yii\base\InvalidArgumentException;
use \Yii;

class EventPdoDAO implements EventDAO {

    private $_table_name = 'scedule';
    private $_pdo;

    public function __construct() {
        $this->_pdo = Yii::$app->getDb()->pdo;
    }

    public function findById(int $id) {
        $this->checkId($id);
        $stmt = $this->_pdo->prepare("SELECT * FROM $this->_table_name WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    private function checkId(int $id) {
        if ($id < 1) {
            throw new InvalidArgumentException('The $id parameter must be positive integer.');
        }
    }

    public function findNext() {
        $stmt = $this->_pdo->prepare("SELECT * FROM $this->_table_name WHERE deadline > NOW() ORDER BY deadline LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function save(array $data) {
        $sql = "INSERT INTO $this->_table_name (title, deadline, course_id, created_by, updated_by) VALUES (:title, :deadline, :course_id, :created_by, :updated_by)";
        $stmt = $this->_pdo->prepare($sql);
        $stmt->execute($data);
        return $this->_pdo->lastInsertId();
    }

    public function delete(int $id) {
        $this->checkId($id);
        $stmt = $this->_pdo->prepare("DELETE FROM $this->_table_name WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function update(array $data) {
        $sql = "UPDATE $this->_table_name SET title=:title, deadline=:deadline, course_id=:course_id, created_by=:created_by, updated_by=:updated_by WHERE id=:id";
        $stmt= $this->_pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }
}