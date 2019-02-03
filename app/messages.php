<?php

class messages
{
    private $table;
    private $connection;

    private $user;

    public function __construct(PDO $connection, $table = 'messages')
    {
        $this->table = $table;
        $this->connection = $connection;
    }

    /**
     * @param \stdClass $line
     * @return bool
     */
    public function sendMessage(\stdClass $line)
    {
        $query = "INSERT INTO $this->table (`from`,`to`,`message`,`created_at`) VALUES(?,?,?,?)";
        $statement = $this->connection->prepare($query);
        $values = [
            (int)$line->from,
            (int)$line->to,
            $line->message,
            $line->created_at,
        ];
        return $statement->execute($values) ? true : false;
    }


    /**
     * @return array|bool|\PDOStatement
     */
    public function getMessages($id = null)
    {
        $where = "";
        if ($id != null)
            $where = "WHERE messages.to ='$id' or messages.from = '$id'";

        $query = "SELECT $this->table.* , users.name as sender_name 
                from $this->table left join users on users.id = `messages`.`from` $where";

        if (!$rows = $this->connection->query($query))
            return [];

        return $rows->fetchAll();
    }
}