<?php

namespace App\Core\API;

class ApiCache {

    public $cacheFileDir = __DIR__. '/ApiCache/';  // Choose your directory path
    private $apiHandler;
    private $cacheDuration = 3600; // Cache duration in seconds (1 hour)

    public function __construct(ApiHandling $apiHandler) {
        $this->apiHandler = $apiHandler;
    }

    public function getData(string $type, $id) {
        $cacheFilePath = $this->getCacheFilePath($type, $id);

        if ($this->isCacheValid($cacheFilePath)) {
            return $this->loadFromCache($cacheFilePath);
        }

        switch ($type) {
            case 'players':
                $data = $this->apiHandler->requestPlayers($id);
                break;

            case 'item':
                $data = $this->apiHandler->requestItemInfo(['item_id' => $id]);
                break;

            default:
                throw new \Exception("Invalid request type: $type");
        }

        $this->saveToCache($data, $cacheFilePath);
        return $data;
    }

    private function isCacheValid(string $cacheFilePath): bool {
        if (!file_exists($cacheFilePath)) {
            return false;
        }

        $fileTime = filemtime($cacheFilePath);
        return (time() - $fileTime) <= $this->cacheDuration;
    }

    private function loadFromCache(string $cacheFilePath): array {
        return json_decode(file_get_contents($cacheFilePath), true);
    }

    private function saveToCache(array $data, string $cacheFilePath): void {
        if(file_exists($cacheFilePath)){
            file_put_contents($cacheFilePath, json_encode($data));
        }
    }

    private function getCacheFilePath(string $type, $id): string {
        return $this->cacheFileDir . "/{$type}_{$id}.json";
    }
}
