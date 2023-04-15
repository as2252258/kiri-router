<?php

namespace Kiri\Inject\Validator;

use Kiri\Inject\Validator\Inject\ValidatorInterface;

class Validator
{


	/**
	 * @var ValidatorInterface[]
	 */
	private array $rules = [];


	private string $message;


	/**
	 * @param string $name
	 * @param ValidatorInterface $rule
	 * @return void
	 */
	public function addRule(string $name, ValidatorInterface $rule): void
	{
		$this->rules[$name] = $rule;
	}


	/**
	 * @return bool
	 */
	public function run(): bool
	{
		foreach ($this->rules as $name => $rule) {
			if (!$rule->dispatch($name)) {
				return false;
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
		$this->message = $field . ' error';
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
