<?php

namespace App\Components\Homepage\Business;

use App\Global\Presentation\Redirect\RedirectInterface;

class SearchEngine
{
    public RedirectInterface $redirect;
    public function __construct(RedirectInterface $redirect)
    {
        $this->redirect = $redirect;
    }
    public function search() : void
    {
        if(!empty($_POST['search']))
        {
            $this->redirect->to('?page=shop&id=' . $_POST['search']);
        }
    }
}
