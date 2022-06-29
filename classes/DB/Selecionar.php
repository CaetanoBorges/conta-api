<?php

namespace ContaAPI\Classes\DB;

class Selecionar
{

    private $query = "";
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo=$pdo;
    }


    public function select(array $fields = [])
    {
        $this->query .= sprintf("SELECT %s ", sizeof($fields) ? implode(", ", $fields) : "*");

        return $this;
    }

    public function from(string $tableName)
    {
        $this->query .= " FROM {$tableName} ";

        return $this;
    }

    public function where(array $conditions)
    {
        $this->query .= sprintf("WHERE %s ", implode(" AND ", $conditions));

        return $this;
    }

    public function offset(int $offset)
    {
        $this->query .= "OFFSET {$offset} ";

        return $this;
    }

    public function limit(int $limit)
    {
        $this->query .= "LIMIT {$limit} ";

        return $this;
    }

    public function orderBy(string $orderRule)
    {
        $this->query .= "ORDER BY {$orderRule} ";

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function pegaResultado(){
        $statement = $this->pdo->prepare($this->getQuery());
        $statement->execute();
        return $statement->fetch();
    }
    public function pegaResultados(){
        $statement = $this->pdo->prepare($this->getQuery());
        $statement->execute();
        return $statement->fetchAll();
    }
}