<?php declare(strict_types=1);

namespace App\Components\UserRegistration\Communication;

use App\Components\UserRegistration\Business\Validation\UserValidator;
use App\Components\UserRegistration\Persistence\UserEntityManager;
use App\Components\UserSession\Persistence\UserRepository;
use App\Global\Business\Dependency\Container;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\DTO\ErrorDTO;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class UserRegistrationController implements ControllerInterface
{
    private UserValidator $validator;
    private TemplateEngine $templateEngine;
    private UserRepository $clientRepository;
    private UserEntityManager $clientEntityManager;
    public array $errorDTOList;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->clientRepository = $container->get(UserRepository::class);
        $this->clientEntityManager = $container->get(UserEntityManager::class);
        $this->validator = $container->get(UserValidator::class);
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