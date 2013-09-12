<?php

date_default_timezone_set('Europe/Kiev');

//header("Content-type: text/txt");

/*
 * Класс для быстрого подключения и манипуляции MySQL
 */

class db {

        var $host = 'mysql.service-toshiba.myjino.ru',
                $user = 'service-toshiba',
                $password = 'nixon2012',
                $db = 'service-toshiba_okred',
                $authorized = false,
                $db_selected = false,
                $show_query = false,
                $connection = null;

        function connect($h = NULL, $u = NULL, $p = NULL) {
                if ((!$this->authorized)) {
                        $this->connection = mysqli_connect(
                                ($h ? $h : $this->host), ($u ? $u : $this->user), ($p ? $p : $this->password)
                        );
                        $this->authorized = true;
                        return true;
                } else {
                        echo '<b>Notice:</b> Data base already connected.</br>';
                        return false;
                }
        }

        function close() {
                return mysqli_close($this->connection);
        }

        function select_db($db = NULL) {
                if ((!$this->db_selected)) {
                        $this->db = ($db ? $db : $this->db);
                        mysqli_select_db($this->connection, $this->db);
                        $this->db_selected = true;
                        return true;
                } else {
                        echo '<b>Notice:</b> Data base already choosed.</br>';
                        return true;
                }
        }

        function authorizate() {
                if ((!$this->authorized)) {
                        $this->connect();
                }
                if ((!$this->db_selected)) {
                        $this->select_db($this->db);
                }
                return false;
        }

        function query($q) {
                if ($this->show_query) {
                        if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) )
                                echo '<hr/><pre>' . $q . '<br/><span style="margin: 0 0 0 20px;">';
                }
                $this->authorizate();
                $res = mysqli_query($this->connection, $q) or die(mysqli_error($this->connection));
                if (!is_bool($res)) {
                        $return = array();
                        while ($rec = mysqli_fetch_assoc($res)) {
                                $return[] = $rec;
                        }
                } else {
                        $return = $res;
                }
                
                if ($this->show_query) {
                        var_dump($return);
                        if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) )
                                echo '</span></pre><hr/>';
                        else
                                echo PHP_EOL;
                }
                return $return;
        }

        function anyfrom($table, $limit = 0) {
                return $this->query(
                                "SELECT * FROM `$table`" . ($limit ? ' LIMIT ' . $limit : '')
                );
        }
        
        function find($table, $needle = array('1', '1'), $fields = '* ', $limit = 0) {
                $this->escape($needle);
                $this->escape($fields);
                $q = 'SELECT ';
                if(is_string($fields) ) {
                        $q .= $fields;
                } else {
                        foreach ($fields as $value) {
                                $q .= '`'.$value.'`,';
                        }
                }
                $q = substr($q, 0, -1).' FROM `'.$table.'` WHERE `'.$needle[0].'`=\''.$needle[1].'\'';
                if( sizeof($needle) > 4 )
                        $q .= ' '.$needle[2].' `'.$needle[3].'`=\''.$needle[4].'\'';
                if($limit !== 0)
                        $q .= ' LIMIT '.$limit;
                $q .= ';';
                return $this->query($q);
        }
        
        function findSingle($table, $needle = array('1', '1'), $fields = '* ') {
                return $this->find($table, $needle, $fields, 1);
        }

        function insert($to, $objects) {
                $objects = $this->escape($objects);
                $q = "INSERT INTO `$this->db`.`$to` (";
                foreach ($objects as $key => $value) {
                        $q .= '`' . $key . '`, ';
                }
                $q = substr($q, 0, -2) . ') VALUES (';
                foreach ($objects as $value) {
                        if (is_numeric($value)) {
                                $q .= $value . ', ';
                        } else if (($value !== 'CURRENT_TIMESTAMP')) {
                                $q .= "'" . $value . "', ";
                        } else {
                                $q .= $value . ', ';
                        }
                }
                $q = substr($q, 0, -2) . ');';
                return $this->query($q);
        }

        function update($to, $objects, $needle = array('', ''), $limit = 0) {
                if (empty($needle[0]) || empty($needle[1]))
                        return;
                $objects = $this->escape($objects);
                $q = "UPDATE `$this->db`.`$to` SET ";
                foreach ($objects as $key => $value) {
                        if (!is_array($value)) {
                                $q .= '`' . $key . '`=\'' . $value . '\', ';
                        } else {
                                if (is_numeric($value[1])) {
                                        $q .= '`' . $key . '`=`' . $key . '` ' . $value[0] . ' \'' . $value[1] . '\', ';
                                } else {
                                        //concat
                                        $q .= '`' . $key . '`=concat(`' . $key . '`, \'' . $value[1] . '\'), ';
                                }
                        }
                }
                $q = substr($q, 0, -2) . ' WHERE `' . $to . '`.`' . $needle[0] . '` = \'' . $needle[1] . '\'';
                if ($limit !== 0) {
                        $q .= ' LIMIT ' . $limit;
                }
                $q .= ';';
                return $this->query($q);
        }
        
        function delete($from, $needle = array('', ''), $limit = 1) {
                if (empty($needle[0]) || empty($needle[1]) || empty($from))
                        return;
                $q = 'DELETE FROM `'.$from.'` WHERE `' . $needle[0] . '` = \'' . $needle[1] . '\'';
                if ($limit !== 0) {
                        $q .= ' LIMIT ' . $limit;
                }
                $q .= ';';
                return $this->query($q);
        }
        
        public function escape($input) {
                if( is_array($input) ) {
                        $out = array();
                        foreach($input as $k => $v) {
                                if( is_array($v) ) {
                                        $out[mysqli_real_escape_string($this->connection, $k)] = $this->escape($v);
                                } else {
                                        $out[mysqli_real_escape_string($this->connection, $k)] = mysqli_real_escape_string($this->connection, $v);
                                }
                        }
                        return $out;
                } else {
                        return mysqli_real_escape_string($this->connection, $input);
                }
        }

}

$db = new db;
$db->authorizate();

?>