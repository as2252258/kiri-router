<?php

namespace Kiri\Router\Validator;

use Kiri\Di\Interface\InjectParameterInterface;
use Kiri\Router\Interface\ValidatorInterface;

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
	 * @return mixed
	 * @throws \ReflectionException
	 */
	public function dispatch(): mixed
	{
		$validator = new Validator();
		$reflect = \Kiri::getDi()->getReflectionClass($this->formValidate);
		$validator->setFormData($reflect->newInstanceWithoutConstructor());
		foreach ($reflect->getProperties() as $property) {
			foreach ($property->getAttributes() as $attribute) {
				$rule = $attribute->newInstance();
				if ($rule instanceof ValidatorInterface) {
					$validator->addRule($property->getName(), $rule);
				}
			}
		}
		return $validator;
	}

}
