<?php

interface EventListenerInterface
{
    public function attachEvent(string $className, callable $callback): void;
    public function detouchEvent(string $className): void;
}
