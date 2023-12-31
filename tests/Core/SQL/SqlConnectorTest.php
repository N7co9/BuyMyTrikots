<?php

namespace Core\SQL;

use App\Core\SQL\SqlConnector;
use PHPUnit\Framework\TestCase;

class SqlConnectorTest extends TestCase
{
    public SqlConnector $sqlConnector;

    public function setUp(): void
    {
        $this->sqlConnector = new SqlConnector();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testConnect() : void
    {
        $this->sqlConnector->connect();

        self::assertSame('user_test', $this->sqlConnector->getDatabaseName());
    }

    public function testSqlException() : void
    {
        $this->sqlConnector->connect();

        $this->expectException('PDOException');

        $this->sqlConnector->executeSelectQuery('invalid QUERY LOLLOLOL', []);
    }

    public function tearDown(): void
    {
        $this->sqlConnector->closeConnection();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}