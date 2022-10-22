<?php

class Functions
{
    function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    function array_unset_duplicate($array)
    {
        $check = array();
        foreach ($array as $key => $val) {
            if (isset($check[$val])) {
                unset($array[$key]);
            } else {
                $check[$val] = $key;
            }
        }
        return $array;
    }

    function array_group_by_col($array, $col)
    {
        $result = array();
        foreach ($array as $element) {
            $val = $element[$col];
            if (!isset($set[$val])) {
                array_push($result, $val);
                $set[$val] = true;
            }
        }
        return $result;
    }
}
