<?php

namespace Core;

use App\Core\SearchEngine;
use App\Core\Redirect\Redirect;
use App\Core\Redirect\RedirectSpy;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertContains;

class SearchEngineTest extends TestCase
{
    private RedirectSpy $redirectSpy;
    private SearchEngine $searchEngine;

    protected function setUp(): void
    {
        $this->redirectSpy = new RedirectSpy();
        $this->searchEngine = new SearchEngine(new Redirect($this->redirectSpy));
    }

    public function testSearchWithTerm(): void
    {
        $_POST['search'] = '3';
        $this->searchEngine->search();

        assertContains('http://localhost:8000/?page=shop&id=3', $this->redirectSpy->capturedHeaders);
    }

    public function testSearchWithEmptyTerm(): void
    {
        $_POST['search'] = '';
        $this->searchEngine->search();

        $this->assertEmpty($this->redirectSpy->capturedHeaders);
    }
}
