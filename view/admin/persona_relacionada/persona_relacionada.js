//-----------------------Variables grobales-----------------------//
let g__Persona_Relacionada = [];/////////////cambiar/////////////
let g__Persona_Relacionada_datatables = null;/////////////cambiar/////////////
let g__Persona = [];
let g__Ocupacion = [];
let g__Grado = [];
let g__Parentezco = [];
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();

async function init() {
  let a = await cargarPersonaRelacionada();
  let b = await cargarPersona();
  let c = await cargarOcupacion();
  let d = await cargarGrado();
  let e = await cargarDireccion();
  let f = await cargarParentezco();
}
//-----------------------End init-----------------------//


//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto telefono-----------------------//
  function generarObjetoEdit(data){
    return {
        id_telefono:data,/////////////cambiar/////////////
        numero:$("#f_edit").val(),
        active:1,
    }
  };

  //-----------------------End Creación de objeto telefono-----------------------//
//-----------------------End Creación de objeto-----------------------//












//-----------------------Eventos del formulario-----------------------//
$("#btn_agregar_persona_relacionada").click(function(){
  window.location.href = "?adm=add_pers_rela";
});
//-----------------------Eventos del formulario-----------------------//
$( "#f_direccion" ).change(function() {
    if ($( "#f_direccion" ).val() == "n") {
      $( "#d_direccion" ).removeClass( "d-none" );
    }
    if ($( "#f_direccion" ).val() != "n") {
      $( "#d_direccion" ).addClass( "d-none" );
      $("#f_provincia").val(0);
      $("#f_canton").val(0);
      $("#f_distrito").val(0);
      $("#f_otras_senas").val("");
    }
});
$("#f_provincia").change(function(){
  $("#d_canton").removeClass("d-none");
});
$("#f_canton").change(function(){
  $("#d_distrito").removeClass("d-none");
});
$("#f_distrito").change(function(){
  $("#d_otras_senas").removeClass("d-none");
});
$( "#f_privado_libertad" ).change(function() {
    $( "#d_privado_libertad" ).toggleClass( "d-none" );
    $("#f_descripcion_privado_libertad").val("");
});
$( "#f_consumo_drogas" ).change(function() {
    $( "#d_consumo_drogas" ).toggleClass( "d-none" );
    $("#f_descripcion_consumo_drogas").val("");
});
$( "#f_denuncia_interpuesta" ).change(function() {
    $( "#d_denuncia_interpuesta" ).toggleClass( "d-none" );
    $("#f_descripcion_denuncia").val("");
});
$( "#btn_agregar_persona_relacionada" ).click(function() {
  console.log(generarObjetoPersonaRelacionada());
  $("#f_selec_persona").val(0);
  $("#f_lugar_ocupacion").val("");
  $("#f_select_nina").val(0);
  $("#f_parentezco").val(0);
  $("#f_descripcion_relacion_nina").val("");
  $("#f_grado_academico").val(0);
  $("#f_descripcion_privado_libertad").val("");
  $("#f_descripcion_consumo_drogas").val("");
  $("#f_descripcion_denuncia").val("");
  $("#f_direccion").val(0);
  $("#f_ocupacion").val(0);
  $("#f_autorizado_recoger").val(0);
});
$("#btn_cancelar_persona_relacionada").click(function(){

    $("#f_selec_persona").val(0);
    $("#f_lugar_ocupacion").val("");
    $("#f_select_nina").val(0);
    $("#f_parentezco").val(0);
    $("#f_descripcion_relacion_nina").val("");
    $("#f_descripcion_relacion_nina").val("");
    $("#f_descripcion_privado_libertad").val("");
    $("#f_descripcion_consumo_drogas").val("");
    $("#f_descripcion_denuncia").val("");
    $("#f_direccion").val(0);
    $("#f_ocupacion").val(0);
    $("#f_autorizado_recoger").val(0);
});
$("#f_parentezco").click(function(){
  if ($("#f_parentezco").val() == "n") {
      $("#d_parentezco").removeClass("d-none");
  }
    if ($("#f_parentezco").val() != "n") {
        $("#d_parentezco").addClass("d-none");
    }
});
$("#btn_calcelar_nuevo_parentezco").click(function(){
  $("#f_parentezco").val(0);
  $("#d_parentezco").addClass("d-none");
});
$("#btn_crear_nuevo_parentezco").click(function(){
  console.log(generarObjetoParentezco());
  $("#d_parentezco").addClass("d-none");
});
$("#f_ocupacion").click(function(){
  if ($("#f_ocupacion").val() == "n") {
    $("#d_ocupacion").removeClass("d-none");
  }
  if ($("#f_ocupacion").val() != "n") {
    $("#d_ocupacion").addClass("d-none");
  }
});
$("#btn_calcelar_nueva_ocupacion").click(function(){
  $("#f_ocupacion").val(0);
  $("#d_ocupacion").addClass("d-none");
});
$("#btn_crear_nueva_ocupacion").click(function(){
  console.log(generarObjetoOcupacion());
  $("#f_ocupacion").val(0);
  $("#d_ocupacion").addClass("d-none");
});
$("#btn_calcelar_nueva_localidad").click(function(){
  $("#f_direccion").val(0);
  $("#f_provincia").val(0);
  $("#f_canton").val(0);
  $("#f_otras_senas").val("");
  $("#d_direccion").addClass("d-none");
  $("#d_canton").addClass("d-none");
  $("#d_distrito").addClass("d-none");
  $("#d_otras_senas").addClass("d-none");
});
$("#btn_crear_nueva_localidad").click(function(){
  console.log(generarObjetoDireccion());
  $("#f_direccion").val(0);
  $("#f_provincia").val(0);
  $("#f_canton").val(0);
  $("#f_otras_senas").val("");
  $("#d_direccion").addClass("d-none");
  $("#d_canton").addClass("d-none");
  $("#d_distrito").addClass("d-none");
  $("#d_otras_senas").addClass("d-none");
});
$("#f_grado_academico").click(function(){
  if ($("#f_grado_academico").val() == "n") {
    $("#d_grado_academico").removeClass("d-none");
  }
  if ($("#f_grado_academico").val() != "n") {
    $("#d_grado_academico").addClass("d-none");
  }
});
$("#btn_crear_grado").click(function(){
  console.log(generarObjetoGrado());
  $("#d_grado_academico").addClass("d-none");
});
$("#btn_calcelar_grado").click(function(){
  $("#f_grado_academico").val(0);
  $("#d_grado_academico").addClass("d-none");
});
//-----------------------End Eventos del formulario-----------------------//
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Telefono.find(element => element.id_telefono == data);/////////////cambiar/////////////
  return found;
};
function editar(id) {
  location.replace(`?adm=add_pers_rela&id=${id}`);
};
function borrar(id) {
  let arrayID = buscarPersonaPorID(id);/////////////cambiar el arrayID.xxx/////////////
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea borrar a la persona relacionada ${arrayID.nombre_persona}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoBorrar(${id})">Sí</button>
    `);
};
//-------------------------------->>
//-----------------------End Eventos del formulario-----------------------//










//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__Persona_Relacionada_datatables = $("#dt_persona_relacionada").DataTable({/////////////cambiar/////////////
    data: g__Persona_Relacionada,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {
        data: "id_persona_relacionada",
        render: function(data) {
          let persona = buscarPersonaPorID(data);
          return persona.nombre_persona+" "+persona.primer_apellido+" "+persona.segundo_apellido;
        }

      },
      {
        data: "lugar_ocupacion",
      },
      {
        data: "id_grado_academico",
        render: function (data) {
          let grado = buscarGradoPorID(data);
          return grado.nombre_grado;
        }
      },
      {
        data: "id_direccion",
        render: function (data) {
          let direccion = buscarDireccionPorID(data);
          return direccion.otras_senas;
        }
      },
      {
        data: "id_ocupacion",
        render: function(data) {
          let ocupacion = buscarOcupacionPorID(data);
          return ocupacion.nombre_ocupacion;
        }
      },
      {
        data: "autorizado_recoger",
        render: function(data) {
          let persona = buscarPersonaPorID(data);
          return persona.nombre_persona+" "+persona.primer_apellido+" "+persona.segundo_apellido;
        }
      },
      {
        data: "id_nina",
        render: function(data) {
          let persona = buscarPersonaPorID(data);
          return persona.nombre_persona+" "+persona.primer_apellido+" "+persona.segundo_apellido;
        }
      },
      {
        data: "id_parentezco",
        render: function(data) {
          let parentezco = buscarParentezcoPorID(data);
          return parentezco.parentezco;
        }
      },
      {data: "descripcion_relacion_nina"},
      {
        data: "privado_libertad",
        render: function(data) {
          if (data == 1) {
            return "Sí";
          }
          return "No";
        }
      },
      {data: "descripcion_privado_libertad"},
      {
        data: "consumo_drogas",
        render: function(data) {
          if (data == 1) {
            return "Sí";
          }
          return "No";
        }
      },
      {data: "descripcion_consumo_drogas"},
      {
        data: "denuncia_interpuesta",
        render: function(data) {
          if (data == 1) {
            return "Sí";
          }
          return "No";
        }
      },
      {data: "descripcion_denuncia"},
      {
        data: "active",
        render: function(data) {
          switch (data) {
            case "1":
              return '<span class="badge badge-primary">Activo</span>';
              break;
            case "2":
              return '<span class="badge badge-danger">Inactivo</span>';
              break;
            default:
            return '<span class="badge badge-dark">No definido</span>';

          }
        }
      },
      {
        data: "id_persona_relacionada",
        render:function (data) {
          return `
            <button class="btn btn-success" onclick="editar(${data})"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger" onclick="borrar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-trash-alt"></i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//



//-----------------------Eventos de la base de datos-----------------------//
function cargarPersonaRelacionada(){
  return new Promise ( resolve => {
    request('<?=PATH_API?>persona_relacionada/read.php', function(r){
      resolve(r.code);
      g__Persona_Relacionada = r;/////////////cambiar/////////////
      g__Persona_Relacionada = g__Persona_Relacionada.data.records;/////////////cambiar/////////////
    });
  });
}

function cargarPersona(){
  return new Promise ( resolve => {
    request('<?=PATH_API?>persona/read.php', function(r){
      resolve(r.code);
      g__Persona = r.data.records;/////////////cambiar/////////////
    });
  });
}

function buscarPersonaPorID(data) {
  let found = g__Persona.find(element => element.id_persona == data);/////////////cambiar/////////////
  return found;
};

function cargarOcupacion(){
  return new Promise ( resolve => {
  request('<?=PATH_API?>ocupacion/read.php', function(r){
    resolve(r.code);
    g__Ocupacion = r.data.records;/////////////cambiar/////////////
    });
  });
}

function buscarOcupacionPorID(data) {
  let found = g__Ocupacion.find(element => element.id_ocupacion == data);/////////////cambiar/////////////
  return found;
};


function cargarGrado(){
  return new Promise ( resolve => {
  request('<?=PATH_API?>grado/read.php', function(r){
    resolve(r.code);
    g__Grado = r.data.records;/////////////cambiar/////////////
    });
  });
}

function buscarGradoPorID(data) {
  let found = g__Grado.find(element => element.id_grado == data);/////////////cambiar/////////////
  return found;
};


function cargarDireccion(){
  return new Promise ( resolve => {
  request('<?=PATH_API?>direccion/read.php', function(r){
    resolve(r.code);
    g__Direccion = r.data.records;/////////////cambiar/////////////
    });
  });
}

function buscarDireccionPorID(data) {
  let found = g__Direccion.find(element => element.id_direccion == data);/////////////cambiar/////////////
  return found;
};


function cargarParentezco(){//Horrores orto...
  return new Promise ( resolve => {
  request('<?=PATH_API?>parentezco/read.php', function(r){
    resolve(r.code);
    g__Parentezco = r.data.records;/////////////cambiar/////////////
    renderDataTable();
    });
  });
}

function buscarParentezcoPorID(data) {
  let found = g__Parentezco.find(element => element.id_parentezco == data);/////////////cambiar/////////////
  return found;
};


function eventoBorrar(data) {
  let value = {id_persona_relacionada:data}/////////////cambiar/////////////
  if(!value){ return };
  request('<?=PATH_API?>persona_relacionada/delete.php?', function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Borrado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}

//-----------------------End Eventos de la base de datos-----------------------//
