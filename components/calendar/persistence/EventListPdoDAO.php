<?php

namespace app\components\calendar\persistence;

use app\components\calendar\persistence\contracts\EventListDAO;
use DateTime;
use PDO;

class EventListPdoDAO implements EventListDAO {

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

    public function getEventList(DateTime $start, DateTime $finish) {
        $stmt = $this->_pdo->prepare("SELECT * FROM $this->_table WHERE deadline BETWEEN :start AND :finish");
        $stmt->execute([
            'start' => $start->format('Y-m-d H:i:s'),
            'finish' => $finish->format('Y-m-d H:i:s')
        ]);
        return $stmt->fetchAll();
    }
}