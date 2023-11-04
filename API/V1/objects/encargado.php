<?php
class Encargado{
 
    // database connection and table name
    private $conn;
    private $table_name = "encargado";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_encargado;
public $id_nina;
public $id_persona;
public $id_parentesco;
public $relacion_nina;
public $autorizado_recoger;
public $restriccion_acercamiento;
public $drogadiccion;
public $descripcion_drogadiccion;
public $privado_libertad;
public $descripcion_privado_libertad;
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  WHERE ".$where."";
		
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
	// read encargado
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  y.foto, c.nombre, t.* FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  y.foto, c.nombre, t.* FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  WHERE t.id_encargado LIKE ? OR t.id_nina LIKE ?  OR y.foto LIKE ?  OR t.id_persona LIKE ?  OR t.id_parentesco LIKE ?  OR c.nombre LIKE ?  OR t.relacion_nina LIKE ?  OR t.autorizado_recoger LIKE ?  OR t.restriccion_acercamiento LIKE ?  OR t.drogadiccion LIKE ?  OR t.descripcion_drogadiccion LIKE ?  OR t.privado_libertad LIKE ?  OR t.descripcion_privado_libertad LIKE ?  OR t.activo LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
$stmt->bindParam(11, $searchKey);
$stmt->bindParam(12, $searchKey);
$stmt->bindParam(13, $searchKey);
$stmt->bindParam(14, $searchKey);
	 
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
		$query = "SELECT  y.foto, c.nombre, t.* FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  y.foto, c.nombre, t.* FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  WHERE t.id_encargado = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_encargado);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_encargado = $row['id_encargado'];
$this->id_nina = $row['id_nina'];
$this->foto = $row['foto'];
$this->id_persona = $row['id_persona'];
$this->id_parentesco = $row['id_parentesco'];
$this->nombre = $row['nombre'];
$this->relacion_nina = $row['relacion_nina'];
$this->autorizado_recoger = $row['autorizado_recoger'];
$this->restriccion_acercamiento = $row['restriccion_acercamiento'];
$this->drogadiccion = $row['drogadiccion'];
$this->descripcion_drogadiccion = $row['descripcion_drogadiccion'];
$this->privado_libertad = $row['privado_libertad'];
$this->descripcion_privado_libertad = $row['descripcion_privado_libertad'];
$this->activo = $row['activo'];
		}
		else{
		$this->id_encargado=null;
		}
	}

	
	
	// create encargado
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_nina=:id_nina,id_persona=:id_persona,id_parentesco=:id_parentesco,relacion_nina=:relacion_nina,autorizado_recoger=:autorizado_recoger,restriccion_acercamiento=:restriccion_acercamiento,drogadiccion=:drogadiccion,descripcion_drogadiccion=:descripcion_drogadiccion,privado_libertad=:privado_libertad,descripcion_privado_libertad=:descripcion_privado_libertad,activo=:activo";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_nina=htmlspecialchars(strip_tags($this->id_nina));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_parentesco=htmlspecialchars(strip_tags($this->id_parentesco));
$this->relacion_nina=htmlspecialchars(strip_tags($this->relacion_nina));
$this->autorizado_recoger=htmlspecialchars(strip_tags($this->autorizado_recoger));
$this->restriccion_acercamiento=htmlspecialchars(strip_tags($this->restriccion_acercamiento));
$this->drogadiccion=htmlspecialchars(strip_tags($this->drogadiccion));
$this->descripcion_drogadiccion=htmlspecialchars(strip_tags($this->descripcion_drogadiccion));
$this->privado_libertad=htmlspecialchars(strip_tags($this->privado_libertad));
$this->descripcion_privado_libertad=htmlspecialchars(strip_tags($this->descripcion_privado_libertad));
$this->activo=htmlspecialchars(strip_tags($this->activo));
	 
		// bind values
		
$stmt->bindParam(":id_nina", $this->id_nina);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_parentesco", $this->id_parentesco);
$stmt->bindParam(":relacion_nina", $this->relacion_nina);
$stmt->bindParam(":autorizado_recoger", $this->autorizado_recoger);
$stmt->bindParam(":restriccion_acercamiento", $this->restriccion_acercamiento);
$stmt->bindParam(":drogadiccion", $this->drogadiccion);
$stmt->bindParam(":descripcion_drogadiccion", $this->descripcion_drogadiccion);
$stmt->bindParam(":privado_libertad", $this->privado_libertad);
$stmt->bindParam(":descripcion_privado_libertad", $this->descripcion_privado_libertad);
$stmt->bindParam(":activo", $this->activo);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the encargado
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_nina=:id_nina,id_persona=:id_persona,id_parentesco=:id_parentesco,relacion_nina=:relacion_nina,autorizado_recoger=:autorizado_recoger,restriccion_acercamiento=:restriccion_acercamiento,drogadiccion=:drogadiccion,descripcion_drogadiccion=:descripcion_drogadiccion,privado_libertad=:privado_libertad,descripcion_privado_libertad=:descripcion_privado_libertad,activo=:activo WHERE id_encargado = :id_encargado";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_nina=htmlspecialchars(strip_tags($this->id_nina));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_parentesco=htmlspecialchars(strip_tags($this->id_parentesco));
$this->relacion_nina=htmlspecialchars(strip_tags($this->relacion_nina));
$this->autorizado_recoger=htmlspecialchars(strip_tags($this->autorizado_recoger));
$this->restriccion_acercamiento=htmlspecialchars(strip_tags($this->restriccion_acercamiento));
$this->drogadiccion=htmlspecialchars(strip_tags($this->drogadiccion));
$this->descripcion_drogadiccion=htmlspecialchars(strip_tags($this->descripcion_drogadiccion));
$this->privado_libertad=htmlspecialchars(strip_tags($this->privado_libertad));
$this->descripcion_privado_libertad=htmlspecialchars(strip_tags($this->descripcion_privado_libertad));
$this->activo=htmlspecialchars(strip_tags($this->activo));
$this->id_encargado=htmlspecialchars(strip_tags($this->id_encargado));
	 
		// bind new values
		
$stmt->bindParam(":id_nina", $this->id_nina);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_parentesco", $this->id_parentesco);
$stmt->bindParam(":relacion_nina", $this->relacion_nina);
$stmt->bindParam(":autorizado_recoger", $this->autorizado_recoger);
$stmt->bindParam(":restriccion_acercamiento", $this->restriccion_acercamiento);
$stmt->bindParam(":drogadiccion", $this->drogadiccion);
$stmt->bindParam(":descripcion_drogadiccion", $this->descripcion_drogadiccion);
$stmt->bindParam(":privado_libertad", $this->privado_libertad);
$stmt->bindParam(":descripcion_privado_libertad", $this->descripcion_privado_libertad);
$stmt->bindParam(":activo", $this->activo);
$stmt->bindParam(":id_encargado", $this->id_encargado);
	 
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
				if($columnName!='id_encargado'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_encargado = :id_encargado"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_encargado'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_encargado", $this->id_encargado);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the encargado
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_encargado = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_encargado=htmlspecialchars(strip_tags($this->id_encargado));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_encargado);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_nina(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  y.foto, c.nombre, t.* FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  WHERE t.id_nina = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_nina);

$stmt->execute();
return $stmt;
}

function readByid_persona(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  y.foto, c.nombre, t.* FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

function readByid_parentesco(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  y.foto, c.nombre, t.* FROM ". $this->table_name ." t  join persona y on t.id_nina = y.id_persona  join parentesco c on t.id_parentesco = c.id_parentesco  WHERE t.id_parentesco = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_parentesco);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
