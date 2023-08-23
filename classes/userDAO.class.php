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

    public function getValidatedUser(string $email, string $password) : ?User
    {
        $user = null;
        $req = $this->db->prepare('SELECT * FROM users WHERE email=:email');
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        var_dump($req->rowCount());
        if ($req->rowCount() > 0){
            $line = $req->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $line['password'])) {
                $user = new User($line['email'], $line['password'], $line['first_name'], $line['last_name'], $line['shipping_address']);
                $user->setId($line['id']);
            }
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