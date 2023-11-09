<?php

namespace Kiri\Router\Validator;

use Exception;
use Kiri\Di\Interface\InjectParameterInterface;
use Kiri\Router\Base\Middleware;
use Kiri\Router\Interface\ValidatorInterface;
use ReflectionException;

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
        $validator->setFormData($reflect->newInstanceWithoutConstructor());
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
        }

        $middleware            = \instance(ValidatorMiddleware::class);
        $middleware->validator = $validator;
        $container->get(Middleware::class)->set($class, $method, $middleware);

        return $validator->getFormData();
    }

}
