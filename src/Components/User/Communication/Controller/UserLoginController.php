<?php
declare(strict_types=1);

namespace App\Components\User\Communication\Controller;

use App\Components\User\Persistence\Repository\UserCredentialsRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\Redirect\Redirect;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Interface\Redirect\RedirectInterface;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;


class UserLoginController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private UserCredentialsRepository $repository;
    private ClientDTO $clientDTO;
    private SessionHandler $sessionHandler;
    public RedirectInterface $redirect;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->repository = $container->get(UserCredentialsRepository::class);
        $this->clientDTO = $container->get(ClientDTO::class);
        $this->redirect = $container->get(Redirect::class);
        $this->sessionHandler = $container->get(SessionHandler::class);
    }

    public function dataConstruct(): TemplateEngine
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->clientDTO->email = $_POST['mail'] ?? '';
            $this->clientDTO->password = $_POST['password'] ?? '';

            $verify = (
            $this->repository->checkLoginCredentials($this->clientDTO));
            if ($verify === true) {
                $this->sessionHandler->setSession($_POST['mail']);
                $feedback = 'success';
                $this->redirect->to('?page=shop');
            } else {
                $feedback = 'not a valid combination';
            }
        }
        $this->templateEngine->setTemplate('login.twig');
        $this->templateEngine->addParameter('feedback', $feedback ?? '');

        return $this->templateEngine;
    }
}