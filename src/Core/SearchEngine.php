<?php

namespace App\Core;

use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;

class SearchEngine
{
    public Redirect $redirect;
    public function __construct(Redirect $redirect)
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
