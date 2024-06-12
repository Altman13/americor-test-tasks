<?php

namespace app\event;

class TaskCreatedEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Task created');
    }
}