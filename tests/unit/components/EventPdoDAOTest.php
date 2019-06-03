<?php

namespace tests\unit\models;

use Codeception\Test\Unit;
use app\components\calendar\persistence\EventPdoDAO;

class EventPdoDAOTest extends Unit {

    public function testFindEventByIdIsSuccessfulWithCorrectId() {
        $eventDAO = new EventPdoDAO();
        $event = $eventDAO->findById(1);
        expect($event['title'])->equals('Konzultáció');
    }

    public function testFindEventByIdReturnsNullWithWrongId() {
        $eventDAO = new EventPdoDAO();
        $event = $eventDAO->findById(10);
        expect($event)->equals(null);
    }

    /**
     * @expectedException TypeError
     */
    public function testFindEventByIdThrowsTypeErrorExceptionWithIncorrectParamType() {
        $eventDAO = new EventPdoDAO();
        $eventDAO->findById('a');
    }

    /** @noinspection PhpFullyQualifiedNameUsageInspection */

    /**
     * @expectedException \yii\base\InvalidArgumentException
     * @expectedExceptionMessage The $id parameter must be positive integer.
     */
    public function testFindEventByIdThrowsInvalidArgumentExceptionWithNegativeId() {
        $eventDAO = new EventPdoDAO();
        $eventDAO->findById(-1);
    }

    public function testSaveIsSuccessfulWithCorrectData() {
        $data = [
            'title' => 'Unit test 1',
            'deadline' => '2018-10-23 00:00:00',
            'course_id' => 3,
            'created_by' => 1,
            'updated_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        expect($id = $eventDAO->save($data));
        $event = $eventDAO->findById($id);
        expect($event['title'])->equals('Unit test 1');
    }

    /**
     * @expectedException PDOException
     */
    public function testSaveThrowsPDOExceptionWithIncorrectParamNumber() {
        $data = [
            'title' => 'Unit test 2',
            'course_id' => 3,
            'created_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        $eventDAO->save($data);
    }

    /**
     * @expectedException PDOException
     */
    public function testSaveThrowsPDOExceptionWithInvalidParamType() {
        $data = [
            'title' => 'Unit test 3',
            'deadline' => '2018-10-23 00:00:00',
            'course_id' => 'a',
            'created_by' => 1,
            'updated_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        $eventDAO->save($data);
    }

    /**
     * @expectedException PDOException
     */
    public function testSaveThrowsPDOExceptionWithNonExistingRelation() {
        $data = [
            'title' => 'Unit test 4',
            'deadline' => '2018-10-23 00:00:00',
            'course_id' => 3,
            'created_by' => 100,
            'updated_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        $eventDAO->save($data);
    }

    public function testFindNextEventReturnsNullIfNotExists() {
        $eventDAO = new EventPdoDAO();
        $event = $eventDAO->findNext();
        expect($event)->equals(null);
    }

    public function testFindNextEventReturnsCorrectDataIfExists() {
        $startDate = time();
        $date = date('Y-m-d H:i:s', strtotime('+1 day', $startDate));
        $eventDAO = new EventPdoDAO();
        $data = [
            'title' => 'Unit test 5',
            'deadline' => $date,
            'course_id' => 3,
            'created_by' => 1,
            'updated_by' => 1,
        ];
        $eventDAO->save($data);
        $event = $eventDAO->findNext();
        expect($event['title'])->equals('Unit test 5');
    }

    public function testDeleteEventIsSuccessfulWithCorrectId() {
        $eventDAO = new EventPdoDAO();
        expect($eventDAO->delete(1));
        expect($eventDAO->findById(1))->equals(null);
    }

    public function testDeleteEventReturnsFalseWithNonExistingId() {
        $eventDAO = new EventPdoDAO();
        expect($eventDAO->delete(10))->false();
    }

    public function testUpdateIsSuccessfulWithCorrectData() {
        $data = [
            'id' => 1,
            'title' => 'Unit test 1',
            'deadline' => '2018-10-23 00:00:00',
            'course_id' => 3,
            'created_by' => 1,
            'updated_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        expect($eventDAO->update($data));
        $event = $eventDAO->findById($data['id']);
        expect($event['title'])->equals('Unit test 1');
    }

    public function testUpdateReturnsFalseWithNonExistingId() {
        $data = [
            'id' => 100,
            'title' => 'Unit test 1',
            'deadline' => '2018-10-23 00:00:00',
            'course_id' => 3,
            'created_by' => 1,
            'updated_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        expect($eventDAO->update($data))->false();
    }

    /**
     * @expectedException PDOException
     */
    public function testUpdateThrowsPDOExceptionWithIncorrectParamNumber() {
        $data = [
            'id' => 1,
            'title' => 'Unit test 2',
            'course_id' => 3,
            'created_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        $eventDAO->update($data);
    }

    /**
     * @expectedException PDOException
     */
    public function testUpdateThrowsPDOExceptionWithInvalidParamType() {
        $data = [
            'id' => 1,
            'title' => 'Unit test 3',
            'deadline' => '2018-10-23 00:00:00',
            'course_id' => 'a',
            'created_by' => 1,
            'updated_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        $eventDAO->update($data);
    }

    /**
     * @expectedException PDOException
     */
    public function testUpdateThrowsPDOExceptionWithNonExistingRelation() {
        $data = [
            'id' => 1,
            'title' => 'Unit test 4',
            'deadline' => '2018-10-23 00:00:00',
            'course_id' => 3,
            'created_by' => 100,
            'updated_by' => 1,
        ];
        $eventDAO = new EventPdoDAO();
        $eventDAO->update($data);
    }

}
