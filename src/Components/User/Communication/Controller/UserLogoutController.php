<?php
declare(strict_types=1);

namespace App\Components\User\Communication\Controller;

use App\Global\Business\Dependency\Container;
use App\Global\Business\Redirect\Redirect;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Interface\Redirect\RedirectInterface;
use App\Global\Presentation\Session\SessionHandler;

class UserLogoutController implements ControllerInterface
{
    public RedirectInterface $redirect;
    private SessionHandler $sessionHandler;
    public function __construct(Container $container)
    {
        $this->sessionHandler = $container->get(SessionHandler::class);
        $this->redirect = $container->get(Redirect::class);
    }

    public function dataConstruct(): void
    {
        $this->sessionHandler->unsetSession();
        $this->redirect->to('?page=shop');
    }
}