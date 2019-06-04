<?php

namespace app\components\calendar\repository;

use app\components\calendar\factory\contracts\IEventListFactory;
use app\components\calendar\repository\contracts\IEventListRepository;
use app\components\calendar\strategy\contracts\GetEventListStrategy;

class EventListRepository implements IEventListRepository {

    private $_getEventListStrategy;
    private $_eventListFactory;

    public function __construct(GetEventListStrategy $gels, IEventListFactory $elf) {
        $this->_getEventListStrategy = $gels;
        $this->_eventListFactory = $elf;
    }

    public function getEventList() {
        $eventList = $this->_getEventListStrategy->getEventList();
        return $this->_eventListFactory->makeNewList($eventList);
    }
}