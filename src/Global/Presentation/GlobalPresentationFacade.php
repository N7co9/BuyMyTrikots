<?php

namespace App\Global\Presentation;

use App\Global\Presentation\Redirect\Redirect;
use App\Global\Presentation\Redirect\RedirectInterface;
use App\Global\Presentation\Session\SessionHandler;
use App\Global\Presentation\TemplateEngine\TemplateEngine;

class GlobalPresentationFacade
{
    public function __construct(
        public TemplateEngine $templateEngine,
        public SessionHandler $sessionHandler,
        public RedirectInterface $redirect
    )
    {
    }

    public function addParameter(string $key, mixed $value): void
    {
       $this->templateEngine->addParameter($key, $value);
    }
    public function display() : void
    {
        $this->templateEngine->display();
    }
    public function setTemplate(string $tpl) : void
    {
        $this->templateEngine->setTemplate($tpl);
    }
    public function getParameters() : array
    {
        return $this->templateEngine->getParameters();
    }
    public function getTpl() : string
    {
        return $this->templateEngine->getTpl();
    }
    public function getSessionMail() : string
    {
        return $this->sessionHandler->getSessionMail();
    }
    public function unsetSession() : void
    {
        $this->sessionHandler->unsetSession();
    }
    public function setSession(string $mail): void
    {
        $this->sessionHandler->setSession($mail);
    }
    public function setOrderSession($dataKeys): void
    {
        $this->sessionHandler->setOrderSession($dataKeys);
    }
    public function getOrderSession() : array
    {
        return $this->sessionHandler->getOrderSession();
    }
    public function to(string $location) : void
    {
        $this->redirect->to($location);
    }
}