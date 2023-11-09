<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Di\Inject\Container;
use Kiri\Router\Interface\ValidatorInterface;
use Psr\Http\Message\RequestInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Required implements ValidatorInterface
{


    /**
     * @var RequestInterface
     */
    #[Container(RequestInterface::class)]
    public RequestInterface $request;

    /**
     * @param object $class
     * @param string $name
     * @return bool
     */
    public function dispatch(object $class, string $name): bool
    {
        if ($this->request->getIsPost()) {
            $data = $this->request->post($name, null);
        } else {
            $data = $this->request->query($name, null);
        }
        return !($data === null);
    }

}
