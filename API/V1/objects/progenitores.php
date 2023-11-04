<?php
class Progenitores{
 
    // database connection and table name
    private $conn;
    private $table_name = "progenitores";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_progenitores;
public $id_tipo_convivencia;
public $id_madre;
public $id_padre;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  WHERE ".$where."";
		
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
	// read progenitores
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  o.tipo_convivencia, a.foto, t.* FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  o.tipo_convivencia, a.foto, t.* FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  WHERE t.id_progenitores LIKE ? OR t.id_tipo_convivencia LIKE ?  OR o.tipo_convivencia LIKE ?  OR t.id_madre LIKE ?  OR a.foto LIKE ?  OR t.id_padre LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  o.tipo_convivencia, a.foto, t.* FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  o.tipo_convivencia, a.foto, t.* FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  WHERE t.id_progenitores = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_progenitores);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_progenitores = $row['id_progenitores'];
$this->id_tipo_convivencia = $row['id_tipo_convivencia'];
$this->tipo_convivencia = $row['tipo_convivencia'];
$this->id_madre = $row['id_madre'];
$this->foto = $row['foto'];
$this->id_padre = $row['id_padre'];
		}
		else{
		$this->id_progenitores=null;
		}
	}

	
	
	// create progenitores
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_tipo_convivencia=:id_tipo_convivencia,id_madre=:id_madre,id_padre=:id_padre";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_tipo_convivencia=htmlspecialchars(strip_tags($this->id_tipo_convivencia));
$this->id_madre=htmlspecialchars(strip_tags($this->id_madre));
$this->id_padre=htmlspecialchars(strip_tags($this->id_padre));
	 
		// bind values
		
$stmt->bindParam(":id_tipo_convivencia", $this->id_tipo_convivencia);
$stmt->bindParam(":id_madre", $this->id_madre);
$stmt->bindParam(":id_padre", $this->id_padre);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the progenitores
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_tipo_convivencia=:id_tipo_convivencia,id_madre=:id_madre,id_padre=:id_padre WHERE id_progenitores = :id_progenitores";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_tipo_convivencia=htmlspecialchars(strip_tags($this->id_tipo_convivencia));
$this->id_madre=htmlspecialchars(strip_tags($this->id_madre));
$this->id_padre=htmlspecialchars(strip_tags($this->id_padre));
$this->id_progenitores=htmlspecialchars(strip_tags($this->id_progenitores));
	 
		// bind new values
		
$stmt->bindParam(":id_tipo_convivencia", $this->id_tipo_convivencia);
$stmt->bindParam(":id_madre", $this->id_madre);
$stmt->bindParam(":id_padre", $this->id_padre);
$stmt->bindParam(":id_progenitores", $this->id_progenitores);
	 
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
				if($columnName!='id_progenitores'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_progenitores = :id_progenitores"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_progenitores'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_progenitores", $this->id_progenitores);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the progenitores
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_progenitores = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_progenitores=htmlspecialchars(strip_tags($this->id_progenitores));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_progenitores);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_tipo_convivencia(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  o.tipo_convivencia, a.foto, t.* FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  WHERE t.id_tipo_convivencia = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_tipo_convivencia);

$stmt->execute();
return $stmt;
}

function readByid_madre(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  o.tipo_convivencia, a.foto, t.* FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  WHERE t.id_madre = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_madre);

$stmt->execute();
return $stmt;
}

function readByid_padre(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  o.tipo_convivencia, a.foto, t.* FROM ". $this->table_name ." t  join tipo_convivencia o on t.id_tipo_convivencia = o.id_tipo_convivencia  join persona a on t.id_madre = a.id_persona  WHERE t.id_padre = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_padre);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
