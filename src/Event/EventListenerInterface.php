<?php

namespace Event;

interface EventListenerInterface
{
    public function handle($event);
}