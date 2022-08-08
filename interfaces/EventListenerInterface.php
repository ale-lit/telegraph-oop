<?php

interface EventListenerInterface
{
    function attachEvent(string $className, callable $callback): void;
    function detouchEvent(string $className): void;
}
