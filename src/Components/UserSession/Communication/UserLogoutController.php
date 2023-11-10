<?php
declare(strict_types=1);

namespace App\Components\UserSession\Communication;

use App\Global\Business\Dependency\Container;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\Redirect\Redirect;
use App\Global\Presentation\Redirect\RedirectInterface;

class UserLogoutController implements ControllerInterface
{
    private GlobalPresentationFacade $presentationFacade;

    public function __construct(Container $container)
    {
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
    }

    public function dataConstruct(): void
    {
        $this->presentationFacade->unsetSession();
        $this->presentationFacade->to('?page=shop');
    }
}