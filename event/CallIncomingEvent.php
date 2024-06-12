<?php

namespace app\event;

class CallIncomingEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Incoming call');
    }
}
