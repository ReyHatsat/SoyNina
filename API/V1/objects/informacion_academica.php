<?php
class Informacion_Academica{
 
    // database connection and table name
    private $conn;
    private $table_name = "informacion_academica";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
public $id_informacion_academica;
public $id_persona;
public $id_centro_academico;
public $id_grado;
public $id_rendimiento;
public $id_apoyo_externo;
public $repitente;
public $grado_repetido;
public $beca;
public $descripcion_beca;
public $motivacion_escuela;
public $descripcion_motivacion;
public $traslada_acompanada;
public $id_encargado_traslado;
public $id_transporte;
public $estudia_acompanada;
public $id_encargado_estudio;
public $trabaja_acompanada;
public $id_encargado_trabajos;
public $relacion_estudiantes;
public $acontecimiento_importante;
public $actividades;
public $talleres;
    
 
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE ".$where."";
		
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
	// read informacion_academica
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_informacion_academica LIKE ? OR t.id_persona LIKE ?  OR f.foto LIKE ?  OR t.id_centro_academico LIKE ?  OR u.centro_academico LIKE ?  OR t.id_grado LIKE ?  OR x.grado LIKE ?  OR t.id_rendimiento LIKE ?  OR k.rendimiento LIKE ?  OR t.id_apoyo_externo LIKE ?  OR r.institucion LIKE ?  OR t.repitente LIKE ?  OR t.grado_repetido LIKE ?  OR t.beca LIKE ?  OR t.descripcion_beca LIKE ?  OR t.motivacion_escuela LIKE ?  OR t.descripcion_motivacion LIKE ?  OR t.traslada_acompanada LIKE ?  OR t.id_encargado_traslado LIKE ?  OR t.id_transporte LIKE ?  OR q.tipo_transporte LIKE ?  OR t.estudia_acompanada LIKE ?  OR t.id_encargado_estudio LIKE ?  OR t.trabaja_acompanada LIKE ?  OR t.id_encargado_trabajos LIKE ?  OR t.relacion_estudiantes LIKE ?  OR t.acontecimiento_importante LIKE ?  OR t.actividades LIKE ?  OR t.talleres LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
$stmt->bindParam(19, $searchKey);
$stmt->bindParam(20, $searchKey);
$stmt->bindParam(21, $searchKey);
$stmt->bindParam(22, $searchKey);
$stmt->bindParam(23, $searchKey);
$stmt->bindParam(24, $searchKey);
$stmt->bindParam(25, $searchKey);
$stmt->bindParam(26, $searchKey);
$stmt->bindParam(27, $searchKey);
$stmt->bindParam(28, $searchKey);
$stmt->bindParam(29, $searchKey);
	 
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
		$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_informacion_academica = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_informacion_academica);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
		
