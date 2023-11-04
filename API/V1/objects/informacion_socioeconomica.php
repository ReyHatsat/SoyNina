<?php
class Informacion_Socioeconomica{
 
    // database connection and table name
    private $conn;
    private $table_name = "informacion_socioeconomica";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_informacion_socioeconomica;
public $id_persona;
public $personas_laborales;
public $ingreso_mensual_aproximado;
public $descripcion_vivienda;
public $comparte_cuarto;
public $id_comparte_cuarto;
public $comparte_cama;
public $id_comparte_cama;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  WHERE ".$where."";
		
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
	// read informacion_socioeconomica
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  v.foto, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  v.foto, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  WHERE t.id_informacion_socioeconomica LIKE ? OR t.id_persona LIKE ?  OR v.foto LIKE ?  OR t.personas_laborales LIKE ?  OR t.ingreso_mensual_aproximado LIKE ?  OR t.descripcion_vivienda LIKE ?  OR t.comparte_cuarto LIKE ?  OR t.id_comparte_cuarto LIKE ?  OR t.comparte_cama LIKE ?  OR t.id_comparte_cama LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  v.foto, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  v.foto, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  WHERE t.id_informacion_socioeconomica = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_informacion_socioeconomica);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_informacion_socioeconomica = $row['id_informacion_socioeconomica'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->personas_laborales = $row['personas_laborales'];
$this->ingreso_mensual_aproximado = $row['ingreso_mensual_aproximado'];
$this->descripcion_vivienda = $row['descripcion_vivienda'];
$this->comparte_cuarto = $row['comparte_cuarto'];
$this->id_comparte_cuarto = $row['id_comparte_cuarto'];
$this->comparte_cama = $row['comparte_cama'];
$this->id_comparte_cama = $row['id_comparte_cama'];
		}
		else{
		$this->id_informacion_socioeconomica=null;
		}
	}

	
	
	// create informacion_socioeconomica
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_persona=:id_persona,personas_laborales=:personas_laborales,ingreso_mensual_aproximado=:ingreso_mensual_aproximado,descripcion_vivienda=:descripcion_vivienda,comparte_cuarto=:comparte_cuarto,id_comparte_cuarto=:id_comparte_cuarto,comparte_cama=:comparte_cama,id_comparte_cama=:id_comparte_cama";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->personas_laborales=htmlspecialchars(strip_tags($this->personas_laborales));
$this->ingreso_mensual_aproximado=htmlspecialchars(strip_tags($this->ingreso_mensual_aproximado));
$this->descripcion_vivienda=htmlspecialchars(strip_tags($this->descripcion_vivienda));
$this->comparte_cuarto=htmlspecialchars(strip_tags($this->comparte_cuarto));
$this->id_comparte_cuarto=htmlspecialchars(strip_tags($this->id_comparte_cuarto));
$this->comparte_cama=htmlspecialchars(strip_tags($this->comparte_cama));
$this->id_comparte_cama=htmlspecialchars(strip_tags($this->id_comparte_cama));
	 
		// bind values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":personas_laborales", $this->personas_laborales);
$stmt->bindParam(":ingreso_mensual_aproximado", $this->ingreso_mensual_aproximado);
$stmt->bindParam(":descripcion_vivienda", $this->descripcion_vivienda);
$stmt->bindParam(":comparte_cuarto", $this->comparte_cuarto);
$stmt->bindParam(":id_comparte_cuarto", $this->id_comparte_cuarto);
$stmt->bindParam(":comparte_cama", $this->comparte_cama);
$stmt->bindParam(":id_comparte_cama", $this->id_comparte_cama);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the informacion_socioeconomica
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_persona=:id_persona,personas_laborales=:personas_laborales,ingreso_mensual_aproximado=:ingreso_mensual_aproximado,descripcion_vivienda=:descripcion_vivienda,comparte_cuarto=:comparte_cuarto,id_comparte_cuarto=:id_comparte_cuarto,comparte_cama=:comparte_cama,id_comparte_cama=:id_comparte_cama WHERE id_informacion_socioeconomica = :id_informacion_socioeconomica";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->personas_laborales=htmlspecialchars(strip_tags($this->personas_laborales));
$this->ingreso_mensual_aproximado=htmlspecialchars(strip_tags($this->ingreso_mensual_aproximado));
$this->descripcion_vivienda=htmlspecialchars(strip_tags($this->descripcion_vivienda));
$this->comparte_cuarto=htmlspecialchars(strip_tags($this->comparte_cuarto));
$this->id_comparte_cuarto=htmlspecialchars(strip_tags($this->id_comparte_cuarto));
$this->comparte_cama=htmlspecialchars(strip_tags($this->comparte_cama));
$this->id_comparte_cama=htmlspecialchars(strip_tags($this->id_comparte_cama));
$this->id_informacion_socioeconomica=htmlspecialchars(strip_tags($this->id_informacion_socioeconomica));
	 
		// bind new values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":personas_laborales", $this->personas_laborales);
$stmt->bindParam(":ingreso_mensual_aproximado", $this->ingreso_mensual_aproximado);
$stmt->bindParam(":descripcion_vivienda", $this->descripcion_vivienda);
$stmt->bindParam(":comparte_cuarto", $this->comparte_cuarto);
$stmt->bindParam(":id_comparte_cuarto", $this->id_comparte_cuarto);
$stmt->bindParam(":comparte_cama", $this->comparte_cama);
$stmt->bindParam(":id_comparte_cama", $this->id_comparte_cama);
$stmt->bindParam(":id_informacion_socioeconomica", $this->id_informacion_socioeconomica);
	 
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
				if($columnName!='id_informacion_socioeconomica'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_informacion_socioeconomica = :id_informacion_socioeconomica"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_informacion_socioeconomica'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_informacion_socioeconomica", $this->id_informacion_socioeconomica);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the informacion_socioeconomica
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_informacion_socioeconomica = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_informacion_socioeconomica=htmlspecialchars(strip_tags($this->id_informacion_socioeconomica));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_informacion_socioeconomica);
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
$query = "SELECT  v.foto, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

function readByid_comparte_cuarto(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  v.foto, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  WHERE t.id_comparte_cuarto = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_comparte_cuarto);

$stmt->execute();
return $stmt;
}

function readByid_comparte_cama(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  v.foto, t.* FROM ". $this->table_name ." t  join persona v on t.id_persona = v.id_persona  WHERE t.id_comparte_cama = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_comparte_cama);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
