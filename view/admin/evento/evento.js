//-----------------------Variables grobales-----------------------//
let g__evento = [];
let g__evento_datatables = [];
let g__tipo_evento = [];
let g__tipo_evento_datatables = [];
let g__activo = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  g__evento = await cargar();
  g__tipo_evento = await cargarTipoEvento()
  g__evento = g__evento.document.records;
  g__tipo_evento = g__tipo_evento.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//

//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto medio transporte-----------------------//
  function generarObjeto(){
    return{
        id_tipo_evento:$("#f_select_evento").val(),
        nombre:$("#f_evento").val(),
        activo:1,
    }
  }

  function generarObjetoEdit(data){
    return {
        id_evento:data,/////////////cambiar/////////////
        id_tipo_evento:$("#f_select_evento_edit").val(),
        nombre:$("#f_evento_edit").val(),
        activo:1,
    }
  };

  function generarObjetoActivar(data){
    let arrayID = buscarPorID(data);
    let activoTmp = "";
    if (arrayID.activo == 0) {
      activoTmp = "1";
    }else {
      activoTmp = "0";
    }
    return {
        id_tipo_evento:data,
        id_evento:arrayID.id_evento,/////////////cambiar/////////////
        nombre:arrayID.nombre,/////////////cambiar/////////////
        activo:activoTmp,
      }
    };
  //-----------------------End Creación de objeto medio transporte-----------------------//
//-----------------------End Creación de objeto-----------------------//




//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_evento").click(function(){
  $("#f_evento").val("");
});
$("#btn_agregar_evento").click(function(){
  let obj = generarObjeto();
  eventoCrear(obj);
  $("#f_evento").val("");
});
$("#btn_agregar_nuevo_evento_modal").click(function(){
  cargarSelect();
});
$("#f_evento").keyup(function(){/////////////cambiar/////////////
  if ($("#f_evento").val() == "") {
    $( "#btn_agregar_evento" ).prop( "disabled", true );/////////////cambiar/////////////
  }else {
    $( "#btn_agregar_evento" ).prop( "disabled", false );/////////////cambiar/////////////
  }
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__evento.find(element => element.id_evento == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {/////////////cambiar/////////////
  $("#contenedor_del_modal").html(`
    <label class="form-label">Tipo de evento</label>
      <select class="form-select" data-control="select2" data-placeholder="Select an option" id="f_select_evento_edit">
      </select>
      <label class="form-label">Nombre del evento</label>
      <input type="text" class="form-control"/ id="f_evento_edit">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  cargarSelectEdit();
  let arrayID = buscarPorID(data);
  $("#f_select_evento_edit").val(arrayID.id_tipo_evento);
  $("#f_evento_edit").val(arrayID.nombre);
};
function activar(data) {
  let arrayID = buscarPorID(data);/////////////cambiar el arrayID.xxx/////////////
  let estado = "";
  if (arrayID.activo == 0) {
    estado = "activar"
  }else {
    estado = "desactivar"
  }
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea ${estado} el evento ${arrayID.nombre}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
function cargarSelect() {
  $('#f_select_evento').empty();
  $('#f_select_evento').append('<option disabled selected value="null">Seleccione una opción</option>');
  //$('#f_select_evento').append('<option value="n">Nueva evento</option>');
  var $f_select_evento = $('#f_select_evento');
  $.each(g__tipo_evento, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_select_evento.append('<option value="'+value.id_evento+'">'+value.tipo+'</option>');/////////////Nome de los eventos a mostrar/////////////
    }
  });
}
function cargarSelectEdit() {
  $('#f_select_evento_edit').empty();
  $('#f_select_evento_edit').append('<option disabled selected value="null">Seleccione una opción</option>');
  //$('#f_select_evento').append('<option value="n">Nueva evento</option>');
  var $f_select_evento_edit = $('#f_select_evento_edit');
  $.each(g__tipo_evento, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_select_evento_edit.append('<option value="'+value.id_evento+'">'+value.tipo+'</option>');/////////////Nome de los eventos a mostrar/////////////
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


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__evento_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__evento,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_evento"},/////////////cambiar/////////////
      {
        data: 'id_tipo_evento',
        render: function(data){
            const found = g__tipo_evento.find(element => element.id_evento == data);/////////////cambiar/////////////
            return found.tipo;
        }

      },
      {data: 'nombre'},
      {
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
      },
      {
        data: "id_evento",/////////////cambiar/////////////
        render:function (data) {
          let icoactivo = "";
          let btn_disabled = "";
          let btn_color = "";
          if (g__activo == 1) {
            icoactivo = `<i class="fas fa-ban"></i>`;
            btn_oculto = "";
            btn_color = "btn-danger";
          }else { icoactivo = `<i class="fas fa-plus-circle"></i>`; btn_oculto = "d-none"; btn_color = "btn-primary"}
          return `
            <button class="btn btn-success ${btn_oculto}" onclick="editar(${data})"  data-bs-toggle="modal" data-bs-target="#md_afectar_evento"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn ${btn_color}" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_evento">${icoactivo}</i></button>
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
        fetch('API/V1/evento/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}

function cargarTipoEvento(){
    return new Promise( resolve => {
        fetch('API/V1/tipo_evento/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}


function eventoCrear(obj){
    fetch('API/V1/evento/create.php', {/////////////cambiar/////////////
        method:'POST',
        body:JSON.stringify(obj)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, 'Creación:')
    })
}


function eventoEditar(data){
  let arrayID = buscarPorID(data);
  let value = generarObjetoEdit(data);
  if(!value){ return };

  fetch(`API/V1/evento/update.php?id_evento=${data}`, {/////////////cambiar/////////////
      method:'POST',
      body:JSON.stringify(value)
  })
  .then( r => r.json() )
  .then( r => {
      init();
      eventoResponse(r, 'Edición:')
  })
}



function eventoActivar(data) {
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  fetch(`API/V1/evento/update.php?id_evento=${data}`, {/////////////cambiar/////////////
      method:'POST',
      body:JSON.stringify( value )
  })
  .then( r => r.json() )
  .then( r => {
      init();
      eventoResponse(r, 'Activación:')
  })
}


function eventoBorrar(data){
    let value = generarObjetoEdit(data);
    fetch(`API/V1/evento/delete.php?id_evento=${data}`, {/////////////cambiar/////////////
        method:'POST',
        body:JSON.stringify(value)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, "Borrado:")
    })
}
//-----------------------Funciones de carga remota. API, CONSULTAS EXTERNAS-----------------------//
