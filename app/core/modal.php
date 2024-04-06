<?php

class Modal
{
    public $order = 'desc';
    public $limit = 10;
    public $offset = 0;
    public $errors = [];

    protected $table = "";
    public $order_column = "";
    protected $allowed_columns = [];
    protected $search_columns = [];
    protected $db = null;

    function __construct($db = new Database())
    {
        $this->db = $db;
        /* set the default order column */
        $this->order_column = $this->table . '.id';
    }

    public function create($data)
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

        if (empty($result)) $result = null;

        if (!empty($result[0])) $result = $result[0];

        return $result;
    }

    public function find($data = [], $attributes = [], $include = [], $options = [], $search = '')
    {
        $keys = array_keys($data);
        $type = 'object';
        $join = 'left';

        /* set options */
        if (!empty($options['limit']) && is_numeric($options['limit'])) {
            $this->limit = $options['limit'];
        }
        if (!empty($options['offset']) && is_numeric($options['offset'])) {
            $this->offset = $options['offset'];
        }
        if (!empty($options['order']) && is_string($options['order'])) {
            $this->order = $options['order'];
        }
        if (!empty($options['order_column']) && is_string($options['order_column'])) {
            $this->order_column = $options['order_column'];
        }

        if (!empty($options['all']) && $options['all'] == true) {
            $this->limit = 0;
            $this->offset = 0;
        }
        if (!empty($options['join'])) {
            $join = $options['join'];
        }

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

        /* join */
        if (count($include) > 0) {
            foreach ($include as $item) {
                $query .= " " . $join . " join " . $item['table'] . " as " . $item['as'] . " on " . $item['on'];
            }
        }

        /* where clause */
        if (count($data) > 0) {
            $query .= " where ";
        }
        foreach ($keys as $key) {
            $condition = '&&';
            $operator = '=';
            $value = $key;

            /* if the data is an array of options */
            if (is_array($data[$key])) {
                if (!empty($data[$key]['condition'])) $condition = $data[$key]['condition'];
                if (!empty($data[$key]['operator'])) $operator = $data[$key]['operator'];
                $data[$key] = $data[$value]['data'];
            }

            /* handle joined table columns */
            $multi_keys = explode('.', $key);
            if (count($multi_keys) > 1) {
                $value = $multi_keys[1];
                $data[$value] = $data[$key];

                unset($data[$key]);
            }

            $query .= $key . " " . $operator . " :" . $value . " " . $condition . " ";
        }
        $query = trim($query, "&& ");
        $query = trim($query, "|| ");

        /* search query */
        if (!empty($search)) {
            $condition = '&&';

            if (!empty($options['search']) && is_array($options['search'])) {
                $query .= " && ( ";

                foreach ($options['search'] as $search_key) {
                    $query .= $search_key . " like '%" . $search . "%' || ";
                }

                $query = trim($query, "|| ");
                $query .= ' )';

                $condition = '||';
            }

            if (!empty($this->search_columns)) {
                $query .= " " . $condition . " match(" . implode(',', $this->search_columns) . ") against ('" . $search . '*' . "' IN BOOLEAN MODE)";
            }
        }

        /* order by */
        $query .= " order by $this->order_column $this->order";
        if (!empty($this->limit)) $query .= ' limit ' . $this->limit;
        if (!empty($this->offset)) $query .= ' offset ' . $this->offset;

        /* set type */
        if (!empty($options['type'])) {
            $type = $options['type'];
        }

        // print_r($query);
        // die;
        $res = $this->db->query($query, $data, $type);

        if (is_array($res)) {
            return $res;
        }

        return [];
    }

    public function one($data, $attributes = [], $include = [])
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
        $query .= " order by $this->table.id $this->order limit 1";

        /* set type */
        if (!empty($options['type'])) {
            $type = $options['type'];
        }

        $res = $this->db->query($query, $data, $type);

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

    public function delete($where)
    {
        $keys = array_keys($where);

        $query = "delete from " . $this->table . " where ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }

        $query = trim($query, "&& ");

        $this->db->query($query, $where);

        return true;
    }
}
