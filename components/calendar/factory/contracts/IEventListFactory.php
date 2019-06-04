<?php

namespace app\components\calendar\factory\contracts;

use app\components\calendar\domain\contracts\IEventList;

interface IEventListFactory {

    /**
     * @param array $list
     * @return IEventList
     */
    public function makeNewList(array $list);

    /**
     * @param string $period
     * @return IEventList
     */
    public function makeListByPeriodLength(string $period);
}