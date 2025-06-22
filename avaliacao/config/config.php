<?php

define("BASE_APPLICATION",__DIR__);
define("ROOT",$_SERVER['DOCUMENT_ROOT']);

class db{

	public $host = "HOST";
	// public $host = "localhost";

	public $user = "USER";
	// public $user = "root";
	
	public $pwd = "PWD";
	// public $pwd = "";

	public $db = "adac";
	// public $db = "adac";
	
	public $stmt =  "";
	
	public $query;
	public $mysqli;
	public $result_array = array();
	
	function __construct(){	
		$this->mysqli = new mysqli($this->host, $this->user, $this->pwd, $this->db);
		if (mysqli_connect_error()) {
			exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
		}

		$this->mysqli->set_charset('utf8');
		
		return $this->mysqli;
	}
	function _error(){
		return $this->mysqli->error;
	}
	function query($query){	
		$this->query = $this->mysqli->query($query);	
	}
	
	function prepare($sql){
		$this->stmt = $this->mysqli->prepare($sql);
		return $this->stmt;
	}

	function resultado(){
		if($this->query){
			while ($dados = $this -> query-> fetch_array()){	
				$this->result_array[] = $dados;	
			}
			return $this->result_array;
		}else{
			return false;
		}		
	}
	
	function linha(){		
		return $this->query->num_rows;		
	}
	
	function resultado_line(){
		return $this->query->fetch_row();
	}
	
	function check_query(){
		 return $this->query = $this->mysqli->affected_rows;
	}
	
	function resultado_insert_id(){
		 return $this->query = $this->mysqli->insert_id;
	}
	
	function fechar_conexao(){
		return $this->mysqli->close();		
	}	
}


?>
