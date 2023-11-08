<?php declare(strict_types=1);

namespace App\User\Components\Registration\Persistence\Entity;

use App\Global\Business\DTO\ClientDTO;
use App\Global\Persistence\SQL\SqlConnector;

class ClientEntityManager
{
    public SqlConnector $sqlConnector;
    public function __construct()
    {
        $this->sqlConnector = new SqlConnector();
    }

    public function saveCredentials(ClientDTO $newUser): string
    {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

        $params = [
            'username' => $newUser->username,
            'email' => $newUser->email,
            'password' => $newUser->password
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }
}