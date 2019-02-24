<?php

if (!function_exists('mysql_error')) {
    function mysql_error()
    {
        return mysqli_error($GLOBALS['dbglobal']);
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query)
    {
        return mysqli_query($GLOBALS['dbglobal'], $query);
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($query)
    {
        return mysqli_fetch_assoc($query);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($query)
    {
        return mysqli_fetch_array($query, MYSQLI_ASSOC);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($query)
    {
        return mysqli_num_rows($query);
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id()
    {
        return mysqli_insert_id($GLOBALS['dbglobal']);
    }
}

if (!function_exists('mysql_data_seek')) {
    function mysql_data_seek($a, $b = 0)
    {
        return mysqli_data_seek($a, $b);
    }
}

if (!function_exists('mysql_result')) {
    function mysql_result($res, $row = 0, $col = 0)
    {
        $numrows = mysqli_num_rows($res);
        if ($numrows && $row <= ($numrows - 1) && $row >= 0) {
            mysqli_data_seek($res, $row);
            $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
            if (isset($resrow[$col])) {
                return $resrow[$col];
            }
        }
        return false;
    }
}
