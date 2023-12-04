<?php

namespace Kiri\Router\Validator\Inject;


#[\Attribute(\Attribute::TARGET_PROPERTY)] class Binding
{


    public function __construct(public string $field)
    {
    }


    /**
     * @param mixed $data
     * @param object $class
     * @return void
     */
    public function dispatch(mixed $data, object $class): void
    {
        // TODO: Implement dispatch() method.
    }

}