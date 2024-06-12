<?php

namespace app\event;

class CustomerChangeQualityEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Customer quality changed');
    }
}