<?php

namespace app\event;

class FaxIncomingEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Incoming fax');
    }
}