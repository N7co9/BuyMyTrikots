<?php declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\DTO\ClientDTO;
use App\Core\DTO\ErrorDTO;
use App\Core\TemplateEngine;
use App\Core\Validation\ClientValidator;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;

class ClientRegistrationController implements ControllerInterface
{
    private ClientValidator $validator;
    private TemplateEngine $templateEngine;
    private ClientRepository $clientRepository;
    private ClientEntityManager $clientEntityManager;
    public array $errorDTOList;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->clientRepository = $container->get(ClientRepository::class);
        $this->clientEntityManager = $container->get(ClientEntityManager::class);
        $this->validator = $container->get(ClientValidator::class);
    }

    public function dataConstruct(): TemplateEngine
    {
        $clientDTO = new ClientDTO();
        $clientDTO->username = ($_POST['name'] ?? '');
        $clientDTO->email = ($_POST['mail'] ?? '');
        $clientDTO->password = ($_POST['password'] ?? '');
        $this->errorDTOList = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = $this->validator;
            $this->errorDTOList = $validator->validate($clientDTO);

            if (empty($this->errorDTOList)) {
                $validPassword = password_hash(password: $clientDTO->password, algo: PASSWORD_DEFAULT);

                $newUser = new ClientDTO();
                $newUser->username = $clientDTO->username;
                $newUser->email = $clientDTO->email;
                $newUser->password = $validPassword;

                if (empty($this->clientRepository->findByMail($clientDTO->email) && !empty($clientDTO->password))) {
                    $this->clientEntityManager->saveCredentials($newUser);
                    $this->errorDTOList [] = new ErrorDTO('Success. Welcome abroad!');
                    $clientDTO->username = ('');
                    $clientDTO->password = ('');
                    $clientDTO->email = ('');
                } else {
                    $this->errorDTOList [] = new ErrorDTO('Oops, your email is already registered!');
                }
            }
        }
        $this->templateEngine->setTemplate('registration.twig');
        $this->templateEngine->addParameter('user', $clientDTO);
        $this->templateEngine->addParameter('vName', $clientDTO->username);
        $this->templateEngine->addParameter('vMail', $clientDTO->email);
        $this->templateEngine->addParameter('errors', $this->errorDTOList);

        return $this->templateEngine;
    }
}