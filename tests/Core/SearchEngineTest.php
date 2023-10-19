<?php

namespace Core;

use App\Core\Container;
use App\Core\Redirect\RedirectInterface;
use App\Core\SearchEngine;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;
use PHPUnit\Framework\TestCase;

class SearchEngineTest extends TestCase
{
    public RedirectInterface $redirect;
    private SearchEngine $searchEngine;
    public RedirectSpy $redirectSpy;

    protected function setUp(): void
    {
        $this->redirectSpy = new RedirectSpy();


        $this->searchEngine = new SearchEngine($this->redirectSpy);
    }

    public function testSearchWithTerm(): void
    {
        $_POST['search'] = '3';
        $this->searchEngine->search();

        self::assertSame('?page=shop&id=3', $this->searchEngine->redirect->location);
    }

    public function testSearchWithEmptyTerm(): void
    {
        $_POST['search'] = '';
        $this->searchEngine->search();

        $this->assertEmpty($this->searchEngine->redirect->location);
    }
}
