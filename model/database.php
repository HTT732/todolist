<?php
/**
 * @package todolist
 * @author  todolist
 * @copyright   Copyright (c) 2021, todolist
 * @since   Version 1.0
 */
class Database
{
    /**
     * $host
     * @var string
     */
    private $host = 'localhost';

    /**
     * $username
     * @var string
     */
    private $userName = 'root';

    /**
     * $password
     * @var string
     */
    private $password = '';

    /**
     * $databaseName
     * @var string
     */
    private $databaseName = 'todolist';

    /**
     * $charset
     * @var string
     */
    private $charset = 'utf8';

    /**
     * $conn
     * @var [objetc]
     */
    private $conn;

    /**
     * __construct
     * @return void;
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * connect database
     * @return void
     */
    public function connect()
    {
        if(!$this->conn){
            $this->conn = mysqli_connect($this->host, $this->userName, $this->password, $this->databaseName);
            if (mysqli_connect_error()) {
                echo 'Failed: '. mysqli_connect_error();
                die();
            }
            mysqli_set_charset($this->conn,$this->charset);
        }
    }

    /**
     * disConnect
     * @return void
     */
    public function disConnect()
    {
        if($this->conn)
            mysqli_close($this->conn);
    }

    /**
     * error show error
     * @return string
     */
    public function error()
    {
        if($this->conn)
            return mysqli_error($this->conn);
        else
            return false;
    }

    /**
     * insert data
     * @param string $table insert, array insert
     * @return boolean
     */
    public function insert($table = '', $data = [])
    {
        $keys = '';
        $values= '';
        foreach ($data as $key => $value) {
            $keys .= ',' . $key;
            $values .= ',"' . mysqli_real_escape_string($this->conn,$value).'"';
        }
        $sql = 'INSERT INTO ' .$table . '(' . trim($keys,',') . ') VALUES (' . trim($values,',') . ')';
        return mysqli_query($this->conn,$sql);
    }

     /**
     * get last id
     * @param string $table
     * @return id
     */
    public function lastId($table) {
        $sql = "SELECT MAX(id) as id FROM ". $table . "";
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_array($result);
        return $row['id'];
    }

    /**
     * update edit data
     * @param string $table table edit, array $data edit
     * @return boolean
     */
    public function update($table = '',$data = [], $id)
    {
        $content = '';
        if(is_integer($id))
            $where = 'id = '.$id;
        else if(is_array($id) && count($id)==1){
            $listKey = array_keys($id);
            $where = $listKey[0].'='.$id[$listKey[0]];
        }
        else
            die('Không thể có nhiều hơn 1 khóa chính và id truyền vào phải là số');
        foreach ($data as $key => $value) {
            $content .= ','. $key . '="' . mysqli_real_escape_string($this->conn,$value).'"';
        }
        $sql = 'UPDATE ' .$table .' SET '.trim($content,',') . ' WHERE ' . $where ;
        return mysqli_query($this->conn,$sql);
    }

    /**
     * delete
     * @param string $table , array|int condition
     * @return boolean
     */
    public function delete($table= '', $id)
    {
        $content = '';
        if(is_integer($id))
            $where = 'id = '.$id;
        else if(is_array($id) && count($id)==1){
            $listKey = array_keys($id);
            $where = $listKey[0].'='.$id[$listKey[0]];
        }
        else
            die('Không thể có nhiều hơn 1 khóa chính và id truyền vào phải là số');
        $sql = 'DELETE FROM ' . $table . ' WHERE '. $where;
        return mysqli_query($this->conn,$sql);
    }

    /**
     * getObject get all return object
     * @param string $table tên bảng muốn lấy ra dữ liệu
     * @return array objetc
     */
    public function getObject($table = '')
    {
        $sql = 'SELECT * FROM '. $table;
        $data = null;
        if($result = mysqli_query($this->conn,$sql)){
            while($row = mysqli_fetch_object($result)){
                $data[] = $row;
            }
            mysqli_free_result($result);
            return $data;
        }
        return false;
    }

    /**
     * getObject get all data return array data
     * @param string $table tên bảng muốn lấy dữ liệu
     * @return array
     */
    public function getArray($table = '')
    {
        $sql = 'SELECT * FROM '. $table;
        $data = null;
        if($result = mysqli_query($this->conn,$sql)){
            while($row = mysqli_fetch_array($result)){
                $data[] = $row;
            }
            mysqli_free_result($result);
            return $data;
        }
        else
            return false;
    }

    /**
     * getRowObject get row return object
     * @param string $table , array|int $id condition
     * @return object
     */
    public function getRowObject($table = '', $id = [])
    {
        if(is_integer($id))
            $where = 'id = '.$id;
        else if(is_array($id) && count($id)==1){
            $listKey = array_keys($id);
            $where = $listKey[0].'='.$id[$listKey[0]];
        }
        else
            die('Không thể có nhiều hơn 1 khóa chính và id truyền vào phải là số');
        $sql = 'SELECT * FROM '. $table . ' WHERE '. $where;
        
        if($result = mysqli_query($this->conn,$sql)){
            $data = mysqli_fetch_object($result);
            mysqli_free_result($result);
            return $data;
        }
        else
            return false;
    }

    /**
     * getRowArray get row return data array
     * @param string $table , array|int $id condition
     * @return array
     */
    public function getRowArray($table = '', $id = [])
    {
        if(is_integer($id))
            $where = 'id = '.$id;
        else if(is_array($id) && count($id)==1){
            $listKey = array_keys($id);
            $where = $listKey[0].'='.$id[$listKey[0]];
        }
        else
            die('Không thể có nhiều hơn 1 khóa chính và id truyền vào phải là số');
        $sql = 'SELECT * FROM '. $table . ' WHERE '. $where;
        
        if($result = mysqli_query($this->conn,$sql)){
            $data = mysqli_fetch_array($result);
            mysqli_free_result($result);
            return $data;
        }
        else
            return false;
    }
    /**
     * query
     * @param string $sql
     * @return boolean|array
     */
    public function query($sql ='', $return = true)
    {
        if($result = mysqli_query($this->conn,$sql))
        {
            if($return === true){
                while ($row = mysqli_fetch_array($result)) {
                    $data[] = $row;
                }
                mysqli_free_result($result);
                return $data;
            }
            else
                return true;
        }
        else
            return false;
    }

    /**
     * __destruct
     * @param none
     * @return void
     */
    public function __destruct()
    {
        $this->disConnect();
    }
}