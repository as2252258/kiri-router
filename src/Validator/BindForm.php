<?php

namespace Kiri\Router\Validator;

use Exception;
use Kiri\Di\Interface\InjectParameterInterface;
use Kiri\Router\Base\Middleware;
use Kiri\Router\Interface\ValidatorInterface;
use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class BindForm implements InjectParameterInterface
{


    /**
     * @param string $formValidate
     */
    public function __construct(readonly public string $formValidate)
    {
    }


    /**
     * @param string $class
     * @param string $method
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public function dispatch(string $class, string $method): object
    {
        $validator = new Validator();
        $container = \Kiri::getDi();
        $reflect   = $container->getReflectionClass($this->formValidate);
        $object    = $validator->setFormData($reflect->newInstanceWithoutConstructor());
        foreach ($reflect->getProperties() as $property) {
            foreach ($property->getAttributes() as $attribute) {
                if (!class_exists($attribute->getName())) {
                    continue;
                }
                $rule = \inject($attribute->newInstance());
                if ($rule instanceof ValidatorInterface) {
                    $validator->addRule($property->getName(), $rule);
                }
            }
            if (!$property->hasDefaultValue()) {
                $this->insertDefaultValue($property->getType(), $object, $property->getName());
            }
        }

        $middleware            = \instance(ValidatorMiddleware::class);
        $middleware->validator = $validator;
        $container->get(Middleware::class)->set($class, $method, $middleware);

        return $validator->getFormData();
    }


    /**
     * @param ReflectionNamedType|ReflectionUnionType $reflectionProperty
     * @param object $object
     * @param string $property
     * @return void
     * @throws Exception
     */
    private function insertDefaultValue(ReflectionNamedType|ReflectionUnionType $reflectionProperty, object $object, string $property): void
    {
        if ($reflectionProperty->allowsNull()) {
            $object->{$property} = null;
        } else if ($reflectionProperty instanceof ReflectionUnionType) {
            $object->{$property} = $this->defaultValue($reflectionProperty->getTypes()[0]);
        } else {
            $object->{$property} = $this->defaultValue($reflectionProperty);
        }
    }


    /**
     * @param ReflectionNamedType $type
     * @return array|false|int|string
     * @throws Exception
     */
    private function defaultValue(ReflectionNamedType $type): array|false|int|string
    {
        return match ($type->getName()) {
            'array'  => [],
            'int'    => 0,
            'bool'   => false,
            'string' => '',
            default  => throw new Exception('暂不支持')
        };
    }


}
