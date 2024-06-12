<?php

namespace app\event;

class FaxOutgoingEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Outgoing fax');
    }
}