<?php

class Modal
{
    public $order = 'desc';
    public $limit = 10;
    public $offset = 0;

    public $errors = [];
    protected $table = "";
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
        $query .= " (`" . implode("`,`", $keys) . "`) values (:" . implode(",:", $keys) . ")";
        $query .= " returning *";

        $result = $this->db->query($query, $data);

        // if (!empty($select_key)) return $this->one([$select_key => $data[$select_key]]);
        if (empty($result)) $result = null;

        if (!empty($result[0])) $result = $result[0];

        return $result;
    }

    public function find($data = [], $attributes = [], $include = [], $options = [])
    {
        $keys = array_keys($data);
        $type = 'object';

        $query = "select ";
        /* set attributes */
        if (count($attributes) > 0) {
            foreach ($attributes as $attribute) {
                $query .= $attribute . ", ";
            }
        } else {
            $query .= "* ";
        }
        $query = trim($query, ", ");

        /* set table */
        $query .= " from " . $this->table;

        /* left join */
        if (count($include) > 0) {
            foreach ($include as $item) {
                $query .= " left join " . $item['table'] . " as " . $item['as'] . " on " . $item['on'];
            }
        }

        /* where clause */
        if (count($data) > 0) {
            $query .= " where ";
        }
        foreach ($keys as $key) {
            $operator = '=';
            $value = $key;

            /* if the data is an array of options */
            if (is_array($data[$key])) {
                $operator = $data[$key]['operator'];
                $data[$key] = $data[$value]['data'];
            }

            /* handle joined table columns */
            $multi_keys = explode('.', $key);
            if (count($multi_keys) > 1) {
                $value = $multi_keys[1];
                $data[$value] = $data[$key];

                unset($data[$key]);
            }

            $query .= $key . " " . $operator . " :" . $value . " && ";
        }
        $query = trim($query, "&& ");

        /* order by */
        $query .= " order by $this->table.id $this->order limit $this->limit offset $this->offset";

        /* set type */
        if (!empty($options['type'])) {
            $type = $options['type'];
        }

        $res = $this->db->query($query, $data, $type);

        if (is_array($res)) {
            return $res;
        }

        return [];
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

    public function update($where, $data)
    {
        /* remove unwanted columns */
        if (!empty($this->allowed_columns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowed_columns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $where_keys = array_keys($where);
        $query = "update " . $this->table . " set ";

        /* update columns */
        foreach ($keys as $key) {
            $query .= "`" . $key . "`" . "=:" . $key . ",";
        }
        $query = trim($query, ",");

        /* where columns */
        $query .= " where ";
        foreach ($where_keys as $where_key) {
            $query .= $where_key . "=:" . $where_key . ",";
        }
        $query = trim($query, ",");

        /* merge array and where data */
        $data = array_merge($data, $where);

        $this->db->query($query, $data);
    }

    public function delete($data)
    {
        $keys = array_keys($data);

        $query = "delete from " . $this->table . " where ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }

        $query = trim($query, "&& ");

        $this->db->query($query, $data);

        return true;
    }
}
