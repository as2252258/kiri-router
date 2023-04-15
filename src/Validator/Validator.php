<?php

namespace Kiri\Router\Validator;

use Kiri\Router\Interface\ValidatorInterface;
use Kiri\Router\Request;
use Psr\Http\Message\ServerRequestInterface;

class Validator
{


	/**
	 * @var ValidatorInterface[]
	 */
	private array $rules = [];


	private string $message;


	private object $formData;


	/**
	 * @param string $name
	 * @param object $data
	 * @param ValidatorInterface $rule
	 * @return void
	 */
	public function addRule(string $name, object $data, ValidatorInterface $rule): void
	{
		$this->rules[$name] = $rule;
		$this->formData = $data;
	}


	/**
	 * @param ServerRequestInterface|Request $request
	 * @return Validator
	 */
	public function bindData(ServerRequestInterface|Request $request): static
	{
		if ($request->isPost) {
			$data = $request->getParsedBody();
		} else {
			$data = $request->getQueryParams();
		}
		foreach ($data as $key => $value) {
			if (method_exists($this->formData, $key)) {
				$this->formData->{$key} = $value;
			}
		}
		return $this;
	}


	/**
	 * @return bool
	 */
	public function run(): bool
	{
		foreach ($this->rules as $name => $rule) {
			if (!$rule->dispatch($this->formData, $name)) {
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
