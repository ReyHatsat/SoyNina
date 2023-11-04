//-----------------------Variables grobales-----------------------//
let g__asesor = [];
let g__persona = [];
let g__asesor_datatables = [];
let g__activo = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  g__asesor = await cargarAsesor();
  g__asesor = g__asesor.document.records;

  g__persona = await cargarPersona();
  g__persona = g__persona.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//



//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto rubro-----------------------//
  function generarObjeto(){
    return{
        id_persona:$("#f_persona").val(),
        funcion:$("#f_funcion").val(),
        fecha_ingreso:$("#f_fecha").val(),
    }
  };

  function generarObjetoEdit(data){
    return {
        id_asesor:data,
        id_persona:$("#f_edit_persona").val(),
        funcion:$("#f_edit_funcion").val(),
        fecha_ingreso:$("#f_edit_fecha").val(),
    }
  };

  /*function generarObjetoActivar(data){
    let arrayID = buscarPorID(data);
    let activoTmp = "";
    if (arrayID.activo == 0) {
      activoTmp = "1";
    }else {
      activoTmp = "0";
    }
    return {
        id_rubro:arrayID.id_rubro,
        rubro:arrayID.nombre_rubro,
        activo:activoTmp,
      }
    };*/
  //-----------------------End Creación de objeto rubro-----------------------//
//-----------------------End Creación de objeto-----------------------//


//-----------------------Eventos del formulario-----------------------//

//Cancelar
$("#btn_cancelar_asesor").click(function(){
  $("#f_persona").val("null");
  $("#f_funcion").val("");
  $("#f_fecha").val("");
  $( "#btn_agregar_asesor" ).prop( "disabled", true );
});

$("#btn_agregar_asesor").click(function(){
    let obj = generarObjeto()
    eventoCrear(obj);
  $("#f_persona").val("");
  $("#f_funcion").val("");
  $("#f_fecha").val("");

});

//Cargar la información de persona para el select del modal agregar
$("#btn_agregar_nuevo_asesor_modal").click(function(){
  cargarSelect();
});

//Agregar asesor
$("#btn_agregar_asesor").click(function(){
  if(obtenerPersona($("#f_persona").val()) != null){
    let obj = generarObjeto()
    eventoCrear(obj);
  }
  $("#f_persona").val("");
  $("#f_funcion").val("");
  $("#f_fecha").val("");

});

//Valida el ingreso de letras únicamente para el modal agregar
$('#f_funcion').on('keyup', function() {

  $('#demo').html('');
  if(validarTexto(this.value) == false){
    $('#demo').html('Ingrese únicamente letras');
  }
    validarCampo();
});

//Valida el ingreso de letras únicamente para el modal editar
/*$('#f_edit_funcion').on('keyup', function() {
  validarCampo();
  $('#demo_edit').html('');
  if(validarTexto(this.value) == false){
    $('#demo_edit').html('Ingrese únicamente letras');
    validarCampo();
  }
});*/

$("#f_persona").change(function(){
validarCampo();
});

$("#f_fecha").change(function(){
  validarCampo();
});

$("#f_fecha").flatpickr({
    enableTime: false,
    dateFormat: "Y-m-d",
});


//--------------------------------
function buscarPorID(data) {
  const found = g__asesor.find(element => element.id_asesor == data);
  return found;
};


function editar(data) {
  $("#contenedor_del_modal").html(`
    <form class="" id="f_form" method="post">
      <div class="modal-body">
        <label class="form-label">Persona</label>
        <select class="form-select js-example-basic-single" data-control="select2" id="f_edit_persona">
        </select>
      </div>
      <div class="modal-body">
        <label class="form-label">Función</label>
        <input type="text" class="form-control"/ id="f_edit_funcion">
        <div id="demo_edit"></div>
        </div>
        <div class="modal-body">
        <label class="form-label">Fecha de ingreso</label>
        <input class="form-control" placeholder="Seleccione la fecha" id="f_edit_fecha"/>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-success" id="btn_editar_asesor" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
      </div>
    </form>
    `);
    $("#f_edit_fecha").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });

    $(document).ready(function() {
        $('#f_edit_persona').select2();
    });
    cargarSelectEdit();

  let arrayID = buscarPorID(data);
  $("#f_edit_persona").val(arrayID.id_persona);
  $("#f_edit_funcion").val(arrayID.funcion);
  $("#f_edit_fecha").val(arrayID.fecha_ingreso);
};

