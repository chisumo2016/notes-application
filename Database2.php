<?php
/**connect to mysql database and execute a query*/

class Database2
{
    public $connection; //instance property
    public $statement;
    public  function  __construct($config ,  $username='root', $password='')
    {


        $dsn = 'mysql:' . http_build_query($config, '', ';'); //host=localhost;port=3306;dbnname=myapp

        //$dsn = "mysql:host=localhost;port=3306;dbname=website-application;charset=utf8mb4";
        //$dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        //$pdo =new PDO($dsn, 'root');
    }
    public  function query($query, $params = [])
    {

        //$statement = $pdo->prepare($query); //"select * from posts"
        $statement = $this->connection->prepare($query); //"select * from posts"
        //$this->statement = $this->connection->prepare($query); //"select * from posts"

        $statement->execute($params);
        //$this->statement->execute($params);

        //return  $statement;
        return  $this; //returning the object (Database not PDO)
    }

    public function find()
    {
        //$statement->fetch();
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();

        if (! $result){
            abort();
        }

        return $result;
    }
}