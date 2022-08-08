<?php

require_once './interfaces/EventListenerInterface.php';

abstract class User implements EventListenerInterface
{
    protected $id;
    protected $name;
    protected $role;

    abstract public function getTextsToEdit();
}