$this->id_informacion_academica = $row['id_informacion_academica'];
$this->id_persona = $row['id_persona'];
$this->foto = $row['foto'];
$this->id_centro_academico = $row['id_centro_academico'];
$this->centro_academico = $row['centro_academico'];
$this->id_grado = $row['id_grado'];
$this->grado = $row['grado'];
$this->id_rendimiento = $row['id_rendimiento'];
$this->rendimiento = $row['rendimiento'];
$this->id_apoyo_externo = $row['id_apoyo_externo'];
$this->institucion = $row['institucion'];
$this->repitente = $row['repitente'];
$this->grado_repetido = $row['grado_repetido'];
$this->beca = $row['beca'];
$this->descripcion_beca = $row['descripcion_beca'];
$this->motivacion_escuela = $row['motivacion_escuela'];
$this->descripcion_motivacion = $row['descripcion_motivacion'];
$this->traslada_acompanada = $row['traslada_acompanada'];
$this->id_encargado_traslado = $row['id_encargado_traslado'];
$this->id_transporte = $row['id_transporte'];
$this->tipo_transporte = $row['tipo_transporte'];
$this->estudia_acompanada = $row['estudia_acompanada'];
$this->id_encargado_estudio = $row['id_encargado_estudio'];
$this->trabaja_acompanada = $row['trabaja_acompanada'];
$this->id_encargado_trabajos = $row['id_encargado_trabajos'];
$this->relacion_estudiantes = $row['relacion_estudiantes'];
$this->acontecimiento_importante = $row['acontecimiento_importante'];
$this->actividades = $row['actividades'];
$this->talleres = $row['talleres'];
		}
		else{
		$this->id_informacion_academica=null;
		}
	}

	
	
	// create informacion_academica
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_persona=:id_persona,id_centro_academico=:id_centro_academico,id_grado=:id_grado,id_rendimiento=:id_rendimiento,id_apoyo_externo=:id_apoyo_externo,repitente=:repitente,grado_repetido=:grado_repetido,beca=:beca,descripcion_beca=:descripcion_beca,motivacion_escuela=:motivacion_escuela,descripcion_motivacion=:descripcion_motivacion,traslada_acompanada=:traslada_acompanada,id_encargado_traslado=:id_encargado_traslado,id_transporte=:id_transporte,estudia_acompanada=:estudia_acompanada,id_encargado_estudio=:id_encargado_estudio,trabaja_acompanada=:trabaja_acompanada,id_encargado_trabajos=:id_encargado_trabajos,relacion_estudiantes=:relacion_estudiantes,acontecimiento_importante=:acontecimiento_importante,actividades=:actividades,talleres=:talleres";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_centro_academico=htmlspecialchars(strip_tags($this->id_centro_academico));
$this->id_grado=htmlspecialchars(strip_tags($this->id_grado));
$this->id_rendimiento=htmlspecialchars(strip_tags($this->id_rendimiento));
$this->id_apoyo_externo=htmlspecialchars(strip_tags($this->id_apoyo_externo));
$this->repitente=htmlspecialchars(strip_tags($this->repitente));
$this->grado_repetido=htmlspecialchars(strip_tags($this->grado_repetido));
$this->beca=htmlspecialchars(strip_tags($this->beca));
$this->descripcion_beca=htmlspecialchars(strip_tags($this->descripcion_beca));
$this->motivacion_escuela=htmlspecialchars(strip_tags($this->motivacion_escuela));
$this->descripcion_motivacion=htmlspecialchars(strip_tags($this->descripcion_motivacion));
$this->traslada_acompanada=htmlspecialchars(strip_tags($this->traslada_acompanada));
$this->id_encargado_traslado=htmlspecialchars(strip_tags($this->id_encargado_traslado));
$this->id_transporte=htmlspecialchars(strip_tags($this->id_transporte));
$this->estudia_acompanada=htmlspecialchars(strip_tags($this->estudia_acompanada));
$this->id_encargado_estudio=htmlspecialchars(strip_tags($this->id_encargado_estudio));
$this->trabaja_acompanada=htmlspecialchars(strip_tags($this->trabaja_acompanada));
$this->id_encargado_trabajos=htmlspecialchars(strip_tags($this->id_encargado_trabajos));
$this->relacion_estudiantes=htmlspecialchars(strip_tags($this->relacion_estudiantes));
$this->acontecimiento_importante=htmlspecialchars(strip_tags($this->acontecimiento_importante));
$this->actividades=htmlspecialchars(strip_tags($this->actividades));
$this->talleres=htmlspecialchars(strip_tags($this->talleres));
	 
		// bind values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_centro_academico", $this->id_centro_academico);
