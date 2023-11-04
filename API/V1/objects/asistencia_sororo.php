<?php
class Asistencia_Sororo{
 
    // database connection and table name
    private $conn;
    private $table_name = "asistencia_sororo";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_asistencia_sororo;
public $id_voluntario;
public $fecha;
public $circulo_sororo;
public $capacitacion;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join voluntario e on t.id_voluntario = e.id_voluntario  WHERE ".$where."";
		
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
	// read asistencia_sororo
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  e.funcion, t.* FROM ". $this->table_name ." t  join voluntario e on t.id_voluntario = e.id_voluntario  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  e.funcion, t.* FROM ". $this->table_name ." t  join voluntario e on t.id_voluntario = e.id_voluntario  WHERE t.id_asistencia_sororo LIKE ? OR t.id_voluntario LIKE ?  OR e.funcion LIKE ?  OR t.fecha LIKE ?  OR t.circulo_sororo LIKE ?  OR t.capacitacion LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  e.funcion, t.* FROM ". $this->table_name ." t  join voluntario e on t.id_voluntario = e.id_voluntario  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  e.funcion, t.* FROM ". $this->table_name ." t  join voluntario e on t.id_voluntario = e.id_voluntario  WHERE t.id_asistencia_sororo = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_asistencia_sororo);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_asistencia_sororo = $row['id_asistencia_sororo'];
$this->id_voluntario = $row['id_voluntario'];
$this->funcion = $row['funcion'];
$this->fecha = $row['fecha'];
$this->circulo_sororo = $row['circulo_sororo'];
$this->capacitacion = $row['capacitacion'];
		}
		else{
		$this->id_asistencia_sororo=null;
		}
	}

	
	
	// create asistencia_sororo
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_voluntario=:id_voluntario,fecha=:fecha,circulo_sororo=:circulo_sororo,capacitacion=:capacitacion";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_voluntario=htmlspecialchars(strip_tags($this->id_voluntario));
$this->fecha=htmlspecialchars(strip_tags($this->fecha));
$this->circulo_sororo=htmlspecialchars(strip_tags($this->circulo_sororo));
$this->capacitacion=htmlspecialchars(strip_tags($this->capacitacion));
	 
		// bind values
		
$stmt->bindParam(":id_voluntario", $this->id_voluntario);
$stmt->bindParam(":fecha", $this->fecha);
$stmt->bindParam(":circulo_sororo", $this->circulo_sororo);
$stmt->bindParam(":capacitacion", $this->capacitacion);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the asistencia_sororo
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_voluntario=:id_voluntario,fecha=:fecha,circulo_sororo=:circulo_sororo,capacitacion=:capacitacion WHERE id_asistencia_sororo = :id_asistencia_sororo";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_voluntario=htmlspecialchars(strip_tags($this->id_voluntario));
$this->fecha=htmlspecialchars(strip_tags($this->fecha));
$this->circulo_sororo=htmlspecialchars(strip_tags($this->circulo_sororo));
$this->capacitacion=htmlspecialchars(strip_tags($this->capacitacion));
$this->id_asistencia_sororo=htmlspecialchars(strip_tags($this->id_asistencia_sororo));
	 
		// bind new values
		
$stmt->bindParam(":id_voluntario", $this->id_voluntario);
$stmt->bindParam(":fecha", $this->fecha);
$stmt->bindParam(":circulo_sororo", $this->circulo_sororo);
$stmt->bindParam(":capacitacion", $this->capacitacion);
$stmt->bindParam(":id_asistencia_sororo", $this->id_asistencia_sororo);
	 
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
				if($columnName!='id_asistencia_sororo'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_asistencia_sororo = :id_asistencia_sororo"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_asistencia_sororo'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_asistencia_sororo", $this->id_asistencia_sororo);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the asistencia_sororo
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_asistencia_sororo = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_asistencia_sororo=htmlspecialchars(strip_tags($this->id_asistencia_sororo));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_asistencia_sororo);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_voluntario(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  e.funcion, t.* FROM ". $this->table_name ." t  join voluntario e on t.id_voluntario = e.id_voluntario  WHERE t.id_voluntario = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_voluntario);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
