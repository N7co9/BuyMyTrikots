<?php

namespace App\Global\Business\Redirect;

use App\Global\Interface\Redirect\RedirectInterface;

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
