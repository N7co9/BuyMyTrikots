<?php declare(strict_types=1);

namespace App\Components\User\Persistence\Entity;

use App\Global\Business\DTO\ClientDTO;
use App\Global\Persistence\SQL\SqlConnector;

class UserEntityManager
{
    public function __construct(public SqlConnector $sqlConnector)
    {
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