<?php

namespace app\components\calendar\strategy;

use app\components\calendar\persistence\contracts\EventListDAO;
use app\components\calendar\strategy\contracts\GetEventListStrategy;

abstract class AGetEventListStrategy implements GetEventListStrategy {

    protected $eventListDAO;

    public function __construct(EventListDAO $eld) {
        $this->eventListDAO = $eld;
    }
}