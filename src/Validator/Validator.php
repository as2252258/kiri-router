<?php
declare(strict_types=1);

namespace Kiri\Router\Validator;

use Kiri\Router\Interface\ValidatorInterface;
use Kiri\Router\Request;
use Psr\Http\Message\ServerRequestInterface;


/**
 * class Validator
 */
class Validator
{


    /**
     * @var ValidatorInterface[]
     */
    protected array $rules = [];


    protected string $message = '';


    protected object $formData;


    /**
     * @param object $formData
     */
    public function setFormData(object $formData): void
    {
        $this->formData = $formData;
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
        $this->rules[$name] = $rule;
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
            if (property_exists($this->formData, $key)) {
                $type = new \ReflectionProperty($this->formData, $key);
                if (!($type->getType() instanceof \ReflectionUnionType)) {
                    $value = match ($type->getType()?->getName()) {
                        'int'   => (int)$value,
                        'float' => (float)$value,
                        default => $value
                    };
                }
                if ($value === 'Null') {
                    $value = null;
                }
                $this->formData->{$key} = $value;
            }
        }
        return $this;
    }


    /**
     * @param ServerRequestInterface|Request $request
     * @return bool
     */
    public function run(ServerRequestInterface|Request $request): bool
    {
        foreach ($this->rules as $name => $rule) {
            if (!$rule->dispatch($this->formData, $name)) {
                return $this->addError($name);
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
