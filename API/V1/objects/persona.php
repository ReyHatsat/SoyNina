<?php
class Persona{
 
    // database connection and table name
    private $conn;
    private $table_name = "persona";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_persona;
public $foto;
public $identificacion;
public $nombre;
public $primer_apellido;
public $segundo_apellido;
public $fecha_nacimiento;
public $CV;
public $id_pais;
public $id_club;
public $ingreso_club;
public $id_tipo_persona;
public $id_grado_academico;
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  WHERE ".$where."";
		
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
	// read persona
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  
			q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* 
			FROM ". $this->table_name ." t  
			join pais q on t.id_pais = q.id_pais  
			join club m on t.id_club = m.id_club  
			join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  
			join grado_academico a on t.id_grado_academico = a.id_grado_academico  
			WHERE t.id_persona LIKE ? 
			OR t.foto LIKE ?  
			OR t.identificacion LIKE ?  
			OR t.nombre LIKE ?  
			OR t.primer_apellido LIKE ?  
			OR t.segundo_apellido LIKE ?  
			OR t.fecha_nacimiento LIKE ?  
			OR t.CV LIKE ?  
			OR t.id_pais LIKE ?  
			OR q.nombre LIKE ?  
			OR t.id_club LIKE ?  
			OR m.nombre LIKE ?  
			OR t.ingreso_club LIKE ?  
			OR t.id_tipo_persona LIKE ?  
			OR c.tipo_persona LIKE ?  
			OR t.id_grado_academico LIKE ?  
			OR a.grado_academico LIKE ?  
			OR t.activo LIKE ?  
			LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$stmt->bindParam(15, $searchKey);
		$stmt->bindParam(16, $searchKey);
		$stmt->bindParam(17, $searchKey);
		$stmt->bindParam(18, $searchKey);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}


	//Search table
	function searchUsuario($searchKey){
		$searchKey = $searchKey.'%';
		if(isset($_GET["pageNo"])){
			$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 

		// select all query
		$query = "
			SELECT  
				q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.*, usr.id_usuario 
			FROM ". $this->table_name ." t  
				join pais q on t.id_pais = q.id_pais  
				join club m on t.id_club = m.id_club 
				left join usuario usr on usr.id_persona = t.id_persona 
				join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  
				join grado_academico a on t.id_grado_academico = a.id_grado_academico  
			WHERE 
				t.identificacion LIKE ?  
				OR t.nombre LIKE ?  
				OR t.primer_apellido LIKE ?  
				OR t.segundo_apellido LIKE ?   
			LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind searchKey
		$stmt->bindParam(1, $searchKey);
		$stmt->bindParam(2, $searchKey);
		$stmt->bindParam(3, $searchKey);
		$stmt->bindParam(4, $searchKey);
	 
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
		$query = "SELECT  q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  WHERE t.id_persona = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_persona);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->identificacion = $row['identificacion'];
$this->nombre = $row['nombre'];
$this->primer_apellido = $row['primer_apellido'];
$this->segundo_apellido = $row['segundo_apellido'];
$this->fecha_nacimiento = $row['fecha_nacimiento'];
$this->CV = $row['CV'];
$this->id_pais = $row['id_pais'];
$this->nombre = $row['nombre'];
$this->id_club = $row['id_club'];
$this->nombre = $row['nombre'];
$this->ingreso_club = $row['ingreso_club'];
$this->id_tipo_persona = $row['id_tipo_persona'];
$this->tipo_persona = $row['tipo_persona'];
$this->id_grado_academico = $row['id_grado_academico'];
$this->grado_academico = $row['grado_academico'];
$this->activo = $row['activo'];
		}
		else{
		$this->id_persona=null;
		}
	}

	
	
	// create persona
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET foto=:foto,identificacion=:identificacion,nombre=:nombre,primer_apellido=:primer_apellido,segundo_apellido=:segundo_apellido,fecha_nacimiento=:fecha_nacimiento,CV=:CV,id_pais=:id_pais,id_club=:id_club,ingreso_club=:ingreso_club,id_tipo_persona=:id_tipo_persona,id_grado_academico=:id_grado_academico,activo=:activo";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->foto=htmlspecialchars(strip_tags($this->foto));
$this->identificacion=htmlspecialchars(strip_tags($this->identificacion));
$this->nombre=htmlspecialchars(strip_tags($this->nombre));
$this->primer_apellido=htmlspecialchars(strip_tags($this->primer_apellido));
$this->segundo_apellido=htmlspecialchars(strip_tags($this->segundo_apellido));
$this->fecha_nacimiento=htmlspecialchars(strip_tags($this->fecha_nacimiento));
$this->CV=htmlspecialchars(strip_tags($this->CV));
$this->id_pais=htmlspecialchars(strip_tags($this->id_pais));
$this->id_club=htmlspecialchars(strip_tags($this->id_club));
$this->ingreso_club=htmlspecialchars(strip_tags($this->ingreso_club));
$this->id_tipo_persona=htmlspecialchars(strip_tags($this->id_tipo_persona));
$this->id_grado_academico=htmlspecialchars(strip_tags($this->id_grado_academico));
$this->activo=htmlspecialchars(strip_tags($this->activo));
	 
		// bind values
		
