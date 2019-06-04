<?php

namespace app\components\calendar\strategy;

use DateTime;

class GetWeeklyEventListStrategy extends AGetEventListStrategy {

    public function getEventList() {
        return $this->eventListDAO->getEventList(new DateTime('2019-05-06 00:00:00'), new DateTime('2019-05-12 24:00:00'));
    }
}