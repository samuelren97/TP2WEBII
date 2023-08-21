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

    public function getValidatedUser(string $email, string $password) : User
    {
        $user = null;
        $req = $this->db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $req->execute();

        if ($line = $req->fetch(PDO::FETCH_ASSOC)){
            $user = new User($line['email'], $line['password'], $line['firstName'], $line['lastName'], $line['shippingAddress']);
            $user->setId($line['id']);
        }
        $req->closeCursor();
        return $user;
    }
    
    public function add(User $user): void
    {
        $req = $this->db->prepare('INSERT INTO users(email,password,first_name,last_name,shipping_address)
        VALUES (:email, :password, :first_name, :last_name, :shipping_address)');

        
        $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $req->bindValue(':first_name', $user->getFirstName(), PDO::PARAM_STR);
        $req->bindValue(':last_name', $user->getLastName(), PDO::PARAM_STR);
        $req->bindValue(':shipping_address', $user->getShippingAddress(), PDO::PARAM_STR);

        $req->execute();
        
        
        $last_id = $this -> db->lastInsertId();
        $user->setId((int)$last_id);

        $req->closeCursor();
    }
}
?>