<?php
declare(strict_types=1);

namespace Kiri\Router;

use Kiri;

class DataGrip
{

    private array $servers = [];


    /**
     * @param $type
     * @return RouterCollector
     * @throws
     */
    public function get($type): RouterCollector
    {
        if (!isset($this->servers[$type])) {
            $this->servers[$type] = Kiri::getDi()->make(RouterCollector::class);
        }
        return $this->servers[$type];
    }


}
