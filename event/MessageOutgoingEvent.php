<?php

namespace app\event;

class MessageOutgoingEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Outgoing message');
    }
}