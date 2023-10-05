<?php

class Modal
{
    public $order = 'desc';
    public $limit = 10;
    public $offset = 0;

    public $errors = [];
    protected $table = "users";
    protected $allowed_columns = [];
    protected $db = null;

    function __construct($db = new Database())
    {
        $this->db = $db;
    }

    public function create($data, $select_key = '')
    {
        if (!empty($this->allowed_columns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowed_columns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "insert into " . $this->table . " ";
        $query .= " (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")";

        $this->db->query($query, $data);

        if (!empty($select_key)) return $this->one([$select_key => $data[$select_key]]);

        return false;
    }

    public function find($data)
    {
        $keys = array_keys($data);

        $query = "select * from " . $this->table . " where ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $query .= " order by id $this->order limit $this->limit offset $this->offset";
        $res = $this->db->query($query, $data);

        if (is_array($res)) {
            return $res;
        }

        return false;
    }

    public function one($data)
    {
        $keys = array_keys($data);

        $query = "select * from " . $this->table . " where ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $query .= " order by id $this->order limit 1";

        $res = $this->db->query($query, $data);

        if (is_array($res)) {
            return $res[0];
        }

        return false;
    }
}
