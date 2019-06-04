<?php

namespace app\components\calendar\persistence\contracts;

use DateTime;

interface EventListDAO {
    /**
     * @param DateTime $start
     * @param DateTime $finish
     * @return array
     */
    public function getEventList(DateTime $start, DateTime $finish);
}