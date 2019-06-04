<?php

namespace app\components\calendar\persistence;

use app\components\calendar\persistence\contracts\EventDAO;
use PDO;
use yii\base\InvalidArgumentException;

class EventPdoDAO implements EventDAO {

    /**
     * @var string
     */
    private $_table = 'scedule';

    /**
     * @var PDO
     */
    private $_pdo;

    /**
     * EventPdoDAO constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo) {
        $this->_pdo = $pdo;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id) {
        $this->checkId($id);
        $stmt = $this->_pdo->prepare("SELECT * FROM $this->_table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * @return mixed
     */
    public function findNext() {
        $stmt = $this->_pdo->prepare("SELECT * FROM $this->_table WHERE deadline > NOW() ORDER BY deadline LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param array $data
     * @return string
     */
    public function save(array $data) {
        $sql = "INSERT INTO $this->_table (title, deadline, course_id, created_by, updated_by) VALUES (:title, :deadline, :course_id, :created_by, :updated_by)";
        $stmt = $this->_pdo->prepare($sql);
        $stmt->execute($data);
        return $this->_pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) {
        $this->checkId($id);
        $stmt = $this->_pdo->prepare("DELETE FROM $this->_table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data) {
        $sql = "UPDATE $this->_table SET title=:title, deadline=:deadline, course_id=:course_id, created_by=:created_by, updated_by=:updated_by WHERE id=:id";
        $stmt = $this->_pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }

    /**
     * @param int $id
     */
    private function checkId(int $id) {
        if ($id < 1) {
            throw new InvalidArgumentException('The $id parameter must be positive integer.');
        }
    }
}