<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\DTO\ClientDTO;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;
use App\Core\TemplateEngine;
use App\Model\ClientRepository;


class ClientLoginController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private ClientRepository $clientRepository;
    private ClientDTO $clientDTO;
    private Redirect $redirect;
    public RedirectSpy $redirectSpy;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->clientRepository = $container->get(ClientRepository::class);
        $this->clientDTO = $container->get(ClientDTO::class);
        $this->redirectSpy = new RedirectSpy();
        $this->redirect = new Redirect($this->redirectSpy);
    }

    public function dataConstruct(): TemplateEngine
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->clientDTO->email = $_POST['mail'] ?? '';
            $this->clientDTO->password = $_POST['password'] ?? '';

            $verify = (
            $this->clientRepository->checkLoginCredentials($this->clientDTO));
            if ($verify === true) {
                $_SESSION['mail'] = $_POST['mail'];
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