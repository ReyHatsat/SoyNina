<?php
class Miembro_Equipo{
 
    // database connection and table name
    private $conn;
    private $table_name = "miembro_equipo";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_miembro_equipo;
public $id_persona;
public $id_equipo;
public $id_area_trabajo;
public $funcion;
public $fecha_ingreso;
public $estado;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  WHERE ".$where."";
		
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
	// read miembro_equipo
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  n.foto, k.nombre, f.area_trabajo, t.* FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  n.foto, k.nombre, f.area_trabajo, t.* FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  WHERE t.id_miembro_equipo LIKE ? OR t.id_persona LIKE ?  OR n.foto LIKE ?  OR t.id_equipo LIKE ?  OR k.nombre LIKE ?  OR t.id_area_trabajo LIKE ?  OR f.area_trabajo LIKE ?  OR t.funcion LIKE ?  OR t.fecha_ingreso LIKE ?  OR t.estado LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
$stmt->bindParam(9, $searchKey);
$stmt->bindParam(10, $searchKey);
	 
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
		$query = "SELECT  n.foto, k.nombre, f.area_trabajo, t.* FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  n.foto, k.nombre, f.area_trabajo, t.* FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  WHERE t.id_miembro_equipo = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_miembro_equipo);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_miembro_equipo = $row['id_miembro_equipo'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->id_equipo = $row['id_equipo'];
$this->nombre = $row['nombre'];
$this->id_area_trabajo = $row['id_area_trabajo'];
$this->area_trabajo = $row['area_trabajo'];
$this->funcion = $row['funcion'];
$this->fecha_ingreso = $row['fecha_ingreso'];
$this->estado = $row['estado'];
		}
		else{
		$this->id_miembro_equipo=null;
		}
	}

	
	
	// create miembro_equipo
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_persona=:id_persona,id_equipo=:id_equipo,id_area_trabajo=:id_area_trabajo,funcion=:funcion,fecha_ingreso=:fecha_ingreso,estado=:estado";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_equipo=htmlspecialchars(strip_tags($this->id_equipo));
$this->id_area_trabajo=htmlspecialchars(strip_tags($this->id_area_trabajo));
$this->funcion=htmlspecialchars(strip_tags($this->funcion));
$this->fecha_ingreso=htmlspecialchars(strip_tags($this->fecha_ingreso));
$this->estado=htmlspecialchars(strip_tags($this->estado));
	 
		// bind values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_equipo", $this->id_equipo);
$stmt->bindParam(":id_area_trabajo", $this->id_area_trabajo);
$stmt->bindParam(":funcion", $this->funcion);
$stmt->bindParam(":fecha_ingreso", $this->fecha_ingreso);
$stmt->bindParam(":estado", $this->estado);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the miembro_equipo
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_persona=:id_persona,id_equipo=:id_equipo,id_area_trabajo=:id_area_trabajo,funcion=:funcion,fecha_ingreso=:fecha_ingreso,estado=:estado WHERE id_miembro_equipo = :id_miembro_equipo";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_equipo=htmlspecialchars(strip_tags($this->id_equipo));
$this->id_area_trabajo=htmlspecialchars(strip_tags($this->id_area_trabajo));
$this->funcion=htmlspecialchars(strip_tags($this->funcion));
$this->fecha_ingreso=htmlspecialchars(strip_tags($this->fecha_ingreso));
$this->estado=htmlspecialchars(strip_tags($this->estado));
$this->id_miembro_equipo=htmlspecialchars(strip_tags($this->id_miembro_equipo));
	 
		// bind new values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_equipo", $this->id_equipo);
$stmt->bindParam(":id_area_trabajo", $this->id_area_trabajo);
$stmt->bindParam(":funcion", $this->funcion);
$stmt->bindParam(":fecha_ingreso", $this->fecha_ingreso);
$stmt->bindParam(":estado", $this->estado);
$stmt->bindParam(":id_miembro_equipo", $this->id_miembro_equipo);
	 
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
				if($columnName!='id_miembro_equipo'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_miembro_equipo = :id_miembro_equipo"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_miembro_equipo'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_miembro_equipo", $this->id_miembro_equipo);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the miembro_equipo
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_miembro_equipo = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_miembro_equipo=htmlspecialchars(strip_tags($this->id_miembro_equipo));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_miembro_equipo);
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
$query = "SELECT  n.foto, k.nombre, f.area_trabajo, t.* FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

function readByid_equipo(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  n.foto, k.nombre, f.area_trabajo, t.* FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  WHERE t.id_equipo = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_equipo);

$stmt->execute();
return $stmt;
}

function readByid_area_trabajo(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  n.foto, k.nombre, f.area_trabajo, t.* FROM ". $this->table_name ." t  join persona n on t.id_persona = n.id_persona  join equipo k on t.id_equipo = k.id_equipo  join area_trabajo f on t.id_area_trabajo = f.id_area_trabajo  WHERE t.id_area_trabajo = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_area_trabajo);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
