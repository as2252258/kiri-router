<?php
declare(strict_types=1);

namespace Kiri\Router\Validator;

use Kiri;
use Kiri\Router\Constrict\ConstrictRequest;
use Kiri\Router\Interface\ValidatorInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;


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
     * @param object $formData
     * @return object
     */
    public function setFormData(object $formData): object
    {
        $this->formData = $formData;
        return $formData;
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
     * @throws ReflectionException
     * @throws \Exception
     */
    public function run(RequestInterface|ServerRequestInterface|ConstrictRequest $request): bool
    {
        if (!empty($this->message)) {
            return false;
        }
        $params = !$request->getIsPost() ? $request->getQueryParams() : $request->getParsedBody();
        $method = Kiri::getDi()->getReflectionClass($this->formData::class);

        foreach ($params as $name => $value) {
            if (!$method->hasProperty($name)) {
                continue;
            }
            $rules = $this->rules[$name] ?? [];
            foreach ($rules as $item) {
                /** @var ValidatorInterface $item */
                if (!$item->dispatch($value, $this->formData)) {
                    return $this->addError($name);
                }
            }
            $property = $method->getProperty($name);
            if ($property->getType() instanceof \ReflectionUnionType) {
                foreach ($property->getType()->getTypes() as $type) {
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
                    throw new \Exception('Fail type value.');
                }
            } else {
                $value = match ($property->getType()?->getName()) {
                    'int'   => (int)$value,
                    'float' => (float)$value,
                    'bool' => $value == 'true',
                    default => $value
                };
            }
            if ($value === 'Null') {
                $value = null;
            }
            $this->formData->{$name} = $value;
        }
        return true;
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
