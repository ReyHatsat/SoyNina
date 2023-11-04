<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/helper.php';
// get database connection
include_once '../config/database.php';
 
// instantiate persona object
include_once '../objects/persona.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$persona = new Persona($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!isEmpty($data->foto)
&&!isEmpty($data->identificacion)
&&!isEmpty($data->nombre)
&&!isEmpty($data->primer_apellido)
&&!isEmpty($data->segundo_apellido)
&&!isEmpty($data->fecha_nacimiento)
&&!isEmpty($data->CV)
&&!isEmpty($data->id_pais)
&&!isEmpty($data->id_club)
&&!isEmpty($data->ingreso_club)
&&!isEmpty($data->id_tipo_persona)
&&!isEmpty($data->id_grado_academico)
&&!isEmpty($data->activo)){
 
    // set persona property values
	 
if(!isEmpty($data->foto)) { 
$persona->foto = $data->foto;
} else { 
$persona->foto = '';
}
if(!isEmpty($data->identificacion)) { 
$persona->identificacion = $data->identificacion;
} else { 
$persona->identificacion = '';
}
if(!isEmpty($data->nombre)) { 
$persona->nombre = $data->nombre;
} else { 
$persona->nombre = '';
}
if(!isEmpty($data->primer_apellido)) { 
$persona->primer_apellido = $data->primer_apellido;
} else { 
$persona->primer_apellido = '';
}
if(!isEmpty($data->segundo_apellido)) { 
$persona->segundo_apellido = $data->segundo_apellido;
} else { 
$persona->segundo_apellido = '';
}
if(!isEmpty($data->fecha_nacimiento)) { 
$persona->fecha_nacimiento = $data->fecha_nacimiento;
} else { 
$persona->fecha_nacimiento = '';
}
if(!isEmpty($data->CV)) { 
$persona->CV = $data->CV;
} else { 
$persona->CV = '';
}
if(!isEmpty($data->id_pais)) { 
$persona->id_pais = $data->id_pais;
} else { 
$persona->id_pais = '';
}
if(!isEmpty($data->id_club)) { 
$persona->id_club = $data->id_club;
} else { 
$persona->id_club = '';
}
if(!isEmpty($data->ingreso_club)) { 
$persona->ingreso_club = $data->ingreso_club;
} else { 
$persona->ingreso_club = '';
}
if(!isEmpty($data->id_tipo_persona)) { 
$persona->id_tipo_persona = $data->id_tipo_persona;
} else { 
$persona->id_tipo_persona = '';
}
if(!isEmpty($data->id_grado_academico)) { 
$persona->id_grado_academico = $data->id_grado_academico;
} else { 
$persona->id_grado_academico = '';
}
if(!isEmpty($data->activo)) { 
$persona->activo = $data->activo;
} else { 
$persona->activo = '1';
}
 	$lastInsertedId=$persona->create();
    // create the persona
    if($lastInsertedId!=0){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
 
    // if unable to create the persona, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create persona","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create persona. Data is incomplete.","document"=> ""));
}
?>
