<?php

namespace Kiri\Router\Validator;

use Exception;
use Kiri\Di\Inject\Config;
use Kiri\Di\Inject\Container;
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
use Kiri\Server\ServerInterface;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;
use function inject;

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
            $ignoring = $property->getAttributes(Ignoring::class);
            $comment  = $property->getDocComment();
            if (count($ignoring) > 0 || ($comment && str_contains($comment, '@deprecated'))) {
                continue;
            }

            $this->properties($validator, $property, $object);
        }

        $middleware            = \instance(ValidatorMiddleware::class);
        $middleware->validator = $validator;
        $container->get(Middleware::class)->set($class, $method, $middleware);

        return $validator->getFormData();
    }


    /**
     * @param Validator $validator
     * @param ReflectionProperty $property
     * @param object $object
     * @return void
     * @throws Exception
     */
    protected function properties(Validator $validator, ReflectionProperty $property, object $object): void
    {
        $propertyContainer = $property->getAttributes(Container::class);
        if (count($propertyContainer) > 0) {
            ($propertyContainer[0]->newInstance())->dispatch($object, $property->getName());
        }


        $propertyConfig = $property->getAttributes(Config::class);
        if (count($propertyConfig) > 0) {
            ($propertyConfig[0]->newInstance())->dispatch($object, $property->getName());
        }

        $binding = $property->getAttributes(Binding::class);
        if (count($binding) > 0) {
            /** @var Binding $rule */
            $rule = $binding[0]->newInstance();

            $validator->addRule($property->getName(), $rule->dispatch($object, $property->getName()));
            $validator->setAlias($property->getName(), $rule->field);
        }

        $validator->addRule($property->getName(), [[$this->_typeValidator($property), 'dispatch', false]]);
    }


    /**
     * @param ReflectionProperty $property
     * @return TypesProxy
     * @throws Exception
     */
    private function _typeValidator(ReflectionProperty $property): TypesProxy
    {
        $getType = $property->getType();
        if (is_null($getType)) {
            $service = \Kiri::getDi();
            if ($service->has(ServerInterface::class)) {
                $service->get(ServerInterface::class)->shutdown();
            }
            throw new Exception('Field ' . $property->getDeclaringClass()->getName() . '::' . $property->getName() . ' must have a numerical type set.');
        }
        $array = ['allowsNull' => $property->getType()->allowsNull()];
        if (!$getType instanceof ReflectionUnionType) {
            $array = array_merge($array, ['class' => $this->_typeProxy($getType)]);
        } else {
            $types = [];
            foreach ($getType->getTypes() as $type) {
                $types[] = $type->getName();
            }
            $array = array_merge($array, ['types' => $types, 'class' => MixedProxy::class]);
        }
        return \Kiri::createObject($array);
    }


    /**
     * @param ReflectionNamedType $type
     * @return string|null
     */
    private function _typeProxy(ReflectionNamedType $type): ?string
    {
        return match ($type->getName()) {
            'array'  => ArrayProxy::class,
            'bool'   => BoolProxy::class,
            'float'  => FloatProxy::class,
            'int'    => IntProxy::class,
            'string' => StringProxy::class,
            default  => null
        };
    }

}
