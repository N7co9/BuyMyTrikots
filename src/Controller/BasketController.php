<?php

namespace App\Controller;

use App\Core\Basket\BasketManipulator;
use App\Core\Container;
use App\Core\Session\SessionHandler;
use App\Core\TemplateEngine;
use App\Model\BasketRepository;


class BasketController implements ControllerInterface
{
    private TemplateEngine $templateEngine;

    private BasketRepository $basketRepository;
    private BasketManipulator $manipulator;
    public SessionHandler $sessionHandler;
    public string $feedback;
    public function __construct(Container $container)
    {
        $this->feedback = '';
        $this->sessionHandler = $container->get(SessionHandler::class);
        $this->templateEngine = $container->get(TemplateEngine::class);
        $this->basketRepository = $container->get(BasketRepository::class);
        $this->manipulator = $container->get(BasketManipulator::class);
    }

    public function dataConstruct() : TemplateEngine
    {
        $action = $_GET['action'] ?? '';

        $actionMap = [
            'add' => 'addItemToBasket',
            'remove' => 'removeItemFromBasket'
        ];

        if (!empty($this->sessionHandler->getSessionMail()) && array_key_exists($action, $actionMap)) {
            $this->feedback = 'successful action';
            $this->manipulator->{$actionMap[$action]}();
        }

        $basketContent = $this->basketRepository->getBasketInfo();
        $total = $this->basketRepository->getBasketTotal();

        $this->templateEngine->addParameter('contents', $basketContent);
        $this->templateEngine->addParameter('total', $total);
        $this->templateEngine->setTemplate('basket.twig');

        return $this->templateEngine;
    }
}