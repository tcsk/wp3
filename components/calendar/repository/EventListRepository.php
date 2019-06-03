<?php


namespace app\components\calendar\repository;


use app\components\calendar\repository\contracts\IEventListRepository;
use app\components\calendar\strategy\contracts\GetEventListStrategy;

class EventListRepository implements IEventListRepository {

    private $_getEventListStrategy;

    public function __construct(GetEventListStrategy $gels) {
        $this->_getEventListStrategy = $gels;
    }

    public function getEventList() {
        return $this->_getEventListStrategy->getEventList();
    }
}