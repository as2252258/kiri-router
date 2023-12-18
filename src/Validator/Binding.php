<?php

namespace Kiri\Router\Validator;

use Kiri;
use Kiri\Router\Validator\RequestFilter\BetweenValidatorFilter;
use Kiri\Router\Validator\RequestFilter\InValidatorFilter;
use Kiri\Router\Validator\RequestFilter\LengthValidatorFilter;
use Kiri\Router\Validator\RequestFilter\MaxLengthValidatorFilter;
use Kiri\Router\Validator\RequestFilter\MaxValidatorFilter;
use Kiri\Router\Validator\RequestFilter\MinLengthValidatorFilter;
use Kiri\Router\Validator\RequestFilter\MinValidatorFilter;
use Kiri\Router\Validator\RequestFilter\NotBetweenValidatorFilter;
use Kiri\Router\Validator\RequestFilter\NotInValidatorFilter;
use Kiri\Router\Validator\RequestFilter\RequiredValidatorFilter;
use Kiri\Router\Validator\RequestFilter\RoundValidatorFilter;
use Kiri\Router\Validator\RequestFilter\MustValidatorFilter;
use Kiri\Router\Validator\RequestFilter\EmailValidatorFilter;
use Kiri\Router\Validator\RequestFilter\RequestFilterInterface;
use Kiri\Router\Validator\RequestFilter\PhoneValidatorFilter;

/**
 *
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Binding implements RequestFilterInterface
{


    const array TYPES = [
        'required'   => ['class' => RequiredValidatorFilter::class],
        'length'     => ['class' => LengthValidatorFilter::class],
        'minLength'  => ['class' => MinLengthValidatorFilter::class],
        'maxLength'  => ['class' => MaxLengthValidatorFilter::class],
        'in'         => ['class' => InValidatorFilter::class],
        'notIn'      => ['class' => NotInValidatorFilter::class],
        'between'    => ['class' => BetweenValidatorFilter::class],
        'notBetween' => ['class' => NotBetweenValidatorFilter::class],
        'max'        => ['class' => MaxValidatorFilter::class],
        'min'        => ['class' => MinValidatorFilter::class],
        'round'      => ['class' => RoundValidatorFilter::class],
        'must'       => ['class' => MustValidatorFilter::class],
        'email'      => ['class' => EmailValidatorFilter::class],
        'phone'      => ['class' => PhoneValidatorFilter::class],
    ];


    /**
     * @param string $field
     * @param array $rules
     * @param mixed $defaultValue
     */
    public function __construct(public string $field, public array $rules, public mixed $defaultValue = null)
    {
    }


    /**
     * @param object $class
     * @param string $property
     * @return array
     */
    public function dispatch(object $class, string $property): array
    {
        // TODO: Implement dispatch() method.
        $array = [];
        foreach ($this->rules as $key => $rule) {
            if (is_string($key)) {
                $array[] = $this->getValidator($key, $rule);
            } else if (method_exists($this, $rule)) {
                $array[] = [$class, $rule, false];
            } else {
                $array[] = $this->getValidator($key, $rule);
            }
        }
        if (!is_null($this->defaultValue)) {
            $class->{$property} = $this->defaultValue;
        }
        return $array;
    }


    /**
     * @param $key
     * @param $rule
     * @return array
     * @throws
     */
    protected function getValidator($key, $rule): array
    {
        if (is_numeric($key)) {
            $class = self::TYPES[$rule];
        } else {
            $class   = array_merge(self::TYPES[$key], ['value' => $rule, 'field' => $key]);
        }
        $isFirst = false;
        if ($class['class'] === RequiredValidatorFilter::class) {
            $isFirst = true;
        }
        return [Kiri::createObject($class), 'dispatch', $isFirst];
    }

}