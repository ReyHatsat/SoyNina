<?php
class Usuario{
 
    // database connection and table name
    private $conn;
    private $table_name = "usuario";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
    // object properties
	
	public $id_usuario;
	public $id_persona;
	public $nombre_usuario;
	public $login_salt;
	public $login_password;
    
	
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }





	//Generate the salt of the user 
	function genSalt(){
		$unique = uniqid();
		$unique = hash('sha512', $unique);
		return $unique;
	}




	function hashPassword_Salt($password, $salt){
		// Hash both values separately, then append the salt and hash again.
		$hashed_password = $this->recurrentHash($password);
		$hashed_salt = $this->recurrentHash($salt);
		return $this->recurrentHash( $hashed_password.$hashed_salt );
	}



	function recurrentHash($string, $base_count = 30){

		// Define the number of times the hash is repeating by validating if the first char is in a given array
		$values = str_split('Jr6x0VvLEBKIlaGXoDpbf1hcYiSzTNeQg39HPnkujt87Uw4RmMFWqZ2Od5sCyA');
		$offset = array_search($string[0], $values);
		$offset = ($offset) ? $offset : -1;

		//the number of hashes depends on the first character of the string, 
		// it could be -1,0 or N depending on the length of the initial string of chars.
		$number_of_hashes = $base_count + $offset; 

		for ($i=0; $i < $number_of_hashes; $i++) { 
			$string = hash('sha512', $string);
		}

		return $string;
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join persona r on t.id_persona = r.id_persona  WHERE ".$where."";
		
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
	// read usuario
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "
		SELECT  t.*, r.* 
		FROM ". $this->table_name ." t  
		join persona r on t.id_persona = r.id_persona  
		ORDER BY t.id_usuario
		LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  r.foto, t.* FROM ". $this->table_name ." t  join persona r on t.id_persona = r.id_persona  WHERE t.id_usuario LIKE ? OR t.id_persona LIKE ?  OR r.foto LIKE ?  OR t.nombre_usuario LIKE ?  OR t.login_salt LIKE ?  OR t.login_password LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
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
		$query = "SELECT  r.foto, t.* FROM ". $this->table_name ." t  join persona r on t.id_persona = r.id_persona  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  r.foto, t.* FROM ". $this->table_name ." t  join persona r on t.id_persona = r.id_persona  WHERE t.id_usuario = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_usuario);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
			$this->id_usuario = $row['id_usuario'];
			$this->id_persona = $row['id_persona'];
			$this->foto = $row['foto'];
			$this->nombre_usuario = $row['nombre_usuario'];
			$this->login_salt = $row['login_salt'];
			$this->login_password = $row['login_password'];
		}
		else{
		$this->id_usuario=null;
		}
	}




	function readOneUsername(){
	 
		// query to read single record
		$query = "SELECT  r.foto, t.* FROM ". $this->table_name .
		" t  join persona r on t.id_persona = r.id_persona  
		WHERE t.nombre_usuario = ? LIMIT 0,1";
		
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id
		$stmt->bindParam(1, $this->id_usuario);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
		// set values to object properties
			$this->id_usuario = $row['id_usuario'];
			$this->id_persona = $row['id_persona'];
			$this->foto = $row['foto'];
			$this->nombre_usuario = $row['nombre_usuario'];
			$this->login_salt = $row['login_salt'];
			$this->login_password = $row['login_password'];
		}
		else{
		$this->id_usuario=null;
		}
	}
	

	
	
	// create usuario
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET id_persona=:id_persona,nombre_usuario=:nombre_usuario,login_salt=:login_salt,login_password=:login_password";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->nombre_usuario=htmlspecialchars(strip_tags($this->nombre_usuario));
$this->login_salt=htmlspecialchars(strip_tags($this->login_salt));
$this->login_password=htmlspecialchars(strip_tags($this->login_password));
	 
		// bind values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":nombre_usuario", $this->nombre_usuario);
$stmt->bindParam(":login_salt", $this->login_salt);
$stmt->bindParam(":login_password", $this->login_password);
	 
		// execute query
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
	 
		return 0;
		 
	}
	
	
	
	// update the usuario
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET id_persona=:id_persona,nombre_usuario=:nombre_usuario,login_salt=:login_salt,login_password=:login_password WHERE id_usuario = :id_usuario";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->id_persona=htmlspecialchars(strip_tags($this->id_persona));
$this->nombre_usuario=htmlspecialchars(strip_tags($this->nombre_usuario));
$this->login_salt=htmlspecialchars(strip_tags($this->login_salt));
$this->login_password=htmlspecialchars(strip_tags($this->login_password));
$this->id_usuario=htmlspecialchars(strip_tags($this->id_usuario));
	 
		// bind new values
		
$stmt->bindParam(":id_persona", $this->id_persona);
$stmt->bindParam(":nombre_usuario", $this->nombre_usuario);
$stmt->bindParam(":login_salt", $this->login_salt);
$stmt->bindParam(":login_password", $this->login_password);
$stmt->bindParam(":id_usuario", $this->id_usuario);
	 
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
				if($columnName!='id_usuario'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE id_usuario = :id_usuario"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='id_usuario'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":id_usuario", $this->id_usuario);
			$stmt->execute();

			 if($stmt->rowCount()) {
					return true;
				} else {
				   return false;
				}
	}
	// delete the usuario
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_usuario = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id_usuario=htmlspecialchars(strip_tags($this->id_usuario));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_usuario);
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
$query = "SELECT  r.foto, t.* FROM ". $this->table_name ." t  join persona r on t.id_persona = r.id_persona  WHERE t.id_persona = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->id_persona);

$stmt->execute();
return $stmt;
}

	//extra function will be generated for one to many relations
}
?>
