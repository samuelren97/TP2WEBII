<?php 
declare(strict_types=1);
require_once('userDAO.class.php');

class User {
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $shippingAddress;

    public function __construct(string $email, string $password, string $firstName, string $lastName, string $shippingAddress) {
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setShippingAddress($shippingAddress);
    }

    public function getEmail() : string {
        return $this->email;
    }
    public function setEmail(string $email) : void {
        if ($email == null || empty(trim($email)))
            throw new Exception('The email cannot be empty or null');
        $this->email = $email;
    }

    public function getPassword() : string {
        return $this->password;
    }
    public function setPassword(string $password) : void {
        if ($password == null || empty(trim($password)))
            throw new Exception('The password cannot be empty or null');
        $this->password = $password;
    }

    public function getFirstName() : string {
        return $this->firstName;
    }
    public function setFirstName(string $firstName) : void {
        if ($firstName == null || empty(trim($firstName)))
            throw new Exception('The first name cannot be empty or null');
        $this->firstName = $firstName;
    }

    public function getLastName() : string {
        return $this->lastName;
    }
    public function setLastName(string $lastName) : void {
        if ($lastName == null || empty(trim($lastName)))
            throw new Exception('The last name cannot be empty or null');
        $this->lastName = $lastName;
    }

    public function getShippingAddress() : string {
        return $this->shippingAddress;
    }
    public function setShippingAddress(string $shippingAddress) : void {
        if ($shippingAddress == null || empty(trim($shippingAddress)))
            throw new Exception('The shippingAddress cannot be empty or null');
        $this->shippingAddress = $shippingAddress;
    }
}
?>