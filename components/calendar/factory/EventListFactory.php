<?php

namespace app\components\calendar\factory;

use app\components\calendar\domain\contracts\IEventList;
use app\components\calendar\domain\EventList;
use app\components\calendar\factory\contracts\IEventListFactory;
use app\components\calendar\persistence\EventListPdoDAO;
use app\components\calendar\repository\EventListRepository;
use app\components\calendar\strategy\GetMonthlyEventListStrategy;
use app\components\calendar\strategy\GetWeeklyEventListStrategy;
use Yii;
use yii\base\InvalidArgumentException;

class EventListFactory implements IEventListFactory {
    /**
     * @param array $list
     * @return IEventList
     */
    public function makeNewList(array $list) {
        $eventList = new EventList();
        $eventList->setEventList($list);
        return $eventList;
    }

    /**
     * @param string $period
     * @return IEventList
     */
    public function makeListByPeriodLength(string $period) {
        $dao = new EventListPdoDAO(Yii::$app->getDb()->getMasterPdo());
        switch ($period) {
            case 'weekly':
                $strategy = new GetWeeklyEventListStrategy($dao);
                break;
            case 'monthly':
                $strategy = new GetMonthlyEventListStrategy($dao);
                break;
            default:
                throw new InvalidArgumentException('$period param must be "weekly" or "monthly"');
        }

        $repository = new EventListRepository($strategy, $this);
        return $repository->getEventList();
    }
}