$stmt->bindParam(":foto", $this->foto);
$stmt->bindParam(":identificacion", $this->identificacion);
$stmt->bindParam(":nombre", $this->nombre);
$stmt->bindParam(":primer_apellido", $this->primer_apellido);
$stmt->bindParam(":segundo_apellido", $this->segundo_apellido);
$stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
$stmt->bindParam(":CV", $this->CV);
$stmt->bindParam(":id_pais", $this->id_pais);
$stmt->bindParam(":id_club", $this->id_club);
$stmt->bindParam(":ingreso_club", $this->ingreso_club);
$stmt->bindParam(":id_tipo_persona", $this->id_tipo_persona);
$stmt->bindParam(":id_grado_academico", $this->id_grado_academico);
$stmt->bindParam(":activo", $this->activo);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the persona
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET foto=:foto,identificacion=:identificacion,nombre=:nombre,primer_apellido=:primer_apellido,segundo_apellido=:segundo_apellido,fecha_nacimiento=:fecha_nacimiento,CV=:CV,id_pais=:id_pais,id_club=:id_club,ingreso_club=:ingreso_club,id_tipo_persona=:id_tipo_persona,id_grado_academico=:id_grado_academico,activo=:activo WHERE id_persona = :id_persona";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->foto=htmlspecialchars(strip_tags($this->foto));
$this->identificacion=htmlspecialchars(strip_tags($this->identificacion));
$this->nombre=htmlspecialchars(strip_tags($this->nombre));
$this->primer_apellido=htmlspecialchars(strip_tags($this->primer_apellido));
$this->segundo_apellido=htmlspecialchars(strip_tags($this->segundo_apellido));
$this->fecha_nacimiento=htmlspecialchars(strip_tags($this->fecha_nacimiento));
$this->CV=htmlspecialchars(strip_tags($this->CV));
$this->id_pais=htmlspecialchars(strip_tags($this->id_pais));
$this->id_club=htmlspecialchars(strip_tags($this->id_club));
$this->ingreso_club=htmlspecialchars(strip_tags($this->ingreso_club));
$this->id_tipo_persona=htmlspecialchars(strip_tags($this->id_tipo_persona));
$this->id_grado_academico=htmlspecialchars(strip_tags($this->id_grado_academico));
$this->activo=htmlspecialchars(strip_tags($this->activo));
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
	 
		// bind new values
		
$stmt->bindParam(":foto", $this->foto);
$stmt->bindParam(":identificacion", $this->identificacion);
$stmt->bindParam(":nombre", $this->nombre);
$stmt->bindParam(":primer_apellido", $this->primer_apellido);
$stmt->bindParam(":segundo_apellido", $this->segundo_apellido);
$stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
$stmt->bindParam(":CV", $this->CV);
$stmt->bindParam(":id_pais", $this->id_pais);
$stmt->bindParam(":id_club", $this->id_club);
$stmt->bindParam(":ingreso_club", $this->ingreso_club);
$stmt->bindParam(":id_tipo_persona", $this->id_tipo_persona);
$stmt->bindParam(":id_grado_academico", $this->id_grado_academico);
$stmt->bindParam(":activo", $this->activo);
$stmt->bindParam(":id_persona", $this->id_persona);
	 
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
				if($columnName!='id_persona'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_persona = :id_persona"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_persona'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_persona", $this->id_persona);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the persona
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_persona = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_persona);
	 $stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByid_pais(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  WHERE t.id_pais = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_pais);

$stmt->execute();
return $stmt;
}

function readByid_club(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  WHERE t.id_club = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_club);

$stmt->execute();
return $stmt;
}

function readByid_tipo_persona(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  WHERE t.id_tipo_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_tipo_persona);

$stmt->execute();
return $stmt;
}

function readByid_grado_academico(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  q.nombre, m.nombre, c.tipo_persona, a.grado_academico, t.* FROM ". $this->table_name ." t  join pais q on t.id_pais = q.id_pais  join club m on t.id_club = m.id_club  join tipo_persona c on t.id_tipo_persona = c.id_tipo_persona  join grado_academico a on t.id_grado_academico = a.id_grado_academico  WHERE t.id_grado_academico = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_grado_academico);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
