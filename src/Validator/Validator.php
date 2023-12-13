<?php
declare(strict_types=1);

namespace Kiri\Router\Validator;

use Exception;
use Kiri\Router\Constrict\ConstrictRequest;
use Kiri\Router\Interface\ValidatorInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;


/**
 * class Validator
 */
class Validator
{


    /**
     * @var ValidatorInterface[]
     */
    protected array $rules = [];


    /**
     * @var string
     */
    protected string $message = '';


    /**
     * @var object
     */
    protected object $formData;


    /**
     * @var array
     */
    protected array $types = [];


    /**
     * @param object $formData
     * @return object
     */
    public function setFormData(object $formData): object
    {
        $this->formData = $formData;
        return $formData;
    }


    /**
     * @param string $property
     * @param ReflectionNamedType|ReflectionUnionType $types
     * @return void
     */
    public function setTypes(string $property, ReflectionNamedType|ReflectionUnionType $types): void
    {
        $this->types[$property] = $types;
    }


    /**
     * @return object
     */
    public function getFormData(): object
    {
        return $this->formData;
    }

    /**
     * @param string $name
     * @param ValidatorInterface $rule
     * @return void
     */
    public function addRule(string $name, ValidatorInterface $rule): void
    {
        if (!isset($this->rules[$name])) {
            $this->rules[$name] = [];
        }
        $this->rules[$name][] = $rule;
    }


    /**
     * @param RequestInterface|ServerRequestInterface|ConstrictRequest $request
     * @return bool
     * @throws
     */
    public function run(RequestInterface|ServerRequestInterface|ConstrictRequest $request): bool
    {
        if (!empty($this->message)) {
            return false;
        }
        $params = !$request->isPost() ? $request->getQueryParams() : $request->getParsedBody();

        foreach ($params as $name => $value) {
            if (!isset($this->types[$name])) {
                continue;
            }
            $rules = $this->rules[$name] ?? [];
            foreach ($rules as $item) {
                /** @var ValidatorInterface $item */
                if (!$item->dispatch($value, $this->formData)) {
                    return $this->addError($name);
                }
            }

            /** @var ReflectionNamedType|ReflectionUnionType $property */
            $property = $this->types[$name];
            if ($property instanceof ReflectionUnionType) {
                foreach ($property->getTypes() as $type) {
                    $typeName = $type->getName();
                    if ($typeName == 'string' && is_string($value)) {
                        $this->formData->{$name} = $value;
                        break;
                    } else if ($typeName == 'int' && $value == ($int = intval($value))) {
                        $this->formData->{$name} = $int;
                        break;
                    } else if ($typeName == 'bool' && in_array($value, ['true', 'false'])) {
                        $this->formData->{$name} = $value == 'true';
                        break;
                    } else if ($typeName == 'float' && $value == ($flo = floatval($value))) {
                        $this->formData->{$name} = $flo;
                        break;
                    } else if ($typeName == 'array' && is_array($value)) {
                        $this->formData->{$name} = $value;
                        break;
                    }
                }
                if ($this->formData->{$name} != $value) {
                    throw new Exception('Fail type value.');
                }
            } else {
                $this->formData->{$name} = match ($property->getName()) {
                    'int'   => (int)$value,
                    'float' => (float)$value,
                    'bool'  => $value == 'true',
                    'array' => $this->arrayCheck($property, $name, $value),
                    default => $value
                };
            }
        }
        return true;
    }


    /**
     * @param ReflectionNamedType $property
     * @param string $name
     * @param string|array $value
     * @return array
     * @throws Exception
     */
    protected function arrayCheck(ReflectionNamedType $property, string $name, string|array $value): array
    {
        if (empty($value) || !is_array($value)) {
            if ($property->allowsNull()) {
                $this->formData->{$name} = null;
            }
            throw new Exception('TypeError Cannot assign string to property ' . $name . ' of type array');
        }
        return $value;
    }


    /**
     * @param $field
     * @return bool
     */
    private function addError($field): bool
    {
        $this->message = 'Field ' . $field . ' value format fail.';
        return false;
    }


    /**
     * @return string
     */
    public function error(): string
    {
        return $this->message;
    }


}
