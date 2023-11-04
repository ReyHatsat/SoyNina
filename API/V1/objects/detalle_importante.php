<?php
class Detalle_Importante{
 
    // database connection and table name
    private $conn;
    private $table_name = "detalle_importante";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_detalle_importante;
public $id_persona;
public $id_tipo_detalle;
public $detalle;
public $tratamiento;
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  join tipo_detalle m on t.id_tipo_detalle = m.id_tipo_detalle  WHERE ".$where."";
		
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
	// read detalle_importante
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  v.foto, m.tipo_detalle, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  join tipo_detalle m on t.id_tipo_detalle = m.id_tipo_detalle  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  v.foto, m.tipo_detalle, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  join tipo_detalle m on t.id_tipo_detalle = m.id_tipo_detalle  WHERE t.id_detalle_importante LIKE ? OR t.id_persona LIKE ?  OR v.foto LIKE ?  OR t.id_tipo_detalle LIKE ?  OR m.tipo_detalle LIKE ?  OR t.detalle LIKE ?  OR t.tratamiento LIKE ?  OR t.activo LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  v.foto, m.tipo_detalle, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  join tipo_detalle m on t.id_tipo_detalle = m.id_tipo_detalle  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  v.foto, m.tipo_detalle, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  join tipo_detalle m on t.id_tipo_detalle = m.id_tipo_detalle  WHERE t.id_detalle_importante = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_detalle_importante);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_detalle_importante = $row['id_detalle_importante'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->id_tipo_detalle = $row['id_tipo_detalle'];
$this->tipo_detalle = $row['tipo_detalle'];
$this->detalle = $row['detalle'];
$this->tratamiento = $row['tratamiento'];
$this->activo = $row['activo'];
		}
		else{
		$this->id_detalle_importante=null;
		}
	}

	
	
	// create detalle_importante
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_persona=:id_persona,id_tipo_detalle=:id_tipo_detalle,detalle=:detalle,tratamiento=:tratamiento,activo=:activo";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_tipo_detalle=htmlspecialchars(strip_tags($this->id_tipo_detalle));
$this->detalle=htmlspecialchars(strip_tags($this->detalle));
$this->tratamiento=htmlspecialchars(strip_tags($this->tratamiento));
$this->activo=htmlspecialchars(strip_tags($this->activo));
	 
		// bind values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_tipo_detalle", $this->id_tipo_detalle);
$stmt->bindParam(":detalle", $this->detalle);
$stmt->bindParam(":tratamiento", $this->tratamiento);
$stmt->bindParam(":activo", $this->activo);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the detalle_importante
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_persona=:id_persona,id_tipo_detalle=:id_tipo_detalle,detalle=:detalle,tratamiento=:tratamiento,activo=:activo WHERE id_detalle_importante = :id_detalle_importante";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_tipo_detalle=htmlspecialchars(strip_tags($this->id_tipo_detalle));
$this->detalle=htmlspecialchars(strip_tags($this->detalle));
$this->tratamiento=htmlspecialchars(strip_tags($this->tratamiento));
$this->activo=htmlspecialchars(strip_tags($this->activo));
$this->id_detalle_importante=htmlspecialchars(strip_tags($this->id_detalle_importante));
	 
		// bind new values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_tipo_detalle", $this->id_tipo_detalle);
$stmt->bindParam(":detalle", $this->detalle);
$stmt->bindParam(":tratamiento", $this->tratamiento);
$stmt->bindParam(":activo", $this->activo);
$stmt->bindParam(":id_detalle_importante", $this->id_detalle_importante);
	 
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
				if($columnName!='id_detalle_importante'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_detalle_importante = :id_detalle_importante"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_detalle_importante'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_detalle_importante", $this->id_detalle_importante);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the detalle_importante
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_detalle_importante = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_detalle_importante=htmlspecialchars(strip_tags($this->id_detalle_importante));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_detalle_importante);
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
$query = "SELECT  v.foto, m.tipo_detalle, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  join tipo_detalle m on t.id_tipo_detalle = m.id_tipo_detalle  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

function readByid_tipo_detalle(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  v.foto, m.tipo_detalle, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  join tipo_detalle m on t.id_tipo_detalle = m.id_tipo_detalle  WHERE t.id_tipo_detalle = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_tipo_detalle);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
