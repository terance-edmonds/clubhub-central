<?php

class Database
{
    protected $con;

    public function connect()
    {
        $str = DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME;
        $this->con = new PDO($str, DB_USER, DB_PASS, array(
            PDO::ATTR_PERSISTENT => true
        ));
    }

    public function query($query, $data = [], $type = 'object')
    {
        if (empty($this->con)) $this->connect();

        $stm = $this->con->prepare($query);

        if ($stm) {
            $check = $stm->execute($data);

            if ($check) {
                if ($type == 'group') {
                    $type = PDO::FETCH_GROUP | PDO::FETCH_ASSOC;
                } else if ($type == 'array') {
                    $type = PDO::FETCH_ASSOC;
                } else {
                    $type = PDO::FETCH_OBJ;
                }

                $result = $stm->fetchAll($type);

                /* if there is a result return it */
                if (is_array($result) && count($result) > 0) return $result;
            }
        }

        return false;
    }

    public function transaction()
    {
        if (empty($this->con)) $this->connect();

        $this->con->beginTransaction();
    }

    public function commit()
    {
        $this->con->commit();
    }

    public function rollback()
    {
        $this->con->rollBack();
    }
}
