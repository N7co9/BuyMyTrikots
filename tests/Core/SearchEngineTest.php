<?php

namespace Core;

use App\Components\Homepage\Business\SearchEngine;
use App\Global\Presentation\Redirect\RedirectInterface;
use App\Global\Presentation\Redirect\RedirectSpy;
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
