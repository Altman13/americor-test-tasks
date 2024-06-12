<?php
namespace app\factories;

use app\event\{
    TaskCreatedEvent,
    TaskUpdatedEvent,
    TaskCompletedEvent,
    MessageIncomingEvent,
    MessageOutgoingEvent,
    CallIncomingEvent,
    CallOutgoingEvent,
    FaxIncomingEvent,
    FaxOutgoingEvent,
    CustomerChangeTypeEvent,
    CustomerChangeQualityEvent
};

class EventFactory
{
    public static function createEvent($model)
    {
        switch ($model->event) {
            case 'created_task':
                return new TaskCreatedEvent($model);
            case 'updated_task':
                return new TaskUpdatedEvent($model);
            case 'completed_task':
                return new TaskCompletedEvent($model);
            case 'incoming_sms':
                return new MessageIncomingEvent($model);
            case 'outgoing_sms':
                return new MessageOutgoingEvent($model);
            case 'incoming_call':
                return new CallIncomingEvent($model);
            case 'outgoing_call':
                return new CallOutgoingEvent($model);
            case 'incoming_fax':
                return new FaxIncomingEvent($model);
            case 'outgoing_fax':
                return new FaxOutgoingEvent($model);
            case 'customer_change_type':
                return new CustomerChangeTypeEvent($model);
            case 'customer_change_quality':
                return new CustomerChangeQualityEvent($model);
            default:
                throw new \InvalidArgumentException('Unknown event type');
        }
    }
}