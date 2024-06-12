<?php

namespace app\event;

class CustomerChangeTypeEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Customer type changed');
    }
}