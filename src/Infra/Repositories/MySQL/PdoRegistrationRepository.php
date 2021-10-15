<?php


declare(strict_types=1);


namespace App\Infra\Repositories\MySQL;


use DateTimeImmutable;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Domain\Entities\Registration;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\Exceptions\RegistrationNotFoundException;


final class PdoRegistrationRepository implements LoadRegistrationRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws RegistrationNotFoundException
     */
    public function loadByRegistrationNumber(Cpf $cpf): Registration
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM `registrations` WHERE `number` = :cpf"
        );
        $statement->execute(array(':cpf' => $cpf));
        $record = $statement->fetch();

        if (!$record) {
            throw new RegistrationNotFoundException($cpf);
        }

        $registration = new Registration();
        return $registration
            ->setName($record['name'])
            ->setBirthDate(new DateTimeImmutable($record['birth_date']))
            ->setEmail(new Email($record['email']))
            ->setRegistrationAt(new DateTimeImmutable($record['created_at']))
            ->setNumber(new Cpf($record['number']));
    }
}
