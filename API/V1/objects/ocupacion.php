<?php
class Ocupacion{
 
    // database connection and table name
    private $conn;
    private $table_name = "ocupacion";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_ocupacion;
public $id_persona;
public $id_tipo_ocupacion;
public $lugar_ocupacion;
public $puesto;
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona c on t.id_persona = c.id_persona  join tipo_ocupacion g on t.id_tipo_ocupacion = g.id_tipo_ocupacion  WHERE ".$where."";
		
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
	// read ocupacion
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  c.foto, g.tipo_ocupacion, t.* FROM ". $this->table_name ." t  join persona c on t.id_persona = c.id_persona  join tipo_ocupacion g on t.id_tipo_ocupacion = g.id_tipo_ocupacion  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  c.foto, g.tipo_ocupacion, t.* FROM ". $this->table_name ." t  join persona c on t.id_persona = c.id_persona  join tipo_ocupacion g on t.id_tipo_ocupacion = g.id_tipo_ocupacion  WHERE t.id_ocupacion LIKE ? OR t.id_persona LIKE ?  OR c.foto LIKE ?  OR t.id_tipo_ocupacion LIKE ?  OR g.tipo_ocupacion LIKE ?  OR t.lugar_ocupacion LIKE ?  OR t.puesto LIKE ?  OR t.activo LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  c.foto, g.tipo_ocupacion, t.* FROM ". $this->table_name ." t  join persona c on t.id_persona = c.id_persona  join tipo_ocupacion g on t.id_tipo_ocupacion = g.id_tipo_ocupacion  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  c.foto, g.tipo_ocupacion, t.* FROM ". $this->table_name ." t  join persona c on t.id_persona = c.id_persona  join tipo_ocupacion g on t.id_tipo_ocupacion = g.id_tipo_ocupacion  WHERE t.id_ocupacion = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_ocupacion);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_ocupacion = $row['id_ocupacion'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->id_tipo_ocupacion = $row['id_tipo_ocupacion'];
$this->tipo_ocupacion = $row['tipo_ocupacion'];
$this->lugar_ocupacion = $row['lugar_ocupacion'];
$this->puesto = $row['puesto'];
$this->activo = $row['activo'];
		}
		else{
		$this->id_ocupacion=null;
		}
	}

	
	
	// create ocupacion
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_persona=:id_persona,id_tipo_ocupacion=:id_tipo_ocupacion,lugar_ocupacion=:lugar_ocupacion,puesto=:puesto,activo=:activo";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_tipo_ocupacion=htmlspecialchars(strip_tags($this->id_tipo_ocupacion));
$this->lugar_ocupacion=htmlspecialchars(strip_tags($this->lugar_ocupacion));
$this->puesto=htmlspecialchars(strip_tags($this->puesto));
$this->activo=htmlspecialchars(strip_tags($this->activo));
	 
		// bind values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_tipo_ocupacion", $this->id_tipo_ocupacion);
$stmt->bindParam(":lugar_ocupacion", $this->lugar_ocupacion);
$stmt->bindParam(":puesto", $this->puesto);
$stmt->bindParam(":activo", $this->activo);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the ocupacion
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_persona=:id_persona,id_tipo_ocupacion=:id_tipo_ocupacion,lugar_ocupacion=:lugar_ocupacion,puesto=:puesto,activo=:activo WHERE id_ocupacion = :id_ocupacion";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_tipo_ocupacion=htmlspecialchars(strip_tags($this->id_tipo_ocupacion));
$this->lugar_ocupacion=htmlspecialchars(strip_tags($this->lugar_ocupacion));
$this->puesto=htmlspecialchars(strip_tags($this->puesto));
$this->activo=htmlspecialchars(strip_tags($this->activo));
$this->id_ocupacion=htmlspecialchars(strip_tags($this->id_ocupacion));
	 
		// bind new values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_tipo_ocupacion", $this->id_tipo_ocupacion);
$stmt->bindParam(":lugar_ocupacion", $this->lugar_ocupacion);
$stmt->bindParam(":puesto", $this->puesto);
$stmt->bindParam(":activo", $this->activo);
$stmt->bindParam(":id_ocupacion", $this->id_ocupacion);
	 
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
				if($columnName!='id_ocupacion'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_ocupacion = :id_ocupacion"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_ocupacion'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_ocupacion", $this->id_ocupacion);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the ocupacion
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_ocupacion = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_ocupacion=htmlspecialchars(strip_tags($this->id_ocupacion));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_ocupacion);
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
$query = "SELECT  c.foto, g.tipo_ocupacion, t.* FROM ". $this->table_name ." t  join persona c on t.id_persona = c.id_persona  join tipo_ocupacion g on t.id_tipo_ocupacion = g.id_tipo_ocupacion  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

function readByid_tipo_ocupacion(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  c.foto, g.tipo_ocupacion, t.* FROM ". $this->table_name ." t  join persona c on t.id_persona = c.id_persona  join tipo_ocupacion g on t.id_tipo_ocupacion = g.id_tipo_ocupacion  WHERE t.id_tipo_ocupacion = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_tipo_ocupacion);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
