//-----------------------Variables grobales-----------------------//
let g__registro_llamadas = [];
let g__registro_llamadas_datatables = [];
let g__persona = [];
let g__activo = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  g__registro_llamadas = await cargar();
  g__persona = await cargarPersona();
  g__registro_llamadas = g__registro_llamadas.document.records;
  g__persona = g__persona.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//

//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto medio transporte-----------------------//
  function generarObjeto(){
    return{
        id_persona:$("#f_persona").val(),
        fecha:$("#f_fecha").val(),
        estado:1,
    }
  }

  function generarObjetoEdit(data){
    return {
        id_registro:data,/////////////cambiar/////////////
        id_persona:$("#f_edit_persona").val(),
        fecha:$("#f_edit_fecha").val(),
        estado:1,
    }
  };

  function generarObjetoActivar(data){
    let arrayID = buscarPorID(data);
    let activoTmp = "";
    if (arrayID.estado == 0) {
      activoTmp = "1";
    }else {
      activoTmp = "0";
    }
    return {
        id_registro:arrayID.id_registro,
        id_persona:arrayID.id_persona,
        fecha:arrayID.fecha,
        estado:activoTmp,
      }
    };
  //-----------------------End Creación de objeto medio transporte-----------------------//
//-----------------------End Creación de objeto-----------------------//




//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_registro_llamadas").click(function(){
  $("#f_persona").val("null");
  $("#f_fecha").val("");
  $( "#btn_agregar_registro_llamadas" ).prop( "disabled", true );
});
$("#btn_agregar_registro_llamadas").click(function(){
  let obj = generarObjeto()
  eventoCrear(obj);
  $("#f_registro_llamadas").val("");
});
$("#btn_agregar_nuevo_registro_llamadas_modal").click(function(){
  cargarSelect();
});
$("#f_persona").change(function(){
  if ($("#f_persona").val() == null || $("#f_fecha").val() == "") {
    $( "#btn_agregar_registro_llamadas" ).prop( "disabled", true );
  }else {
    $( "#btn_agregar_registro_llamadas" ).prop( "disabled", false );
  }
});
$("#f_fecha").change(function(){
  if ($("#f_persona").val() == null || $("#f_fecha").val() == "") {
    $( "#btn_agregar_registro_llamadas" ).prop( "disabled", true );
  }else {
    $( "#btn_agregar_registro_llamadas" ).prop( "disabled", false );
  }
});
$("#f_fecha").flatpickr({
    enableTime: false,
    dateFormat: "Y-m-d",
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__registro_llamadas.find(element => element.id_registro == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $("#contenedor_del_modal").html(`
      <div class="modal-body">
      <label class="form-label">Persona</label>
        <select class="form-select js-example-basic-single" data-control="select2" id="f_edit_persona">
        </select>
        <label class="form-label">Fecha y hora</label>
        <input class="form-control" placeholder="Seleccione la fecha" id="f_edit_fecha"/>
      </div>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
    $("#f_edit_fecha").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
    /*$(document).ready(function() {
        $('#f_edit_persona').select2();
    });*/
    cargarSelectEdit();
    let arrayID = buscarPorID(data);
  $("#f_edit_persona").val(arrayID.id_persona);
  $("#f_edit_fecha").val(arrayID.fecha);
};
function activar(data) {
  let arrayID = buscarPorID(data);
  let estado = "";
  if (arrayID.estado == 0) {
    estado = "activar"
  }else {
    estado = "desactivar"
  }
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea ${estado} el registro llamadas con el ID ${arrayID.id_registro}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
function cargarSelect() {
  $('#f_persona').empty();
  $('#f_persona').append('<option disabled selected value="null">Seleccione una opción</option>');
  var $f_persona = $('#f_persona');
  $.each(g__persona, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_persona.append('<option value="'+value.id_persona+'">'+value.nombre+" "+value.primer_apellido+" "+value.segundo_apellido+'</option>');
    }
  });
  $('#f_edit_persona').select2();
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
  $('#f_edit_persona').select2();
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


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__registro_llamadas_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__registro_llamadas,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [
      {data: "id_registro"},
      {data: "id_persona",
      render: function(data){
        const found = g__persona.find(element => element.id_persona == data)
        return found.nombre+" "+found.primer_apellido+" "+found.segundo_apellido
      }
      },
      {data: "fecha"},
      {
        data: 'estado',
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
      },
      {
        data: "id_registro",/////////////cambiar/////////////
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
            <button class="btn btn-success" onclick="editar(${data})" ${btn_disabled} data-bs-toggle="modal" data-bs-target="#md_afectar_registro_llamadas"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn ${btn_color}" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_registro_llamadas">${icoactivo}</i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//


//-----------------------Funciones de carga remota. API, CONSULTAS EXTERNAS-----------------------//
function cargar(){
    return new Promise( resolve => {
        fetch('API/V1/registro_llamadas/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}

function cargarPersona(){
    return new Promise( resolve => {
        fetch('API/V1/persona/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}

function eventoCrear(obj){
    fetch('API/V1/registro_llamadas/create.php', {/////////////cambiar/////////////
        method:'POST',
        body:JSON.stringify(obj)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, 'Creado')
    })
}


function eventoEditar(data){
  let arrayID = buscarPorID(data);
  let value = generarObjetoEdit(data);
  if(!value){ return };

  fetch(`API/V1/registro_llamadas/update.php?id_registro=${data}`, {/////////////cambiar/////////////
      method:'POST',
      body:JSON.stringify(value)
  })
  .then( r => r.json() )
  .then( r => {
      init();
      eventoResponse(r, 'Edición')
  })
}



function eventoActivar(data) {
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  fetch(`API/V1/registro_llamadas/update.php?id_registro=${data}`, {/////////////cambiar/////////////
      method:'POST',
      body:JSON.stringify( value )
  })
  .then( r => r.json() )
  .then( r => {
      init();
      eventoResponse(r, 'Activación:')
  })
}
//-----------------------Funciones de carga remota. API, CONSULTAS EXTERNAS-----------------------//
