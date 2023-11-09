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
        $reflect   = \Kiri::getDi()->getReflectionClass($this->formValidate);
        $validator->setFormData($reflect->newInstanceWithoutConstructor());
        foreach ($reflect->getProperties() as $property) {
            foreach ($property->getAttributes() as $attribute) {
                if (!class_exists($attribute->getName())) {
                    continue;
                }
                $rule = $attribute->newInstance();
                if ($rule instanceof ValidatorInterface) {
                    $validator->addRule($property->getName(), $rule);
                }
            }
        }

        $middleware            = \instance(ValidatorMiddleware::class);
        $middleware->validator = $validator;

        $manager = \Kiri::getDi()->get(Middleware::class);
        $manager->set($class, $method, $middleware);

        return $validator->getFormData();
    }

}
