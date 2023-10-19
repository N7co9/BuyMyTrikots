<?php

namespace App\Core;

use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectInterface;
use App\Core\Redirect\RedirectSpy;

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
