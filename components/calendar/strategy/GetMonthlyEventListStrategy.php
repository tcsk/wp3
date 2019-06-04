<?php

namespace app\components\calendar\strategy;

use DateTime;

class GetMonthlyEventListStrategy extends AGetEventListStrategy {

    public function getEventList() {
        return $this->eventListDAO->getEventList(new DateTime('2019-05-01 00:00:00'), new DateTime('2019-05-31 24:00:00'));
    }
}