//-----------------------Variables grobales-----------------------//
let g__tipo_ocupacion = [];
let g__tipo_ocupacion_datatables
let g__Active = 0;
//-----------------------End Variables grobales-----------------------//

//-----------------------init-----------------------//
init();
async function init() {
  g__tipo_ocupacion = await cargar();
  g__tipo_ocupacion = g__tipo_ocupacion.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//



//-----------------------Creación de objeto-----------------------//
  function generarObjeto(){
    return{
        tipo_ocupacion:$("#f_nombre_tipo_ocupacion").val(),
        activo:1,
    }
  }
  function generarObjetoEdit(data){
      return {
          id_tipo_ocupacion:data,/////////////cambiar/////////////
          tipo_ocupacion:$("#f_edit").val(),
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
          id_tipo_ocupacion:arrayID.id_tipo_ocupacion,/////////////cambiar/////////////
          tipo_ocupacion:arrayID.tipo_ocupacion,/////////////cambiar/////////////
          activo:activoTmp,
        }
      };
//-----------------------End Creación de objeto-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_tipo_ocupacion").click(function(){
  $("#f_nombre_tipo_ocupacion").val("");
});
$("#btn_agregar_tipo_ocupacion").click(function(){
  let obj = generarObjeto()
  eventoCrear(obj);
  $("#f_nombre_tipo_ocupacion").val("");
});
$("#f_nombre_tipo_ocupacion").keyup(function(){/////////////cambiar/////////////
  if ($("#f_nombre_tipo_ocupacion").val() == "") {
    $( "#btn_agregar_tipo_ocupacion" ).prop( "disabled", true );/////////////cambiar/////////////
  }else {
    $( "#btn_agregar_tipo_ocupacion" ).prop( "disabled", false );/////////////cambiar/////////////
  }
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__tipo_ocupacion.find(element => element.id_tipo_ocupacion == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre del tipo de ocupación</label>
      <input type="text" class="form-control"/ id="f_edit">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.tipo_ocupacion);/////////////cambiar/////////////
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
      <p class="text-danger">¿Está seguro que desea ${estado} el tipo de ocupación: ${arrayID.tipo_ocupacion}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
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
  g__tipo_ocupacion_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__tipo_ocupacion,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_tipo_ocupacion"},
      {data: "tipo_ocupacion"},
      {
        data: 'activo',
        render: function(data, type, row) {
          g__Active = data;
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
        data: "id_tipo_ocupacion",
        render:function (data) {
          let icoActive = "";
          let btn_disabled = "";
          let btn_color = "";
          if (g__Active == 1) {
            icoActive = `<i class="fas fa-ban"></i>`;
            btn_disabled = "";
            btn_color = "btn-danger"
          }else { icoActive = `<i class="fas fa-plus-circle"></i>`; btn_disabled = "disabled"; btn_color = "btn-primary"}
          return `
            <button class="btn btn-success" onclick="editar(${data})" ${btn_disabled} data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn ${btn_color}" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo">${icoActive}</i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//


//-----------------------Eventos de la base de datos-----------------------//
function cargar(){
    return new Promise( resolve => {
        fetch('API/V1/tipo_ocupacion/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}


function eventoCrear(obj){
    fetch('API/V1/tipo_ocupacion/create.php', {/////////////cambiar/////////////
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
    fetch(`API/V1/tipo_ocupacion/update.php?id_tipo_ocupacion=${data}`, {/////////////cambiar/////////////
        method:'POST',
        body:JSON.stringify(value)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, "Edición:")
    })
}



function eventoActivar(data) {
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  fetch(`API/V1/tipo_ocupacion/update.php?id_tipo_ocupacion=${data}`, {/////////////cambiar/////////////
      method:'POST',
      body:JSON.stringify( value )
  })
  .then( r => r.json() )
  .then( r => {
      init();
      eventoResponse(r, 'Activación:')
  })
}
//-----------------------End Eventos de la base de datos-----------------------//
