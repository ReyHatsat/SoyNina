//-----------------------Variables grobales-----------------------//
let g__Tipo_detalle = [];
let g__Tipo_detalle_datatables
let g__Active = 0;
//-----------------------End Variables grobales-----------------------//

//-----------------------init-----------------------//
init();
async function init() {
  g__Tipo_detalle = await cargar();
  g__Tipo_detalle = g__Tipo_detalle.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//



//-----------------------Creación de objeto-----------------------//
  function generarObjeto(){
    return{
        tipo_detalle:$("#f_nombre_tipo_detalle").val(),
        activo:1,
    }
  }
  function generarObjetoEdit(data){
      return {
          id_tipo_detalle:data,/////////////cambiar/////////////
          tipo_detalle:$("#f_edit").val(),
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
          id_tipo_detalle:arrayID.id_tipo_detalle,/////////////cambiar/////////////
          tipo_detalle:arrayID.tipo_detalle,/////////////cambiar/////////////
          activo:activoTmp,
        }
      };
//-----------------------End Creación de objeto-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_tipo_detalle").click(function(){
  $("#f_nombre_tipo_detalle").val("");
});
$("#btn_agregar_tipo_detalle").click(function(){
  let obj = generarObjeto()
  eventoCrear(obj);
  $("#f_nombre_tipo_detalle").val("");
});
$("#f_nombre_tipo_detalle").keyup(function(){
  if ($("#f_nombre_tipo_detalle").val() == "") {
    $( "#btn_agregar_tipo_detalle" ).prop( "disabled", true );
  }else {
    $( "#btn_agregar_tipo_detalle" ).prop( "disabled", false );
  }
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Tipo_detalle.find(element => element.id_tipo_detalle == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre del tipo de detalle</label>
      <input type="text" class="form-control"/ id="f_edit">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.tipo_detalle);/////////////cambiar/////////////
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
      <p class="text-danger">¿Está seguro que desea ${estado} el tipo de detalle: ${arrayID.tipo_detalle}?</p>
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
  g__Tipo_detalle_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__Tipo_detalle,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_tipo_detalle"},
      {data: "tipo_detalle"},
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
        data: "id_tipo_detalle",
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
        fetch('API/V1/tipo_detalle/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}


function eventoCrear(obj){
    fetch('API/V1/tipo_detalle/create.php', {/////////////cambiar/////////////
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
    fetch(`API/V1/tipo_detalle/update.php?id_tipo_detalle=${data}`, {/////////////cambiar/////////////
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
  fetch(`API/V1/tipo_detalle/update.php?id_tipo_detalle=${data}`, {/////////////cambiar/////////////
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
