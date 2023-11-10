<?php declare(strict_types=1);

namespace App\Components\UserRegistration\Communication;

use App\Components\Order\Business\OrderBusinessFacade;
use App\Components\UserRegistration\Business\UserRegistrationBusinessFacade;
use App\Components\UserSession\Business\UserSessionBusinessFacade;
use App\Global\Business\Dependency\Container;
use App\Global\Business\DTO\ClientDTO;
use App\Global\Business\DTO\ErrorDTO;
use App\Global\Interface\Controller\ControllerInterface;
use App\Global\Presentation\GlobalPresentationFacade;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class UserRegistrationController implements ControllerInterface
{
    private GlobalPresentationFacade $presentationFacade;
    private UserRegistrationBusinessFacade $registrationBusinessFacade;
    private UserSessionBusinessFacade $sessionBusinessFacade;
    public array $errorDTOList;

    public function __construct(Container $container)
    {
        $this->sessionBusinessFacade = $container->get(UserSessionBusinessFacade::class);
        $this->registrationBusinessFacade = $container->get(UserRegistrationBusinessFacade::class);
        $this->presentationFacade = $container->get(GlobalPresentationFacade::class);
    }

    public function dataConstruct(): GlobalPresentationFacade
    {
        $clientDTO = new ClientDTO();
        $clientDTO->username = ($_POST['name'] ?? '');
        $clientDTO->email = ($_POST['mail'] ?? '');
        $clientDTO->password = ($_POST['password'] ?? '');
        $this->errorDTOList = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = $this->registrationBusinessFacade;
            $this->errorDTOList = $validator->validate($clientDTO);

            if (empty($this->errorDTOList)) {
                $validPassword = password_hash(password: $clientDTO->password, algo: PASSWORD_DEFAULT);

                $newUser = new ClientDTO();
                $newUser->username = $clientDTO->username;
                $newUser->email = $clientDTO->email;
                $newUser->password = $validPassword;

                if (empty($this->sessionBusinessFacade->findByMail($clientDTO->email) && !empty($clientDTO->password))) {
                    $this->registrationBusinessFacade->saveCredentials($newUser);
                    $this->errorDTOList [] = new ErrorDTO('Success. Welcome abroad!');
                    $clientDTO->username = ('');
                    $clientDTO->password = ('');
                    $clientDTO->email = ('');
                } else {
                    $this->errorDTOList [] = new ErrorDTO('Oops, your email is already registered!');
                }
            }
        }

        $this->presentationFacade->setTemplate('registration.twig');
        $this->presentationFacade->addParameter('user', $clientDTO);
        $this->presentationFacade->addParameter('vName', $clientDTO->username);
        $this->presentationFacade->addParameter('vMail', $clientDTO->email);
        $this->presentationFacade->addParameter('errors', $this->errorDTOList);

        return $this->presentationFacade;
    }
}