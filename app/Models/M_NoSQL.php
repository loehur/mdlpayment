<?php

class M_NoSQL
{
    private $db;

    public function __construct()
    {
        $this->db = NoSQL::getInstance();
    }

    //GET
    public function get($table)
    {
        $getAll = $this->db->retrieve($table);
        return json_decode($getAll, true);
    }

    public function get_where($table, $whereKey, $whereVal, $op)
    {
        $getAll = array();
        $getAll = $this->get($table);

        $whereKey_arr = explode(',', $whereKey);
        $whereVal_arr = explode(',', $whereVal);
        $op_arr = explode(',', $op);
        $whereCount = count($whereKey_arr);
        $countContentArr = 0;

        foreach ($getAll as $id => $a) {
            $validCount = 0;
            if (is_array($a)) {
                $count = count($a);
                if ($count > $countContentArr) {
                    $countContentArr =  $count;
                }
                foreach ($a as $keyA => $val2) {
                    foreach ($whereKey_arr as $kaKey => $ka) {
                        if ($op_arr[$kaKey] == 0) {
                            if ($keyA == $ka && $val2 == $whereVal_arr[$kaKey]) {
                                $validCount += 1;
                            }
                        } elseif ($op_arr[$kaKey] == 1) {
                            if ($keyA == $ka && $val2 <> $whereVal_arr[$kaKey]) {
                                $validCount += 1;
                            }
                        }
                    }
                }
            } else {
                unset($getAll[$id]);
            }
            if ($validCount <> $whereCount) {
                unset($getAll[$id]);
            }
        }
        return $getAll;
    }

    public function get_where_row($table, $whereKey, $whereVal, $op)
    {
        $return = array();
        $data = $this->get_where($table, $whereKey, $whereVal, $op);
        foreach ($data as $id => $du) {
            $return = $du;
            break;
        }
        return $return;
    }


    public function update($table, $id, $data)
    {
        return $this->db->update($table, $id, $data);
    }
}
