<?php


namespace app\services\dto;


class RecruitData
{
    public string $firstName;
    public string $lastName;
    public string $address;
    public string $email;

    public function __construct($firstName, $lastName, $address, $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->email = $email;
    }
}