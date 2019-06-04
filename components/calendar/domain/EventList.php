<?php

namespace app\components\calendar\domain;

use app\components\calendar\domain\contracts\IEventList;

class EventList implements IEventList {

    private $_eventList;

    /**
     * @param array $list
     * @return void
     */
    public function setEventList(array $list) {
        $this->_eventList = $list;
    }

    /**
     * @return array
     */
    public function getEventList() {
        return $this->_eventList;
    }
}