<?php
class Asistencia_Evento{
 
    // database connection and table name
    private $conn;
    private $table_name = "asistencia_evento";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_asistencia_evento;
public $id_evento;
public $id_persona;
public $modalidad;
public $asistencia;
public $fecha;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join evento z on t.id_evento = z.id_evento  join persona b on t.id_persona = b.id_persona  WHERE ".$where."";
		
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
	// read asistencia_evento
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  z.nombre, b.foto, t.* FROM ". $this->table_name ." t  join evento z on t.id_evento = z.id_evento  join persona b on t.id_persona = b.id_persona  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  z.nombre, b.foto, t.* FROM ". $this->table_name ." t  join evento z on t.id_evento = z.id_evento  join persona b on t.id_persona = b.id_persona  WHERE t.id_asistencia_evento LIKE ? OR t.id_evento LIKE ?  OR z.nombre LIKE ?  OR t.id_persona LIKE ?  OR b.foto LIKE ?  OR t.modalidad LIKE ?  OR t.asistencia LIKE ?  OR t.fecha LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind searchKey
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
$stmt->bindParam(5, $searchKey);
$stmt->bindParam(6, $searchKey);
$stmt->bindParam(7, $searchKey);
$stmt->bindParam(8, $searchKey);
	 
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
		$query = "SELECT  z.nombre, b.foto, t.* FROM ". $this->table_name ." t  join evento z on t.id_evento = z.id_evento  join persona b on t.id_persona = b.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  z.nombre, b.foto, t.* FROM ". $this->table_name ." t  join evento z on t.id_evento = z.id_evento  join persona b on t.id_persona = b.id_persona  WHERE t.id_asistencia_evento = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_asistencia_evento);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_asistencia_evento = $row['id_asistencia_evento'];
$this->id_evento = $row['id_evento'];
$this->nombre = $row['nombre'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->modalidad = $row['modalidad'];
$this->asistencia = $row['asistencia'];
$this->fecha = $row['fecha'];
		}
		else{
		$this->id_asistencia_evento=null;
		}
	}

	
	
	// create asistencia_evento
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_evento=:id_evento,id_persona=:id_persona,modalidad=:modalidad,asistencia=:asistencia,fecha=:fecha";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_evento=htmlspecialchars(strip_tags($this->id_evento));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->modalidad=htmlspecialchars(strip_tags($this->modalidad));
$this->asistencia=htmlspecialchars(strip_tags($this->asistencia));
$this->fecha=htmlspecialchars(strip_tags($this->fecha));
	 
		// bind values
		
$stmt->bindParam(":id_evento", $this->id_evento);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":modalidad", $this->modalidad);
$stmt->bindParam(":asistencia", $this->asistencia);
$stmt->bindParam(":fecha", $this->fecha);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the asistencia_evento
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_evento=:id_evento,id_persona=:id_persona,modalidad=:modalidad,asistencia=:asistencia,fecha=:fecha WHERE id_asistencia_evento = :id_asistencia_evento";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_evento=htmlspecialchars(strip_tags($this->id_evento));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->modalidad=htmlspecialchars(strip_tags($this->modalidad));
$this->asistencia=htmlspecialchars(strip_tags($this->asistencia));
$this->fecha=htmlspecialchars(strip_tags($this->fecha));
$this->id_asistencia_evento=htmlspecialchars(strip_tags($this->id_asistencia_evento));
	 
		// bind new values
		
$stmt->bindParam(":id_evento", $this->id_evento);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":modalidad", $this->modalidad);
$stmt->bindParam(":asistencia", $this->asistencia);
$stmt->bindParam(":fecha", $this->fecha);
$stmt->bindParam(":id_asistencia_evento", $this->id_asistencia_evento);
	 
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
				if($columnName!='id_asistencia_evento'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_asistencia_evento = :id_asistencia_evento"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_asistencia_evento'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_asistencia_evento", $this->id_asistencia_evento);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the asistencia_evento
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_asistencia_evento = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_asistencia_evento=htmlspecialchars(strip_tags($this->id_asistencia_evento));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_asistencia_evento);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_evento(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  z.nombre, b.foto, t.* FROM ". $this->table_name ." t  join evento z on t.id_evento = z.id_evento  join persona b on t.id_persona = b.id_persona  WHERE t.id_evento = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_evento);

$stmt->execute();
return $stmt;
}

function readByid_persona(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  z.nombre, b.foto, t.* FROM ". $this->table_name ." t  join evento z on t.id_evento = z.id_evento  join persona b on t.id_persona = b.id_persona  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
