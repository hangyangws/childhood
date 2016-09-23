<?php
require 'config/config.php';
date_default_timezone_set('PRC');
class DB
{
    //服务器
    public $host;
    //数据库用户名
    public $username;
    //数据密码
    public $password;
    //数据库名
    public $dbname;
    //数据库连接变量
    public $conn;
    /**
     * DB类构造函数
     */
    // 本地开发
    public function __construct($host = DB_HOST, $username = DB_USER, $password = DB_PASSWORD, $dbname = DB_NAME)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }
    /**
     * 打开数据库连接
     */
    public function open()
    {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        mysqli_query($this->conn, 'SET NAMES UTF8');
    }
    /**
     * 关闭数据连接
     */
    public function close()
    {
        mysqli_close($this->conn);
    }
    /**
     * 通过sql语句获取数据
     */
    public function getObjListBySql($sql)
    {
        $this->open();
        $rs = mysqli_query($this->conn, $sql);
        //$re为返回的结果
        $objList = array();
        while ($obj = mysqli_fetch_object($rs)) {
            //把返回结果转化为对象 并且把每行装入数组
            if ($obj) {
                $objList[] = $obj;
            }
        }
        $this->close();
        return $objList;
    }
    /**
     * 通过sql语句获取数据 数组 判断是否设置某个值
     */
    public function getOneBySql($sql, $witch)
    {
        $this->open();
        $rs = mysqli_query($this->conn, $sql);
        //$rs为返回的结果
        $num = mysqli_fetch_array($rs);
        $num = $num[$witch];
        if ($rs) {
            return $num;
        } else {
            return '0';
        }
        $this->close();
    }
    /**
     * 通过sql语句获取数据 数组 判断是否关注专用
     */
    public function getArrayBySql($sql)
    {
        $this->open();
        $rs = mysqli_query($this->conn, $sql);
        //$re为返回的结果
        $num = mysqli_fetch_array($rs);
        $num = $num['count(1)'];
        if ($num) {
            return $num;
        } else {
            return '0';
        }
        $this->close();
    }
    /**
     * 通过sql语句更新数据 或者操作数据
     */
    public function updataBySql($sql)
    {
        $this->open();
        $rs = mysqli_query($this->conn, $sql);
        //$re为返回的结果
        $this->close();
        if ($rs) {
            //1 表示成功
            return '1';
        } else {
            return '0';
        }
    }
    /**
     * 向数据库表中插入数据
     */
    public function insertData($table, $columns = array(), $values = array())
    {
        $sql = 'insert into ' . $table . ' (';
        for ($i = 0; $i < count($columns); $i++) {
            //把列之间添加逗号分隔
            $sql .= $columns[$i];
            if ($i < count($columns) - 1) {
                $sql .= ',';
            }
        }
        $sql .= ') values ( ';
        for ($i = 0; $i < count($values); $i++) {
            //把值之间添加逗号分隔
            $sql .= '\'' . $values[$i] . '\'';
            if ($i < count($values) - 1) {
                $sql .= ',';
            }
        }
        $sql .= ' )';
        $this->open();
        mysqli_query($this->conn, $sql);
        $id = mysqli_insert_id($this->conn);
        $this->close();
        return $id;
    }
    /**
     * 通过表中的某一属性获取整行数据 获取说说专用
     */
    public function getDataByAtr($tableName, $atrName, $atrValue)
    {
        // $data是数组 里面是对象 每个对象是一行数据
        $data = $this->getObjListBySql('SELECT * FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}' ORDER BY create_date DESC");
        if (count($data) !== 0) {
            return $data;
        } else {
            // 表示没有数据
            return NULL;
        }
    }
    /**
     * 通过表中的某一属性(id)获取整行数据
     */
    public function getDataByID($tableName, $atrName, $atrValue)
    {
        // $data是数组 里面是对象 每个对象是一行数据
        $data = $this->getObjListBySql('SELECT * FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}'");
        if (count($data) !== 0) {
            return $data;
        } else {
            // 表示没有数据
            return NULL;
        }
    }
    /**
     * 通过表中的某一属性获取整行数据 获取说说评论专用
     */
    public function getComByAtr($tableName, $atrName, $atrValue)
    {
        // $data是数组 里面是对象 每个对象是一行数据
        $data = $this->getObjListBySql('SELECT * FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}' ORDER BY add_date DESC");
        if (count($data) !== 0) {
            return $data;
        } else {
            // 表示没有数据
            return NULL;
        }
    }
    /**
     * 通过表中的某一属性获取某行某2个数据
     */
    public function getDataByAtr2($tableName, $atrName, $atrValue, $what1, $what2)
    {
        return $this->getObjListBySql('SELECT ' . $what1 . ',' . $what2 . ' FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}'");
    }
    /**
     * 通过表中的某一属性获取某行某个数据
     */
    public function getOneByID($tableName, $atrName, $atrValue, $what)
    {
        $data = $this->getObjListBySql('SELECT ' . $what . ' FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}' LIMIT 1");
        if (count($data) !== 0) {
            // 这个一维数组里面的每一字段都是一个对象
            return $data;
        } else {
            return NULL;
        }
    }
    /**
     * 通过某一字段获取占有行数
     */
    public function getRowByAtr($tableName, $atrName, $atrValue)
    {
        //$data是一个数组, 是sql查询返回的二维表,当查询为空是就为空数组
        $data = $this->getObjListBySql('SELECT id FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}'");
        return count($data);
    }
    /**
     * 通过2个字段验证是否有这一条数据的id 且唯一 不唯一返回false 唯一返回这条数据的id 登录用
     */
    public function getRowByTwo($tableName, $atrName, $atrValue, $atrName2, $atrValue2)
    {
        //$data是一个数组, 是sql查询返回的二维表, 当查询为空是就为空数组
        $data = $this->getObjListBySql('SELECT id FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}' AND {$atrName2} = '{$atrValue2}'");
        if (count($data) === 1) {
            return $data[0]->id;
        } else {
            return false;
        }
    }
    /**
     * 通过表中的"id", 删除记录
     */
    public function delete($tableName, $atrName, $atrValue)
    {
        $this->open();
        if (mysqli_query($this->conn, 'DELETE FROM ' . $tableName . " WHERE {$atrName} = '{$atrValue}'")) {
            $this->close();
            return true;
        } else {
            return false;
        }
    }
    /**
     * 更新表中的属性值
     */
    public function updateParamById($tableName, $atrName, $atrValue, $key, $value)
    {
        $this->open();
        if (mysqli_query($this->conn, 'UPDATE ' . $tableName . " SET {$key} = '{$value}' WHERE {$atrName} = '{$atrValue}' ")) {
            //$key不要单引号
            $this->close();
            return true;
        } else {
            $this->close();
            return false;
        }
    }
}