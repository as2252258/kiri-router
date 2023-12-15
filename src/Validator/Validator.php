<?php
declare(strict_types=1);

namespace Kiri\Router\Validator;

use Exception;
use Kiri\Router\Constrict\ConstrictRequest;
use Kiri\Router\Interface\ValidatorInterface;
use Kiri\Router\Validator\RequestFilter\RequiredValidatorFilter;
use Kiri\Router\Validator\Types\TypesProxy;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionNamedType;
use ReflectionUnionType;
use Kiri\Router\Validator\RequestFilter\ValidatorFilter as RValidator;


/**
 * class Validator
 */
class Validator
{


    /**
     * @var array<array<ValidatorInterface|TypesProxy>>
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
    protected array $ignoring = [];


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
     * @return object
     */
    public function getFormData(): object
    {
        return $this->formData;
    }

    /**
     * @param string $name
     * @param array $rule
     * @return void
     */
    public function addRule(string $name, array $rule): void
    {
        if (!isset($this->rules[$name])) {
            $this->rules[$name] = [];
        }
        foreach ($rule as $item) {
            [$dispatch, $isFirst] = $item;
            if ($isFirst) {
                array_unshift($this->rules[$name], $dispatch);
            } else {
                $this->rules[$name][] = $dispatch;
            }
        }
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
        foreach ($this->rules as $name => $rules) {
            /** @var TypesProxy $typeValidator */
            if (!isset($params[$name])) {
                if ($rules[0] instanceof RequiredValidatorFilter) {
                    return $this->addError('The request field ' . $name . ' is mandatory and indispensable');
                }
                if (!$typeValidator->allowsNull) {
                    return $this->addError('The request field ' . $name . ' parameter cannot be null');
                }
            }

            $typeValidator = array_pop($rules);
            if (!$typeValidator->dispatch($this->formData, $name, $params[$name])) {
                return $this->addError('The parameter type used in the request field ' . $name . ' is incorrect');
            }

            /** @var RValidator $rule */
            foreach ($rules as $rule) {
                if (!$rule->dispatch($this->formData->{$name})) {
                    return $this->addError('Request field ' . $name . ' value format error');
                }
            }
        }
        return true;
    }


    /**
     * @param $field
     * @return bool
     */
    private function addError($field): bool
    {
        $this->message = $field;
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
