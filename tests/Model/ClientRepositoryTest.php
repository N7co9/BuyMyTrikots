<?php

namespace Model;

use App\Model\ClientRepository;
use PHPUnit\Framework\TestCase;
class ClientRepositoryTest extends TestCase
{
    private ClientRepository $repository;
    public function setUp(): void
    {
        $this->repository = new ClientRepository();
    }

    public function testGetBasketContent() : void
    {
        $id = $this->repository->getUserID('validation@validation.com');
        $basketContent = $this->repository->getBasketContent($id);

        self::assertSame('', $basketContent);
    }

    public function testGetUserID() : void
    {
        $id = $this->repository->getUserID('validation@validation.com');
        self::assertSame('', $id);
    }


}