$stmt->bindParam(":id_grado", $this->id_grado);
$stmt->bindParam(":id_rendimiento", $this->id_rendimiento);
$stmt->bindParam(":id_apoyo_externo", $this->id_apoyo_externo);
$stmt->bindParam(":repitente", $this->repitente);
$stmt->bindParam(":grado_repetido", $this->grado_repetido);
$stmt->bindParam(":beca", $this->beca);
$stmt->bindParam(":descripcion_beca", $this->descripcion_beca);
$stmt->bindParam(":motivacion_escuela", $this->motivacion_escuela);
$stmt->bindParam(":descripcion_motivacion", $this->descripcion_motivacion);
$stmt->bindParam(":traslada_acompanada", $this->traslada_acompanada);
$stmt->bindParam(":id_encargado_traslado", $this->id_encargado_traslado);
$stmt->bindParam(":id_transporte", $this->id_transporte);
$stmt->bindParam(":estudia_acompanada", $this->estudia_acompanada);
$stmt->bindParam(":id_encargado_estudio", $this->id_encargado_estudio);
$stmt->bindParam(":trabaja_acompanada", $this->trabaja_acompanada);
$stmt->bindParam(":id_encargado_trabajos", $this->id_encargado_trabajos);
$stmt->bindParam(":relacion_estudiantes", $this->relacion_estudiantes);
$stmt->bindParam(":acontecimiento_importante", $this->acontecimiento_importante);
$stmt->bindParam(":actividades", $this->actividades);
$stmt->bindParam(":talleres", $this->talleres);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the informacion_academica
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_persona=:id_persona,id_centro_academico=:id_centro_academico,id_grado=:id_grado,id_rendimiento=:id_rendimiento,id_apoyo_externo=:id_apoyo_externo,repitente=:repitente,grado_repetido=:grado_repetido,beca=:beca,descripcion_beca=:descripcion_beca,motivacion_escuela=:motivacion_escuela,descripcion_motivacion=:descripcion_motivacion,traslada_acompanada=:traslada_acompanada,id_encargado_traslado=:id_encargado_traslado,id_transporte=:id_transporte,estudia_acompanada=:estudia_acompanada,id_encargado_estudio=:id_encargado_estudio,trabaja_acompanada=:trabaja_acompanada,id_encargado_trabajos=:id_encargado_trabajos,relacion_estudiantes=:relacion_estudiantes,acontecimiento_importante=:acontecimiento_importante,actividades=:actividades,talleres=:talleres WHERE id_informacion_academica = :id_informacion_academica";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->id_centro_academico=htmlspecialchars(strip_tags($this->id_centro_academico));
$this->id_grado=htmlspecialchars(strip_tags($this->id_grado));
$this->id_rendimiento=htmlspecialchars(strip_tags($this->id_rendimiento));
$this->id_apoyo_externo=htmlspecialchars(strip_tags($this->id_apoyo_externo));
$this->repitente=htmlspecialchars(strip_tags($this->repitente));
$this->grado_repetido=htmlspecialchars(strip_tags($this->grado_repetido));
$this->beca=htmlspecialchars(strip_tags($this->beca));
$this->descripcion_beca=htmlspecialchars(strip_tags($this->descripcion_beca));
$this->motivacion_escuela=htmlspecialchars(strip_tags($this->motivacion_escuela));
$this->descripcion_motivacion=htmlspecialchars(strip_tags($this->descripcion_motivacion));
$this->traslada_acompanada=htmlspecialchars(strip_tags($this->traslada_acompanada));
$this->id_encargado_traslado=htmlspecialchars(strip_tags($this->id_encargado_traslado));
$this->id_transporte=htmlspecialchars(strip_tags($this->id_transporte));
$this->estudia_acompanada=htmlspecialchars(strip_tags($this->estudia_acompanada));
$this->id_encargado_estudio=htmlspecialchars(strip_tags($this->id_encargado_estudio));
$this->trabaja_acompanada=htmlspecialchars(strip_tags($this->trabaja_acompanada));
$this->id_encargado_trabajos=htmlspecialchars(strip_tags($this->id_encargado_trabajos));
$this->relacion_estudiantes=htmlspecialchars(strip_tags($this->relacion_estudiantes));
$this->acontecimiento_importante=htmlspecialchars(strip_tags($this->acontecimiento_importante));
$this->actividades=htmlspecialchars(strip_tags($this->actividades));
$this->talleres=htmlspecialchars(strip_tags($this->talleres));
$this->id_informacion_academica=htmlspecialchars(strip_tags($this->id_informacion_academica));
	 
		// bind new values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":id_centro_academico", $this->id_centro_academico);
