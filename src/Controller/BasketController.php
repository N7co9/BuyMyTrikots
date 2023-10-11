<?php

namespace App\Controller;

use App\Core\Basket\BasketManipulator;
use App\Core\Container;
use App\Core\DTO\BasketDTO;
use App\Core\TemplateEngine;
use App\Model\BasketRepository;
use App\Model\ClientEntityManager;
use App\Model\ClientRepository;

class BasketController implements ControllerInterface
{
    private TemplateEngine $templateEngine;

    private BasketRepository $basketRepository;
    private BasketManipulator $manipulator;
    public function __construct(Container $container)
    {
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

        if (!empty($_SESSION['mail']) && array_key_exists($action, $actionMap)) {
            $this->manipulator->{$actionMap[$action]}();
        }

        $basketContent = $this->basketRepository->getBasketInfo();

        $this->templateEngine->addParameter('contents', $basketContent);
        $this->templateEngine->setTemplate('basket.twig');

        return $this->templateEngine;
    }
}