<?php
class Valoracion{
 
    // database connection and table name
    private $conn;
    private $table_name = "valoracion";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_valoracion;
public $id_voluntario;
public $rubro;
public $activo;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  WHERE ".$where."";
		
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
	// read valoracion
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  x.funcion, f.nombre, t.* FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  x.funcion, f.nombre, t.* FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  WHERE t.id_valoracion LIKE ? OR t.id_voluntario LIKE ?  OR x.funcion LIKE ?  OR t.rubro LIKE ?  OR f.nombre LIKE ?  OR t.activo LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  x.funcion, f.nombre, t.* FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  x.funcion, f.nombre, t.* FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  WHERE t.id_valoracion = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_valoracion);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_valoracion = $row['id_valoracion'];
$this->id_voluntario = $row['id_voluntario'];
$this->funcion = $row['funcion'];
$this->rubro = $row['rubro'];
$this->nombre = $row['nombre'];
$this->activo = $row['activo'];
		}
		else{
		$this->id_valoracion=null;
		}
	}

	
	
	// create valoracion
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_voluntario=:id_voluntario,rubro=:rubro,activo=:activo";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_voluntario=htmlspecialchars(strip_tags($this->id_voluntario));
$this->rubro=htmlspecialchars(strip_tags($this->rubro));
$this->activo=htmlspecialchars(strip_tags($this->activo));
	 
		// bind values
		
$stmt->bindParam(":id_voluntario", $this->id_voluntario);
$stmt->bindParam(":rubro", $this->rubro);
$stmt->bindParam(":activo", $this->activo);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the valoracion
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_voluntario=:id_voluntario,rubro=:rubro,activo=:activo WHERE id_valoracion = :id_valoracion";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_voluntario=htmlspecialchars(strip_tags($this->id_voluntario));
$this->rubro=htmlspecialchars(strip_tags($this->rubro));
$this->activo=htmlspecialchars(strip_tags($this->activo));
$this->id_valoracion=htmlspecialchars(strip_tags($this->id_valoracion));
	 
		// bind new values
		
$stmt->bindParam(":id_voluntario", $this->id_voluntario);
$stmt->bindParam(":rubro", $this->rubro);
$stmt->bindParam(":activo", $this->activo);
$stmt->bindParam(":id_valoracion", $this->id_valoracion);
	 
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
				if($columnName!='id_valoracion'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_valoracion = :id_valoracion"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_valoracion'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_valoracion", $this->id_valoracion);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the valoracion
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_valoracion = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_valoracion=htmlspecialchars(strip_tags($this->id_valoracion));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_valoracion);
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
$query = "SELECT  x.funcion, f.nombre, t.* FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  WHERE t.id_voluntario = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_voluntario);

$stmt->execute();
return $stmt;
}

function readByrubro(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  x.funcion, f.nombre, t.* FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  WHERE t.rubro = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->rubro);

$stmt->execute();
return $stmt;
}

function readByactivo(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  x.funcion, f.nombre, t.* FROM ". $this->table_name ." t  join voluntario x on t.id_voluntario = x.id_voluntario  join rubro f on t.rubro = f.id_rubro  WHERE t.activo = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->activo);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
