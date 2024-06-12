<?php

namespace app\event;

interface EventInterface
{
    public function getEventText(): string;
}

abstract class BaseEvent implements EventInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
