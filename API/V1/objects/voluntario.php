<?php
class Voluntario{
 
    // database connection and table name
    private $conn;
    private $table_name = "voluntario";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_voluntario;
public $area_voluntariado;
public $funcion;
public $fecha_ingreso;
public $estado;
public $id_persona;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join area_voluntariado l on t.area_voluntariado = l.id_area_voluntariado  join persona a on t.id_persona = a.id_persona  WHERE ".$where."";
		
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
	// read voluntario
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  l.nombre, a.foto, t.* FROM ". $this->table_name ." t  join area_voluntariado l on t.area_voluntariado = l.id_area_voluntariado  join persona a on t.id_persona = a.id_persona  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  l.nombre, a.foto, t.* FROM ". $this->table_name ." t  join area_voluntariado l on t.area_voluntariado = l.id_area_voluntariado  join persona a on t.id_persona = a.id_persona  WHERE t.id_voluntario LIKE ? OR t.area_voluntariado LIKE ?  OR l.nombre LIKE ?  OR t.funcion LIKE ?  OR t.fecha_ingreso LIKE ?  OR t.estado LIKE ?  OR t.id_persona LIKE ?  OR a.foto LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  l.nombre, a.foto, t.* FROM ". $this->table_name ." t  join area_voluntariado l on t.area_voluntariado = l.id_area_voluntariado  join persona a on t.id_persona = a.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  l.nombre, a.foto, t.* FROM ". $this->table_name ." t  join area_voluntariado l on t.area_voluntariado = l.id_area_voluntariado  join persona a on t.id_persona = a.id_persona  WHERE t.id_voluntario = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_voluntario);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_voluntario = $row['id_voluntario'];
$this->area_voluntariado = $row['area_voluntariado'];
$this->nombre = $row['nombre'];
$this->funcion = $row['funcion'];
$this->fecha_ingreso = $row['fecha_ingreso'];
$this->estado = $row['estado'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
		}
		else{
		$this->id_voluntario=null;
		}
	}

	
	
	// create voluntario
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET area_voluntariado=:area_voluntariado,funcion=:funcion,fecha_ingreso=:fecha_ingreso,estado=:estado,id_persona=:id_persona";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->area_voluntariado=htmlspecialchars(strip_tags($this->area_voluntariado));
$this->funcion=htmlspecialchars(strip_tags($this->funcion));
$this->fecha_ingreso=htmlspecialchars(strip_tags($this->fecha_ingreso));
$this->estado=htmlspecialchars(strip_tags($this->estado));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
	 
		// bind values
		
$stmt->bindParam(":area_voluntariado", $this->area_voluntariado);
$stmt->bindParam(":funcion", $this->funcion);
$stmt->bindParam(":fecha_ingreso", $this->fecha_ingreso);
$stmt->bindParam(":estado", $this->estado);
$stmt->bindParam(":id_persona", $this->id_persona);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the voluntario
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET area_voluntariado=:area_voluntariado,funcion=:funcion,fecha_ingreso=:fecha_ingreso,estado=:estado,id_persona=:id_persona WHERE id_voluntario = :id_voluntario";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->area_voluntariado=htmlspecialchars(strip_tags($this->area_voluntariado));
$this->funcion=htmlspecialchars(strip_tags($this->funcion));
$this->fecha_ingreso=htmlspecialchars(strip_tags($this->fecha_ingreso));
$this->estado=htmlspecialchars(strip_tags($this->estado));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_voluntario=htmlspecialchars(strip_tags($this->id_voluntario));
	 
		// bind new values
		
$stmt->bindParam(":area_voluntariado", $this->area_voluntariado);
$stmt->bindParam(":funcion", $this->funcion);
$stmt->bindParam(":fecha_ingreso", $this->fecha_ingreso);
$stmt->bindParam(":estado", $this->estado);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_voluntario", $this->id_voluntario);
	 
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
				if($columnName!='id_voluntario'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_voluntario = :id_voluntario"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_voluntario'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_voluntario", $this->id_voluntario);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the voluntario
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_voluntario = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_voluntario=htmlspecialchars(strip_tags($this->id_voluntario));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_voluntario);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByarea_voluntariado(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  l.nombre, a.foto, t.* FROM ". $this->table_name ." t  join area_voluntariado l on t.area_voluntariado = l.id_area_voluntariado  join persona a on t.id_persona = a.id_persona  WHERE t.area_voluntariado = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->area_voluntariado);

$stmt->execute();
return $stmt;
}

function readByid_persona(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  l.nombre, a.foto, t.* FROM ". $this->table_name ." t  join area_voluntariado l on t.area_voluntariado = l.id_area_voluntariado  join persona a on t.id_persona = a.id_persona  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
