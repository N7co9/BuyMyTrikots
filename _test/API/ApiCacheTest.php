<?php

namespace _test\API;

use App\Global\Persistence\API\ApiCache;
use App\Global\Persistence\API\ApiHandling;
use PHPUnit\Framework\TestCase;

class ApiCacheTest extends TestCase
{
    private ApiCache $apiCache;

    protected function setUp(): void
    {
        $apiHandling = new ApiHandling();
        $this->apiCache = new ApiCache($apiHandling);
        $this->apiCache->cacheFileDir = __DIR__ . '/../../../tests/Core/API/ApiCacheTestData';
    }

    public function testGetDataWithoutCachePlayers(): void
    {
        if(file_exists($this->apiCache->cacheFileDir . 'item_44.json')){
            unlink($this->apiCache->cacheFileDir . 'item_44.json');
        }

        $type = 'players';
        $id = '3';

        $data = $this->apiCache->getData($type, $id);

        self::assertNotEmpty($data);
        self::assertSame(3, $data['id']);
        self::assertSame('Bayer 04 Leverkusen', $data['name']);
    }
    public function testGetDataWithoutCacheItems(): void
    {
        if(file_exists($this->apiCache->cacheFileDir . 'players_3.json')){
            unlink($this->apiCache->cacheFileDir . 'players_3.json');
        }

        $type = 'players';
        $id = '3';

        $data = $this->apiCache->getData($type, $id);

        self::assertNotEmpty($data);
        self::assertSame(3, $data['id']);
        self::assertSame('Bayer 04 Leverkusen', $data['name']);
    }
    public function testGetDataWithCachePlayers(): void
    {
        $type = 'players';
        $id = '3';

        $data = $this->apiCache->getData($type, $id);

        self::assertNotEmpty($data);
        self::assertSame(3, $data['id']);
        self::assertSame('Bayer 04 Leverkusen', $data['name']);
    }
    public function testGetDataWithCacheItems(): void
    {
        $type = 'item';
        $id = '44';

        $data = $this->apiCache->getData($type, $id);

        self::assertNotEmpty($data);
        self::assertSame(44, $data['id']);
        self::assertSame('Cristiano Ronaldo', $data['name']);
    }
    public function testGetDataInvalidRequestType(): void
    {
        $type = 'INVALID';
        $id = '44';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid request type: INVALID');

        $this->apiCache->getData($type, $id);
    }

    public function tearDown(): void
    {
        $files = glob($this->apiCache->cacheFileDir . '/*');
        array_map('unlink', array_filter($files, 'is_file'));
    }
}
