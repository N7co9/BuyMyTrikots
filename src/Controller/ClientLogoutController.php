<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectInterface;
use App\Core\Redirect\RedirectSpy;
use App\Core\Session\SessionHandler;

class ClientLogoutController implements ControllerInterface
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