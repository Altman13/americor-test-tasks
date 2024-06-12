<?php

namespace app\event;

class TaskUpdatedEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Task updated');
    }
}