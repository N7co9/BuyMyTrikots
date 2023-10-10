<?php declare(strict_types=1);

namespace App\Model;

use App\Core\Mapper\ClientMapper;
use App\Core\SQL\SqlConnector;
use App\Core\DTO\ClientDTO;

class ClientEntityManager
{
    public SqlConnector $sqlConnector;
    public ClientRepository $clientRepository;

    public function __construct(
    )
    {
        $this->clientRepository = new ClientRepository();
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