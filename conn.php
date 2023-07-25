<?php
class Conn{
    public $index="/CRM";
    private $hostname="localhost";
    private $username="root";
    private $db_password="";
    private $db_name="crm";
    private $conn="";
    public function __construct(){
        if($this->conn==""){
            $this->conn=new mysqli($this->hostname,$this->username,$this->db_password,$this->db_name);
        }
    }

// read method

    public function read($table,$column="*",$where=null,$join=null){
        $sql="select $column from $table";
        if($join!=null){
            $sql.=" join $join";
        }
        if($where!=null){
            $sql.=" where $where";
        }
        $result=$this->conn->query($sql);
        return $result;
    }

// insert method

    public function insert($table,$data=[]){
        $column=implode("`,`",array_keys($data));
        $rowData=implode("','",array_values($data));
        $result=$this->conn->query("insert into $table (`$column`) values ('$rowData')");
        return $result;
    }

// update method

    public function update($table,$data=[],$where){
        $updatedData=[];
        foreach($data as $key=>$value){
            $updatedData[]="`$key`='$value'";
        }
        $updatedData=implode(",",$updatedData);
        $result=$this->conn->query("update $table set $updatedData where $where");
        return $result;
    }

// delete method

    public function delete($table,$where){
        $result=$this->conn->query("delete from $table where $where");
        return $result;
    }
    public function __destruct(){
        if($this->conn!==""){
            $this->conn->close();
        }
    }
}
?>