<?php
class Contacto_Emergencia{
 
    // database connection and table name
    private $conn;
    private $table_name = "contacto_emergencia";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_contacto_emergencia;
public $id_parentesco;
public $id_persona;
public $id_contacto;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

	function total_record_count() {
	$query = "select count(1) as total from ". $this->table_name ."";
	$stmt = $this->conn->prepare($query);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			return $row['total'];
		}else{
			return 0;
		}
	}
	
	function search_record_count($columnArray,$orAnd){
		
		$where="";
		
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
			$columnLogic=$col->columnLogic;
			if($where==""){
				$where="LOWER(t.".$columnName . ") ".$columnLogic." :".$columnName;
			}else{
				$where=$where." ". $orAnd ." LOWER(t." . $columnName . ") ".$columnLogic." :".$columnName;
			}
		}
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  WHERE ".$where."";
		
		$stmt = $this->conn->prepare($query);
		$paramCount=1;
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
		if(strtoupper($col->columnLogic)=="LIKE"){
		$columnValue="%".strtolower($col->columnValue)."%";
		}else{
		$columnValue=strtolower($col->columnValue);
		}
			
			$stmt->bindValue(":".$columnName, $columnValue);
			$paramCount++;
			
		}
		
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			return $row['total'];
		}else{
			return 0;
		}
	}
	// read contacto_emergencia
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  g.nombre, s.foto, t.* FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	//Search table
	function search($searchKey){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 

		// select all query
		$query = "SELECT  g.nombre, s.foto, t.* FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  WHERE t.id_contacto_emergencia LIKE ? OR t.id_parentesco LIKE ?  OR g.nombre LIKE ?  OR t.id_persona LIKE ?  OR s.foto LIKE ?  OR t.id_contacto LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind searchKey
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
$stmt->bindParam(5, $searchKey);
$stmt->bindParam(6, $searchKey);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	function searchByColumn($columnArray,$orAnd){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$where="";
		
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
			$columnLogic=$col->columnLogic;
			if($where==""){
				$where="LOWER(t.".$columnName . ") ".$columnLogic." :".$columnName;
			}else{
				$where=$where." ". $orAnd ." LOWER(t." . $columnName . ") ".$columnLogic." :".$columnName;
			}
		}
		$query = "SELECT  g.nombre, s.foto, t.* FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
		$stmt = $this->conn->prepare($query);
		$paramCount=1;
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
		if(strtoupper($col->columnLogic)=="LIKE"){
		$columnValue="%".strtolower($col->columnValue)."%";
		}else{
		$columnValue=strtolower($col->columnValue);
		}
			
			$stmt->bindValue(":".$columnName, $columnValue);
			$paramCount++;
			
		}
		
		$stmt->execute();
		return $stmt;
	}
	
	

	function readOne(){
	 
		// query to read single record
		$query = "SELECT  g.nombre, s.foto, t.* FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  WHERE t.id_contacto_emergencia = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_contacto_emergencia);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_contacto_emergencia = $row['id_contacto_emergencia'];
$this->id_parentesco = $row['id_parentesco'];
$this->nombre = $row['nombre'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->id_contacto = $row['id_contacto'];
		}
		else{
		$this->id_contacto_emergencia=null;
		}
	}

	
	
	// create contacto_emergencia
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_parentesco=:id_parentesco,id_persona=:id_persona,id_contacto=:id_contacto";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_parentesco=htmlspecialchars(strip_tags($this->id_parentesco));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_contacto=htmlspecialchars(strip_tags($this->id_contacto));
	 
		// bind values
		
$stmt->bindParam(":id_parentesco", $this->id_parentesco);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_contacto", $this->id_contacto);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the contacto_emergencia
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_parentesco=:id_parentesco,id_persona=:id_persona,id_contacto=:id_contacto WHERE id_contacto_emergencia = :id_contacto_emergencia";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_parentesco=htmlspecialchars(strip_tags($this->id_parentesco));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_contacto=htmlspecialchars(strip_tags($this->id_contacto));
$this->id_contacto_emergencia=htmlspecialchars(strip_tags($this->id_contacto_emergencia));
	 
		// bind new values
		
$stmt->bindParam(":id_parentesco", $this->id_parentesco);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_contacto", $this->id_contacto);
$stmt->bindParam(":id_contacto_emergencia", $this->id_contacto_emergencia);
	 
		$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
	}
	function update_patch($jsonObj) {
			$query ="UPDATE ".$this->table_name;
			$setValue="";
			$colCount=1;
			foreach($jsonObj as $key => $value) 
			{
				$columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_contacto_emergencia'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_contacto_emergencia = :id_contacto_emergencia"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_contacto_emergencia'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_contacto_emergencia", $this->id_contacto_emergencia);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the contacto_emergencia
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_contacto_emergencia = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_contacto_emergencia=htmlspecialchars(strip_tags($this->id_contacto_emergencia));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_contacto_emergencia);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_parentesco(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  g.nombre, s.foto, t.* FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  WHERE t.id_parentesco = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_parentesco);

$stmt->execute();
return $stmt;
}

function readByid_persona(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  g.nombre, s.foto, t.* FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

function readByid_contacto(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  g.nombre, s.foto, t.* FROM ". $this->table_name ." t  join parentesco g on t.id_parentesco = g.id_parentesco  join persona s on t.id_persona = s.id_persona  WHERE t.id_contacto = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_contacto);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
