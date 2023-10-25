<?php

namespace Core\Mapper;

use _test\API\ApiCacheTest;
use App\Core\Mapper\ApiMapper;
use PHPUnit\Framework\TestCase;

class ApiMapperTest extends TestCase
{
    public ApiMapper $apiMapper;
    public function setUp(): void
    {
        $this->apiMapper = new ApiMapper();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testMapMultipleItemsInArray() : void
    {
        $jayParsedAry = [
            "area" => [
                "id" => 2011,
                "name" => "Argentina",
                "code" => "ARG",
                "flag" => "https://crests.football-data.org/762.png"
            ],
            "id" => 2061,
            "name" => "CA Boca Juniors",
            "shortName" => "Boca Juniors",
            "tla" => "BOC",
            "crest" => "https://crests.football-data.org/2061.png",
            "address" => "Brandsen 805, La Boca Buenos Aires, Buenos Aires 1161",
            "website" => "http://www.bocajuniors.com.ar",
            "founded" => 1905,
            "clubColors" => "Dark Blue / Yellow",
            "venue" => "Estadio Alberto José Armando",
            "runningCompetitions" => [
                [
                    "id" => 2152,
                    "name" => "Copa Libertadores",
                    "code" => "CLI",
                    "type" => "CUP",
                    "emblem" => "https://crests.football-data.org/CLI.svg"
                ]
            ],
            "coach" => [
                "id" => 60123,
                "firstName" => "Sebastián",
                "lastName" => "Battaglia",
                "name" => "Sebastián Battaglia",
                "dateOfBirth" => "1980-11-08",
                "nationality" => "Argentina",
                "contract" => [
                    "start" => "2021-08",
                    "until" => "2022-12"
                ]
            ],
            "marketValue" => 99700000,
            "squad" => [
                [
                    "id" => 11656,
                    "firstName" => "Agustín",
                    "lastName" => "Rossi",
                    "name" => "Agustín Rossi",
                    "position" => "Goalkeeper",
                    "dateOfBirth" => "1995-08-21",
                    "nationality" => "Argentina",
                    "shirtNumber" => 1,
                    "marketValue" => 3200000,
                    "contract" => [
                        "start" => "2017-02",
                        "until" => "2023-12"
                    ]
                ],
                [
                    "id" => 46557,
                    "firstName" => "Javier",
                    "lastName" => "García",
                    "name" => "Javier García",
                    "position" => "Goalkeeper",
                    "dateOfBirth" => "1987-01-29",
                    "nationality" => "Argentina",
                    "shirtNumber" => 13,
                    "marketValue" => 125000,
                    "contract" => [
                        "start" => "2020-08",
                        "until" => "2022-12"
                    ]
                ],
                [
                    "id" => 178795,
                    "firstName" => "Leandro",
                    "lastName" => "Brey",
                    "name" => "Leandro Brey",
                    "position" => "Goalkeeper",
                    "dateOfBirth" => "2002-09-21",
                    "nationality" => "Argentina",
                    "shirtNumber" => 12,
                    "marketValue" => 25000,
                    "contract" => [
                        "start" => "2025-12",
                        "until" => "2022-12"
                    ]
                ],
                [
                    "id" => 3206,
                    "firstName" => "Marcos",
                    "lastName" => "Rojo",
                    "name" => "Marcos Rojo",
                    "position" => "Defence",
                    "dateOfBirth" => "1990-03-20",
                    "nationality" => "Argentina",
                    "shirtNumber" => 6,
                    "marketValue" => 3600000,
                    "contract" => [
                        "start" => "2021-02",
                        "until" => "2022-12"
                    ]
                ],
                [
                    "id" => 3725,
                    "firstName" => "Frank",
                    "lastName" => "Fabra",
                    "name" => "Frank Fabra",
                    "position" => "Defence",
                    "dateOfBirth" => "1991-02-22",
                    "nationality" => "Colombia",
                    "shirtNumber" => 18,
                    "marketValue" => 1500000,
                    "contract" => [
                        "start" => "2016-01",
                        "until" => "2023-12"
                    ]
                ],
                [
                    "id" => 3780,
                    "firstName" => "Luis",
                    "lastName" => "Advíncula",
                    "name" => "Luis Advíncula",
                    "position" => "Defence",
                    "dateOfBirth" => "1990-03-02",
                    "nationality" => "Peru",
                    "shirtNumber" => 17,
                    "marketValue" => 1200000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 16167,
                    "firstName" => "Carlos",
                    "lastName" => "Zambrano",
                    "name" => "Carlos Zambrano",
                    "position" => "Defence",
                    "dateOfBirth" => "1989-07-10",
                    "nationality" => "Peru",
                    "shirtNumber" => 5,
                    "marketValue" => 1000000,
                    "contract" => [
                        "start" => "2020-01",
                        "until" => "2022-12"
                    ]
                ],
                [
                    "id" => 39543,
                    "firstName" => "Carlos",
                    "lastName" => "Izquierdoz",
                    "name" => "Carlos Izquierdoz",
                    "position" => "Defence",
                    "dateOfBirth" => "1988-11-03",
                    "nationality" => "Argentina",
                    "shirtNumber" => 24,
                    "marketValue" => 3600000,
                    "contract" => [
                        "start" => "2018-07",
                        "until" => "2022-12"
                    ]
                ],
                [
                    "id" => 46522,
                    "firstName" => "Jorge Nicolás",
                    "lastName" => null,
                    "name" => "Jorge Figal",
                    "position" => "Defence",
                    "dateOfBirth" => "1994-04-03",
                    "nationality" => "Argentina",
                    "shirtNumber" => null,
                    "marketValue" => 4000000,
                    "contract" => [
                        "start" => "2022-01",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 98582,
                    "firstName" => "Marcelo",
                    "lastName" => "Weigandt",
                    "name" => "Marcelo Weigandt",
                    "position" => "Defence",
                    "dateOfBirth" => "2000-01-11",
                    "nationality" => "Argentina",
                    "shirtNumber" => 2,
                    "marketValue" => 2500000,
                    "contract" => [
                        "start" => "2019-07",
                        "until" => "2022-12"
                    ]
                ],
                [
                    "id" => 140850,
                    "firstName" => "Gastón",
                    "lastName" => "Ávila",
                    "name" => "Gastón Ávila",
                    "position" => "Defence",
                    "dateOfBirth" => "2001-09-30",
                    "nationality" => "Argentina",
                    "shirtNumber" => 25,
                    "marketValue" => 5000000,
                    "contract" => [
                        "start" => "2020-09",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 168907,
                    "firstName" => "Agustín",
                    "lastName" => "Sández",
                    "name" => "Agustin Sandez",
                    "position" => "Defence",
                    "dateOfBirth" => "2001-01-16",
                    "nationality" => "Argentina",
                    "shirtNumber" => 3,
                    "marketValue" => 1500000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2025-12"
                    ]
                ],
                [
                    "id" => 169088,
                    "firstName" => "Eros",
                    "lastName" => "Mancuso",
                    "name" => "Eros Mancuso",
                    "position" => "Defence",
                    "dateOfBirth" => "1999-04-17",
                    "nationality" => "Argentina",
                    "shirtNumber" => 40,
                    "marketValue" => 300000,
                    "contract" => [
                        "start" => "2022-01",
                        "until" => "2023-12"
                    ]
                ],
                [
                    "id" => 170261,
                    "firstName" => "Valentín",
                    "lastName" => "Barco",
                    "name" => "Valentin Barco",
                    "position" => "Defence",
                    "dateOfBirth" => "2004-07-23",
                    "nationality" => "Argentina",
                    "shirtNumber" => 19,
                    "marketValue" => 1200000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2023-12"
                    ]
                ],
                [
                    "id" => 285,
                    "firstName" => "Óscar",
                    "lastName" => "Romero",
                    "name" => "Óscar Romero",
                    "position" => "Midfield",
                    "dateOfBirth" => "1992-07-04",
                    "nationality" => "Paraguay",
                    "shirtNumber" => 11,
                    "marketValue" => 3500000,
                    "contract" => [
                        "start" => "2022-02",
                        "until" => "2023-12"
                    ]
                ],
                [
                    "id" => 11704,
                    "firstName" => "Agustín",
                    "lastName" => "Almendra",
                    "name" => "Agustín Almendra",
                    "position" => "Midfield",
                    "dateOfBirth" => "2000-02-11",
                    "nationality" => "Argentina",
                    "shirtNumber" => 32,
                    "marketValue" => 5000000,
                    "contract" => [
                        "start" => "2018-07",
                        "until" => "2023-06"
                    ]
                ],
                [
                    "id" => 22500,
                    "firstName" => "Jorman",
                    "lastName" => "Campuzano",
                    "name" => "Jorman Campuzano",
                    "position" => "Midfield",
                    "dateOfBirth" => "1996-04-30",
                    "nationality" => "Colombia",
                    "shirtNumber" => 21,
                    "marketValue" => 3000000,
                    "contract" => [
                        "start" => "2019-01",
                        "until" => "2023-06"
                    ]
                ],
                [
                    "id" => 32827,
                    "firstName" => "Esteban",
                    "lastName" => "Rolón",
                    "name" => "Esteban Rolón",
                    "position" => "Midfield",
                    "dateOfBirth" => "1995-03-25",
                    "nationality" => "Argentina",
                    "shirtNumber" => 14,
                    "marketValue" => 750000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2025-12"
                    ]
                ],
                [
                    "id" => 46129,
                    "firstName" => "Juan",
                    "lastName" => "Ramírez",
                    "name" => "Juan Ramírez",
                    "position" => "Midfield",
                    "dateOfBirth" => "1993-05-25",
                    "nationality" => "Argentina",
                    "shirtNumber" => 20,
                    "marketValue" => 4300000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 46379,
                    "firstName" => "Guillermo Matías",
                    "lastName" => null,
                    "name" => "Guillermo Fernández",
                    "position" => "Midfield",
                    "dateOfBirth" => "1991-10-11",
                    "nationality" => "Argentina",
                    "shirtNumber" => null,
                    "marketValue" => 3000000,
                    "contract" => [
                        "start" => "2022-01",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 46569,
                    "firstName" => "Diego",
                    "lastName" => "González",
                    "name" => "Diego González",
                    "position" => "Midfield",
                    "dateOfBirth" => "1988-02-09",
                    "nationality" => "Argentina",
                    "shirtNumber" => 23,
                    "marketValue" => 400000,
                    "contract" => [
                        "start" => "2020-10",
                        "until" => "2022-12"
                    ]
                ],
                [
                    "id" => 153629,
                    "firstName" => "Alan",
                    "lastName" => "Varela",
                    "name" => "Alan Varela",
                    "position" => "Midfield",
                    "dateOfBirth" => "2001-07-04",
                    "nationality" => "Argentina",
                    "shirtNumber" => 33,
                    "marketValue" => 6500000,
                    "contract" => [
                        "start" => "2021-01",
                        "until" => "2025-12"
                    ]
                ],
                [
                    "id" => 154595,
                    "firstName" => "Cristian",
                    "lastName" => "Medina",
                    "name" => "Cristian Medina",
                    "position" => "Midfield",
                    "dateOfBirth" => "2002-06-01",
                    "nationality" => "Argentina",
                    "shirtNumber" => 36,
                    "marketValue" => 6000000,
                    "contract" => [
                        "start" => "2020-08",
                        "until" => "2025-12"
                    ]
                ],
                [
                    "id" => 169052,
                    "firstName" => "Aaron",
                    "lastName" => "Molinas",
                    "name" => "Aaron Molinas",
                    "position" => "Midfield",
                    "dateOfBirth" => "2000-08-02",
                    "nationality" => "Argentina",
                    "shirtNumber" => 16,
                    "marketValue" => 4000000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2025-12"
                    ]
                ],
                [
                    "id" => 3219,
                    "firstName" => "Cristian",
                    "lastName" => "Pavón",
                    "name" => "Cristian Pavón",
                    "position" => "Offence",
                    "dateOfBirth" => "1996-01-21",
                    "nationality" => "Argentina",
                    "shirtNumber" => 31,
                    "marketValue" => 8500000,
                    "contract" => [
                        "start" => "2014-07",
                        "until" => "2022-06"
                    ]
                ],
                [
                    "id" => 11707,
                    "firstName" => "Darío",
                    "lastName" => "Benedetto",
                    "name" => "Darío Benedetto",
                    "position" => "Offence",
                    "dateOfBirth" => "1990-05-17",
                    "nationality" => "Argentina",
                    "shirtNumber" => 9,
                    "marketValue" => 3500000,
                    "contract" => [
                        "start" => "2022-01",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 16745,
                    "firstName" => "Eduardo",
                    "lastName" => "Salvio",
                    "name" => "Eduardo Salvio",
                    "position" => "Offence",
                    "dateOfBirth" => "1990-05-13",
                    "nationality" => "Argentina",
                    "shirtNumber" => 10,
                    "marketValue" => 4800000,
                    "contract" => [
                        "start" => "2019-07",
                        "until" => "2022-06"
                    ]
                ],
                [
                    "id" => 22485,
                    "firstName" => "Sebastián",
                    "lastName" => "Villa",
                    "name" => "Sebastián Villa",
                    "position" => "Offence",
                    "dateOfBirth" => "1996-05-19",
                    "nationality" => "Colombia",
                    "shirtNumber" => 22,
                    "marketValue" => 5500000,
                    "contract" => [
                        "start" => "2018-07",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 45886,
                    "firstName" => "Norberto",
                    "lastName" => "Briasco",
                    "name" => "Norberto Briasco",
                    "position" => "Offence",
                    "dateOfBirth" => "1996-02-29",
                    "nationality" => "Armenia",
                    "shirtNumber" => 29,
                    "marketValue" => 1700000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2025-12"
                    ]
                ],
                [
                    "id" => 82025,
                    "firstName" => "Nicolás",
                    "lastName" => "Orsini",
                    "name" => "Nicolás Orsini",
                    "position" => "Offence",
                    "dateOfBirth" => "1994-09-12",
                    "nationality" => "Argentina",
                    "shirtNumber" => 27,
                    "marketValue" => 1700000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2024-12"
                    ]
                ],
                [
                    "id" => 153632,
                    "firstName" => "Exequiel",
                    "lastName" => "Zeballos",
                    "name" => "Exequiel Zeballos",
                    "position" => "Offence",
                    "dateOfBirth" => "2002-04-24",
                    "nationality" => "Argentina",
                    "shirtNumber" => 7,
                    "marketValue" => 5000000,
                    "contract" => [
                        "start" => "2020-07",
                        "until" => "2025-12"
                    ]
                ],
                [
                    "id" => 156967,
                    "firstName" => "Luis",
                    "lastName" => "Vázquez",
                    "name" => "Luis Vázquez",
                    "position" => "Offence",
                    "dateOfBirth" => "2001-01-24",
                    "nationality" => "Argentina",
                    "shirtNumber" => 38,
                    "marketValue" => 3800000,
                    "contract" => [
                        "start" => "2021-07",
                        "until" => "2025-12"
                    ]
                ]
            ],
            "staff" => [
            ],
            "lastUpdated" => "2022-04-06T13:12:25Z"
        ];

        $outputArray = $this->apiMapper->Map($jayParsedAry);

        self::assertSame('156967', $outputArray[31]->id);
        self::assertSame('154595', $outputArray[22]->id);

    }
}