$stmt->bindParam(":id_grado", $this->id_grado);
$stmt->bindParam(":id_rendimiento", $this->id_rendimiento);
$stmt->bindParam(":id_apoyo_externo", $this->id_apoyo_externo);
$stmt->bindParam(":repitente", $this->repitente);
$stmt->bindParam(":grado_repetido", $this->grado_repetido);
$stmt->bindParam(":beca", $this->beca);
$stmt->bindParam(":descripcion_beca", $this->descripcion_beca);
$stmt->bindParam(":motivacion_escuela", $this->motivacion_escuela);
$stmt->bindParam(":descripcion_motivacion", $this->descripcion_motivacion);
$stmt->bindParam(":traslada_acompanada", $this->traslada_acompanada);
$stmt->bindParam(":id_encargado_traslado", $this->id_encargado_traslado);
$stmt->bindParam(":id_transporte", $this->id_transporte);
$stmt->bindParam(":estudia_acompanada", $this->estudia_acompanada);
$stmt->bindParam(":id_encargado_estudio", $this->id_encargado_estudio);
$stmt->bindParam(":trabaja_acompanada", $this->trabaja_acompanada);
$stmt->bindParam(":id_encargado_trabajos", $this->id_encargado_trabajos);
$stmt->bindParam(":relacion_estudiantes", $this->relacion_estudiantes);
$stmt->bindParam(":acontecimiento_importante", $this->acontecimiento_importante);
$stmt->bindParam(":actividades", $this->actividades);
$stmt->bindParam(":talleres", $this->talleres);
$stmt->bindParam(":id_informacion_academica", $this->id_informacion_academica);
	 
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
				if($columnName!='id_informacion_academica'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_informacion_academica = :id_informacion_academica"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_informacion_academica'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_informacion_academica", $this->id_informacion_academica);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the informacion_academica
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_informacion_academica = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_informacion_academica=htmlspecialchars(strip_tags($this->id_informacion_academica));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_informacion_academica);
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
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

function readByid_centro_academico(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_centro_academico = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_centro_academico);

$stmt->execute();
return $stmt;
}

function readByid_grado(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_grado = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_grado);

$stmt->execute();
return $stmt;
}

function readByid_rendimiento(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_rendimiento = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_rendimiento);

$stmt->execute();
return $stmt;
}

function readByid_apoyo_externo(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_apoyo_externo = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_apoyo_externo);

$stmt->execute();
return $stmt;
}

function readByid_encargado_traslado(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_encargado_traslado = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_encargado_traslado);

$stmt->execute();
return $stmt;
}

function readByid_transporte(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_transporte = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_transporte);

$stmt->execute();
return $stmt;
}

function readByid_encargado_estudio(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_encargado_estudio = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_encargado_estudio);

$stmt->execute();
return $stmt;
}

function readByid_encargado_trabajos(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  f.foto, u.centro_academico, x.grado, k.rendimiento, r.institucion, q.tipo_transporte, t.* FROM ". $this->table_name ." t  join persona f on t.id_persona = f.id_persona  join centro_academico u on t.id_centro_academico = u.id_centro_academico  join grado x on t.id_grado = x.id_grado  join rendimiento k on t.id_rendimiento = k.id_rendimiento  join apoyo_externo r on t.id_apoyo_externo = r.id_apoyo_externo  join transporte q on t.id_transporte = q.id_transporte  WHERE t.id_encargado_trabajos = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_encargado_trabajos);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