function borrar(data) {
  let arrayID = buscarPorID(data);
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea borrar el asesor: ${arrayID.id_asesor}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoBorrar(${data})">Sí</button>
    `);
};

/*function activar(data) {
  let arrayID = buscarPorID(data);
  let estado = "";
  if (arrayID.activo == 0) {
    estado = "activar"
  }else {
    estado = "desactivar"
  }
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea ${estado} el campo ${arrayID.valor_de_rubro}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};*/

/*function cargarSelect() {
  $('#f_select2').empty();
  $('#f_select2').append('<option disabled selected value="0">Seleccione una opción</option>');
  $('#f_select2').append('<option value="n">Nueva rubro</option>');
  var $f_select2 = $('#f_select2');
  $.each(g__VariableGlobalSelect, function(key, value) {/////////////aquí se inserta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_select2.append('<option value="'+value.id_rubro+'">'+value.rubro+'</option>');/////////////Nombre de los campos a mostrar/////////////
    }
  });
}*/

function cargarSelect() {
  $('#f_persona').empty();
  $('#f_persona').append('<option disabled selected value="null">Seleccione una opción</option>');
  var $f_persona = $('#f_persona');
  $.each(g__persona, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    //if (value.activo == 1) {
      $f_persona.append('<option value="'+value.id_persona+'">'+value.nombre+" "+value.primer_apellido+" "+value.segundo_apellido+'</option>');
  //  }
  });
}
function cargarSelectEdit() {
  $('#f_edit_persona').empty();
  $('#f_edit_persona').append('<option disabled selected value="null">Seleccione una opción</option>');
  var $f_edit_persona = $('#f_edit_persona');
  $.each(g__persona, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_edit_persona.append('<option value="'+value.id_persona+'">'+value.nombre+" "+value.primer_apellido+" "+value.segundo_apellido+'</option>');
    }
  });
}
//-----------------------End Eventos del formulario-----------------------//

//-----------------------Funciones de ejecucion-----------------------//
function eventoResponse(r, tipo){
    if(r.code){
        notification(tipo,r.message,"success");
        return
    }
    notification(tipo,r.message,"error");
}
//-----------------------Funciones de ejecucion-----------------------//

//-----------------------Validaciones-----------------------//

//Obtiene los datos de la persona
function obtenerPersona(data){
  const found = g__persona.find(element => element.id_persona == data);
  return found;
}

//Valida que solo se puedan ingresar letras en el campo de nombre
function validarTexto(data) {
    //var regex = /^[a-zA-Z ]+$/;
    var regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
      return regex.test(data);

}

//Validar campos vacíos
function validarCampo(){
  if ($("#f_persona").val() == null || $("#f_fecha").val() == "" || $("#f_funcion").val() == ""  || validarTexto($('#f_funcion').val()) == false) {
    $( "#btn_agregar_asesor" ).prop( "disabled", true );
  }else {
    $( "#btn_agregar_asesor" ).prop( "disabled", false );
  }
}


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__asesor_datatables = $("#dt").DataTable({
    data: g__asesor,
    response: true,
    destroy: true,
    columns: [
      {data: "id_asesor"},
      {data: "id_persona",
      render: function(data){
        const found = g__persona.find(element => element.id_persona == data)
        return found.nombre+" "+found.primer_apellido+" "+found.segundo_apellido
      }
      },
      {data: "funcion"},
      {data: "fecha_ingreso"},
      /*{
        data: 'activo',
        render: function(data, type, row) {
          g__activo = data;
          switch (data) {
            case "1":
              return `<span class="badge badge-success">Activo</span>`;
              break;
            case "0":
              return `<span class="badge badge-danger">Desactivado</span>`;
              break;
            default:
              return "";
          }
        }
      },*/
      {
        data: "id_asesor",
        render:function (data) {
          return `
            <button class="btn btn-success" onclick="editar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_asesor"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger" onclick="borrar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_asesor"><i class="fas fa-ban"></i></i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//

    /*  {
        data: "id_asesor",/////////////cambiar/////////////
        render:function (data) {
          let icoactivo = "";
          let btn_disabled = "";
          let btn_color = "";
          if (g__activo == 1) {
            icoactivo = `<i class="fas fa-ban"></i>`;
            btn_disabled = "";
            btn_color = "btn-danger"
          }else { icoactivo = `<i class="fas fa-plus-circle"></i>`; btn_disabled = "disabled"; btn_color = "btn-primary"}
          return `
            <button class="btn btn-success" onclick="editar(${data})" ${btn_disabled} data-bs-toggle="modal" data-bs-target="#md_afectar_asesors"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn ${btn_color}" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_asesor">${icoactivo}</i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//
*/

function eventoCrear(obj){
    fetch('<?=PATH_API?>asesor/create.php', {
        method:'POST',
        body:JSON.stringify( obj )
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, 'Creación:')
    })
}

function eventoEditar(data){
    let value = generarObjetoEdit(data);
    fetch(`<?=PATH_API?>asesor/update.php?id_asesor=${data}`, {
        method:'POST',
        body:JSON.stringify(value)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, "Edición: ")
    })
}


function eventoBorrar(data){
    let value = generarObjetoEdit(data);
    fetch(`<?=PATH_API?>asesor/delete.php?id_asesor=${data}`, {
        method:'POST',
        body:JSON.stringify(value)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, "Borrado:")
    })
}
//-----------------------End Eventos de la base de datos-----------------------//




//-----------------------Funciones de carga remota. API, CONSULTAS EXTERNAS-----------------------//

function cargarAsesor(){
    return new Promise( resolve => {
        fetch('<?=PATH_API?>asesor/read.php')
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}

function cargarPersona(){
    return new Promise( resolve => {
        fetch('<?=PATH_API?>persona/read.php')
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}
