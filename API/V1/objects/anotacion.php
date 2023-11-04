<?php
class Anotacion{
 
    // database connection and table name
    private $conn;
    private $table_name = "anotacion";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_anotacion;
public $id_persona;
public $descripcion;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona g on t.id_persona = g.id_persona  WHERE ".$where."";
		
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
	// read anotacion
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  g.foto, t.* FROM ". $this->table_name ." t  join persona g on t.id_persona = g.id_persona  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  g.foto, t.* FROM ". $this->table_name ." t  join persona g on t.id_persona = g.id_persona  WHERE t.id_anotacion LIKE ? OR t.id_persona LIKE ?  OR g.foto LIKE ?  OR t.descripcion LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind searchKey
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
	 
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
		$query = "SELECT  g.foto, t.* FROM ". $this->table_name ." t  join persona g on t.id_persona = g.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
	
	function login_validation(){ 
$query = "SELECT  g.foto, t.* FROM ". $this->table_name ." t  join persona g on t.id_persona = g.id_persona  WHERE t.id_anotacion = ? AND t.id_anotacion=? LIMIT 0,1";
$stmt = $this->conn->prepare($query);
$stmt->bindParam(1, $this->id_anotacion);
$stmt->bindParam(2, $this->id_anotacion);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$num = $stmt->rowCount();
if($num>0){

$this->id_anotacion = $row['id_anotacion'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->descripcion = $row['descripcion'];
}
else{
$this->id_anotacion=null;
}
}


	function readOne(){
	 
		// query to read single record
		$query = "SELECT  g.foto, t.* FROM ". $this->table_name ." t  join persona g on t.id_persona = g.id_persona  WHERE t.id_anotacion = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_anotacion);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_anotacion = $row['id_anotacion'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->descripcion = $row['descripcion'];
		}
		else{
		$this->id_anotacion=null;
		}
	}

	
	
	// create anotacion
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_persona=:id_persona,descripcion=:descripcion";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
	 
		// bind values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":descripcion", $this->descripcion);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the anotacion
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_persona=:id_persona,descripcion=:descripcion WHERE id_anotacion = :id_anotacion";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
$this->id_anotacion=htmlspecialchars(strip_tags($this->id_anotacion));
	 
		// bind new values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":descripcion", $this->descripcion);
$stmt->bindParam(":id_anotacion", $this->id_anotacion);
	 
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
				if($columnName!='id_anotacion'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_anotacion = :id_anotacion"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_anotacion'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_anotacion", $this->id_anotacion);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the anotacion
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_anotacion = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_anotacion=htmlspecialchars(strip_tags($this->id_anotacion));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_anotacion);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_persona(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  g.foto, t.* FROM ". $this->table_name ." t  join persona g on t.id_persona = g.id_persona  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
