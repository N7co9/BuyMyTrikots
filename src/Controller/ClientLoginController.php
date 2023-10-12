<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\DTO\ClientDTO;
use App\Core\TemplateEngine;
use App\Model\ClientRepository;


class ClientLoginController implements ControllerInterface
{
    private TemplateEngine $templateEngine;
    private ClientRepository $clientRepository;
    private ClientDTO $clientDTO;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->clientRepository = $container->get(ClientRepository::class);
        $this->clientDTO = $container->get(ClientDTO::class);
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
                header('Location: http://localhost:8000/?page=shop&id=3');
            } else {
                $feedback = 'not a valid combination';
            }
        }
        $this->templateEngine->setTemplate('login.twig');
        $this->templateEngine->addParameter('feedback', $feedback ?? '');

        return $this->templateEngine;
    }
}