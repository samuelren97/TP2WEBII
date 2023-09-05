<?php
declare(strict_types=1);

class UserDAO
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db)
    {
        $this->db = $db;
    }

    public function getUserWithEmail(string $email) : ?User
    {
        if ($email == null || empty(trim($email)))
            throw new Exception('The email cannot be empty or null');
        if (!isValidEmail($email))
            throw new Exception('Email must be in correct format');

        $user = null;
        $req = $this->db->prepare('SELECT * FROM users WHERE email=:email');
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        if ($req->rowCount() > 0){
            $line = $req->fetch(PDO::FETCH_ASSOC);
            $user = new User($line['email'], $line['password'], $line['first_name'], $line['last_name'], $line['shipping_address']);
        }

        $req->closeCursor();
        return $user;
    }

    public function getValidatedUser(string $email, string $password) : ?User
    {
        if ($email == null || empty(trim($email)))
            throw new Exception('The email cannot be empty or null');
        if (!isValidEmail($email))
            throw new Exception('Email must be in correct format');

        if ($password == null || empty(trim($password)))
            throw new Exception('The password cannot be empty or null');

        $user = null;
        $req = $this->db->prepare('SELECT * FROM users WHERE email=:email');
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        if ($req->rowCount() > 0){
            $line = $req->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $line['password'])) {
                $user = new User($line['email'], $line['password'], $line['first_name'], $line['last_name'], $line['shipping_address']);
            }
        }

        $req->closeCursor();
        return $user;
    }

    public function userExists(string $email) : bool {
        if ($email == null || empty(trim($email)))
            throw new Exception('The email cannot be empty or null');
        if (!isValidEmail($email))
            throw new Exception('Email must be in correct format');

        $req = $this->db->prepare('SELECT email FROM users WHERE email=:email');

        $req->bindValue(':email', $email, PDO::PARAM_STR);

        $req->execute();

        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
    public function add(User $user): void
    {
        if ($user == null)
            throw new Exception('User cannot be null');

        $req = $this->db->prepare('INSERT INTO users(email,password,first_name,last_name,shipping_address)
        VALUES (:email, :password, :first_name, :last_name, :shipping_address)');

        
        $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $req->bindValue(':first_name', $user->getFirstName(), PDO::PARAM_STR);
        $req->bindValue(':last_name', $user->getLastName(), PDO::PARAM_STR);
        $req->bindValue(':shipping_address', $user->getShippingAddress(), PDO::PARAM_STR);

        $req->execute();

        $req->closeCursor();
    }
}
?>