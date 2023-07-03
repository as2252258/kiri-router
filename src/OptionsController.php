<?php

namespace Kiri\Router;

use Kiri\Router\Base\Controller;
use Psr\Http\Message\ResponseInterface;

class OptionsController extends Controller
{


    /**
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->response->withHeaders(['Access-Control-Allow-Headers' => '*',
            'Access-Control-Request-Method' => '*',
            'Access-Control-Allow-Origin' => '*'
        ])->html('');
    }

}