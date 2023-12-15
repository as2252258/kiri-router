<?php

namespace Kiri\Router\Validator;

use Exception;
use Kiri\Di\Interface\InjectParameterInterface;
use Kiri\Router\Base\Middleware;
use Kiri\Router\Validator\RequestFilter\RequestFilterInterface;
use Kiri\Router\Validator\Types\ArrayProxy;
use Kiri\Router\Validator\Types\BoolProxy;
use Kiri\Router\Validator\Types\FloatProxy;
use Kiri\Router\Validator\Types\IntProxy;
use Kiri\Router\Validator\Types\MixedProxy;
use Kiri\Router\Validator\Types\StringProxy;
use Kiri\Router\Validator\Types\TypesProxy;
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
     * @throws
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
                if ($rule instanceof RequestFilterInterface) {
                    $validator->addRule($property->getName(), $rule->dispatch($object, $property->getName()));
                }
            }

            $typeProxy        = $this->_typeValidator($property);
            $validator->addRule($property->getName(), [$typeProxy, false]);
        }

        $middleware            = \instance(ValidatorMiddleware::class);
        $middleware->validator = $validator;
        $container->get(Middleware::class)->set($class, $method, $middleware);

        return $validator->getFormData();
    }


    /**
     * @param \ReflectionProperty $property
     * @return object
     * @throws Exception
     */
    private function _typeValidator(\ReflectionProperty $property): TypesProxy
    {
        $getType = $property->getType();
        $array   = ['allowsNull' => $property->getType()->allowsNull()];
        if (!$getType instanceof ReflectionUnionType) {
            return \Kiri::createObject(array_merge($array, [
                'class' => $this->_typeProxy($getType)
            ]));
        }
        $types = [];
        foreach ($getType->getTypes() as $type) {
            $types[] = $type->getName();
        }
        return \Kiri::createObject(array_merge($array, [
            'types' => $types,
            'class' => MixedProxy::class
        ]));
    }


    /**
     * @param ReflectionNamedType $type
     * @return string
     */
    private function _typeProxy(ReflectionNamedType $type): string
    {
        return match ($type->getName()) {
            'array'  => ArrayProxy::class,
            'bool'   => BoolProxy::class,
            'float'  => FloatProxy::class,
            'int'    => IntProxy::class,
            'string' => StringProxy::class,
        };
    }

}
