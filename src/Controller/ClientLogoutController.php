<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;

class ClientLogoutController implements ControllerInterface
{

    public function __construct(Container $container)
    {
    }

    public function dataConstruct(): void
    {
        session_start();
        session_destroy();
        header('Location: http://localhost:8000/?page=shop');
    }
}