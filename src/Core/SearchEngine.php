<?php

namespace App\Core;

class SearchEngine
{
    public function search() : void
    {
        if(!empty($_POST['search']))
        {
            header('Location: http://localhost:8000/?page=shop&id=' . $_POST['search']);
        }
    }
}
