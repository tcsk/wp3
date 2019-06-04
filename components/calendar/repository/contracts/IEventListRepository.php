<?php

namespace app\components\calendar\repository\contracts;

use app\components\calendar\domain\contracts\IEventList;

interface IEventListRepository {
    /**
     * @return IEventList
     */
    public function getEventList();
}