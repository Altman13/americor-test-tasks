<?php

namespace app\event;

class MessageIncomingEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Incoming message');
    }
}
