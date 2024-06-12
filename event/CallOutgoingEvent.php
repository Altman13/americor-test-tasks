<?php

namespace app\event;

class CallOutgoingEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Outgoing call');
    }
}