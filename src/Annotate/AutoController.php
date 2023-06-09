<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;


#[\Attribute(\Attribute::TARGET_CLASS)]
class AutoController
{

	/**
	 * @throws \ReflectionException
	 */
	public function dispatch(object $object): void
	{
		$reflection = \Kiri::getDi()->getReflectionClass($object::class);
		foreach ($reflection->getMethods() as $method) {
			$attributes = $method->getAttributes();
			foreach ($attributes as $attribute) {
				if (!class_exists($attribute->getName())) {
					continue;
				}
				$attribute->newInstance()->dispatch($object, $method->getName());
			}
		}

	}

}
