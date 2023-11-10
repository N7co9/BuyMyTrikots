<?php
declare(strict_types=1);

namespace App\Components\UserSession\Communication;

use App\Components\Order\Business\OrderBusinessFacade;
use App\Components\UserSession\Business\UserSessionBusinessFacade;
use App\Global\Business\Dependency\Container;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\Redirect\Redirect;
use App\Global\Presentation\Redirect\RedirectInterface;
use App\Global\Presentation\TemplateEngine\TemplateEngine;


class UserLoginController implements ControllerInterface
{
    private UserSessionBusinessFacade $sessionBusinessFacade;
    private ClientDTO $clientDTO;
    private GlobalPresentationFacade $presentationFacade;

    public function __construct(Container $container)
    {
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
        $this->sessionBusinessFacade = $container->get(UserSessionBusinessFacade::class);
        $this->clientDTO = $container->get(ClientDTO::class);
    }

    public function dataConstruct(): GlobalPresentationFacade
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->clientDTO->email = $_POST['mail'] ?? '';
            $this->clientDTO->password = $_POST['password'] ?? '';

            $verify = (
            $this->sessionBusinessFacade->checkLoginCredentials($this->clientDTO));
            if ($verify === true) {
                $this->presentationFacade->setSession($_POST['mail']);
                $feedback = 'success';
                $this->presentationFacade->to('?page=shop');
            } else {
                $feedback = 'not a valid combination';
            }
        }
        $this->presentationFacade->setTemplate('login.twig');
        $this->presentationFacade->addParameter('feedback', $feedback ?? '');

        return $this->presentationFacade;
    }
}