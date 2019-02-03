<?php

class users
{
    private $table;
    private $errors = [];
    private $connection;

    private $user;

    public function __construct(PDO $connection, $table = 'users')
    {
        $this->table = $table;
        $this->connection = $connection;
    }

    /**
     * @param \stdClass $user
     * @return bool
     */
    public function signUp(\stdClass $user)
    {
        if ($this->checkUsername($user->username)) {
            $this->errors [] = "username is already taken";
            return false;
        }

        if (strlen($user->password) < 4) {
            $this->errors [] = "password is too short";
            return false;
        }

        $query = "INSERT INTO $this->table (name,username,password,created_at) VALUES(?,?,?,?)";
        $statement = $this->connection->prepare($query);
        $values = [
            $user->name,
            $user->username,
            Hash::make($user->password, $user->username),
            $user->created_at,
        ];

        return $statement->execute($values) ? true : false;
    }

    public function checkUsername($username = '')
    {
        $query = "SELECT * from $this->table WHERE username='$username'";
        $rows = $this->connection->query($query);
        foreach ($rows as $row)
            return $row ['username'] == $username ? true : false;
        return false;
    }

    public function signIn($username, $password)
    {
        $password = Hash::make($password, $username);
        if ($this->checkUser($username, $password))
            return $this->Auth();

        $this->errors [] = "Invalid username or password";
        return false;
    }

    public function checkUser($username = '', $password = '')
    {
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(array('username' => $username, 'password'=>$password));
        if ($stmt == false)
            return false;
        foreach ($stmt as $key => $row) {
            $this->user = $row;
            return true;
        }
        return false;
    }

    private function Auth()
    {
        if (!isset($this->user))
            return false;

        $_SESSION ['user']['id'] = $this->user['id'];
        $_SESSION ['user']['username'] = $this->user['username'];
        $_SESSION ['user']['name'] = $this->user['name'];
        return true;
    }

    /**
     * @return array|bool|\PDOStatement
     */
    public function getUsers()
    {
        $query = "SELECT id,name from $this->table";
        if (!$rows = $this->connection->query($query))
            return [];

        return $rows->fetchAll();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}