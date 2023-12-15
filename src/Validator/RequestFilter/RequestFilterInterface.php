<?php

namespace Kiri\Router\Validator\RequestFilter;

interface RequestFilterInterface
{


    /**
     * @param object $class
     * @param string $property
     * @return array
     */
    public function dispatch(object $class, string $property): array;

}