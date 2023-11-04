<?php
class Donacion{
 
    // database connection and table name
    private $conn;
    private $table_name = "donacion";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_donacion;
public $tipo_moneda;
public $id_persona;
public $monto;
public $metodo_pago;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join tipo_moneda f on t.tipo_moneda = f.id_tipo_moneda  join persona r on t.id_persona = r.id_persona  WHERE ".$where."";
		
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
	// read donacion
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  f.tipo_moneda, r.foto, t.* FROM ". $this->table_name ." t  join tipo_moneda f on t.tipo_moneda = f.id_tipo_moneda  join persona r on t.id_persona = r.id_persona  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  f.tipo_moneda, r.foto, t.* FROM ". $this->table_name ." t  join tipo_moneda f on t.tipo_moneda = f.id_tipo_moneda  join persona r on t.id_persona = r.id_persona  WHERE t.id_donacion LIKE ? OR t.tipo_moneda LIKE ?  OR f.tipo_moneda LIKE ?  OR t.id_persona LIKE ?  OR r.foto LIKE ?  OR t.monto LIKE ?  OR t.metodo_pago LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  f.tipo_moneda, r.foto, t.* FROM ". $this->table_name ." t  join tipo_moneda f on t.tipo_moneda = f.id_tipo_moneda  join persona r on t.id_persona = r.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  f.tipo_moneda, r.foto, t.* FROM ". $this->table_name ." t  join tipo_moneda f on t.tipo_moneda = f.id_tipo_moneda  join persona r on t.id_persona = r.id_persona  WHERE t.id_donacion = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_donacion);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_donacion = $row['id_donacion'];
$this->tipo_moneda = $row['tipo_moneda'];
$this->tipo_moneda = $row['tipo_moneda'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->monto = $row['monto'];
$this->metodo_pago = $row['metodo_pago'];
		}
		else{
		$this->id_donacion=null;
		}
	}

	
	
	// create donacion
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET tipo_moneda=:tipo_moneda,id_persona=:id_persona,monto=:monto,metodo_pago=:metodo_pago";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->tipo_moneda=htmlspecialchars(strip_tags($this->tipo_moneda));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->monto=htmlspecialchars(strip_tags($this->monto));
$this->metodo_pago=htmlspecialchars(strip_tags($this->metodo_pago));
	 
		// bind values
		
$stmt->bindParam(":tipo_moneda", $this->tipo_moneda);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":monto", $this->monto);
$stmt->bindParam(":metodo_pago", $this->metodo_pago);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the donacion
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET tipo_moneda=:tipo_moneda,id_persona=:id_persona,monto=:monto,metodo_pago=:metodo_pago WHERE id_donacion = :id_donacion";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->tipo_moneda=htmlspecialchars(strip_tags($this->tipo_moneda));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->monto=htmlspecialchars(strip_tags($this->monto));
$this->metodo_pago=htmlspecialchars(strip_tags($this->metodo_pago));
$this->id_donacion=htmlspecialchars(strip_tags($this->id_donacion));
	 
		// bind new values
		
$stmt->bindParam(":tipo_moneda", $this->tipo_moneda);
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":monto", $this->monto);
$stmt->bindParam(":metodo_pago", $this->metodo_pago);
$stmt->bindParam(":id_donacion", $this->id_donacion);
	 
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
				if($columnName!='id_donacion'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_donacion = :id_donacion"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_donacion'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_donacion", $this->id_donacion);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the donacion
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_donacion = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_donacion=htmlspecialchars(strip_tags($this->id_donacion));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_donacion);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readBytipo_moneda(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.tipo_moneda, r.foto, t.* FROM ". $this->table_name ." t  join tipo_moneda f on t.tipo_moneda = f.id_tipo_moneda  join persona r on t.id_persona = r.id_persona  WHERE t.tipo_moneda = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->tipo_moneda);

$stmt->execute();
return $stmt;
}

function readByid_persona(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.tipo_moneda, r.foto, t.* FROM ". $this->table_name ." t  join tipo_moneda f on t.tipo_moneda = f.id_tipo_moneda  join persona r on t.id_persona = r.id_persona  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
