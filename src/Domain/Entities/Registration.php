<?php


declare(strict_types=1);


namespace App\Domain\Entities;


use DateTimeInterface;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;


final class Registration
{
    private string $name;

    private Email $email;

    private Cpf $number;

    private DateTimeInterface $birthDate;

    private DateTimeInterface $registrationAt;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Registration
     */
    public function setName(string $name): Registration
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     * @return Registration
     */
    public function setEmail(Email $email): Registration
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Cpf
     */
    public function getNumber(): Cpf
    {
        return $this->number;
    }

    /**
     * @param Cpf $number
     * @return Registration
     */
    public function setNumber(Cpf $number): Registration
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param DateTimeInterface $birthDate
     * @return Registration
     */
    public function setBirthDate(DateTimeInterface $birthDate): Registration
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getRegistrationAt(): DateTimeInterface
    {
        return $this->registrationAt;
    }

    /**
     * @param DateTimeInterface $registrationAt
     * @return Registration
     */
    public function setRegistrationAt(DateTimeInterface $registrationAt): Registration
    {
        $this->registrationAt = $registrationAt;
        return $this;
    }

}
