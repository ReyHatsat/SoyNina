<?php
class Club{
 
    // database connection and table name
    private $conn;
    private $table_name = "club";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_club;
public $id_ciclo;
public $nombre;
public $codigo;
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join ciclo b on t.id_ciclo = b.id_ciclo  WHERE ".$where."";
		
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
	// read club
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  b.nombre, t.* FROM ". $this->table_name ." t  join ciclo b on t.id_ciclo = b.id_ciclo  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  b.nombre, t.* FROM ". $this->table_name ." t  join ciclo b on t.id_ciclo = b.id_ciclo  WHERE t.id_club LIKE ? OR t.id_ciclo LIKE ?  OR b.nombre LIKE ?  OR t.nombre LIKE ?  OR t.codigo LIKE ?  OR t.activo LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  b.nombre, t.* FROM ". $this->table_name ." t  join ciclo b on t.id_ciclo = b.id_ciclo  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  b.nombre, t.* FROM ". $this->table_name ." t  join ciclo b on t.id_ciclo = b.id_ciclo  WHERE t.id_club = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_club);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_club = $row['id_club'];
$this->id_ciclo = $row['id_ciclo'];
$this->nombre = $row['nombre'];
$this->nombre = $row['nombre'];
$this->codigo = $row['codigo'];
$this->activo = $row['activo'];
		}
		else{
		$this->id_club=null;
		}
	}

	
	
	// create club
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_ciclo=:id_ciclo,nombre=:nombre,codigo=:codigo,activo=:activo";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_ciclo=htmlspecialchars(strip_tags($this->id_ciclo));
$this->nombre=htmlspecialchars(strip_tags($this->nombre));
$this->codigo=htmlspecialchars(strip_tags($this->codigo));
$this->activo=htmlspecialchars(strip_tags($this->activo));
	 
		// bind values
		
$stmt->bindParam(":id_ciclo", $this->id_ciclo);
$stmt->bindParam(":nombre", $this->nombre);
$stmt->bindParam(":codigo", $this->codigo);
$stmt->bindParam(":activo", $this->activo);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the club
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_ciclo=:id_ciclo,nombre=:nombre,codigo=:codigo,activo=:activo WHERE id_club = :id_club";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_ciclo=htmlspecialchars(strip_tags($this->id_ciclo));
$this->nombre=htmlspecialchars(strip_tags($this->nombre));
$this->codigo=htmlspecialchars(strip_tags($this->codigo));
$this->activo=htmlspecialchars(strip_tags($this->activo));
$this->id_club=htmlspecialchars(strip_tags($this->id_club));
	 
		// bind new values
		
$stmt->bindParam(":id_ciclo", $this->id_ciclo);
$stmt->bindParam(":nombre", $this->nombre);
$stmt->bindParam(":codigo", $this->codigo);
$stmt->bindParam(":activo", $this->activo);
$stmt->bindParam(":id_club", $this->id_club);
	 
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
				if($columnName!='id_club'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_club = :id_club"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_club'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_club", $this->id_club);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the club
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_club = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_club=htmlspecialchars(strip_tags($this->id_club));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_club);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_ciclo(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  b.nombre, t.* FROM ". $this->table_name ." t  join ciclo b on t.id_ciclo = b.id_ciclo  WHERE t.id_ciclo = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_ciclo);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
