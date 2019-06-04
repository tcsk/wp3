<?php

namespace app\components\calendar\domain\contracts;

interface IEventList {

    /**
     * @param array $list
     * @return void
     */
    public function setEventList(array $list);

    /**
     * @return array
     */
    public function getEventList();
}