<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;

class ClientLogoutController implements ControllerInterface
{
    public Redirect $redirect;
    public RedirectSpy $redirectSpy;
    public function __construct()
    {
        $this->redirectSpy = new RedirectSpy();
        $this->redirect = new Redirect($this->redirectSpy);
    }

    public function dataConstruct(): void
    {
        session_destroy();
        session_start();
        $this->redirect->to('?page=shop');
    }
}