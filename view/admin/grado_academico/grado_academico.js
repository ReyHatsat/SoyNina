//-----------------------Variables grobales-----------------------//
let g__grado_academico = [];
let g__grado_academico_datatables
let g__Active = 0;
//-----------------------End Variables grobales-----------------------//

//-----------------------init-----------------------//
init();
async function init() {
  g__grado_academico = await cargar();
  g__grado_academico = g__grado_academico.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//



//-----------------------Creación de objeto-----------------------//
  function generarObjeto(){
    return{
        grado_academico:$("#f_nombre_grado_academico").val(),
        activo:1,
    }
  }
  function generarObjetoEdit(data){
      return {
          id_grado_academico:data,/////////////cambiar/////////////
          grado_academico:$("#f_edit").val(),
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
          id_grado_academico:arrayID.id_grado_academico,/////////////cambiar/////////////
          grado_academico:arrayID.grado_academico,/////////////cambiar/////////////
          activo:activoTmp,
        }
      };
//-----------------------End Creación de objeto-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_grado_academico").click(function(){
  $("#f_nombre_grado_academico").val("");
});
$("#btn_agregar_grado_academico").click(function(){
  let obj = generarObjeto()
  eventoCrear(obj);
  $("#f_nombre_grado_academico").val("");
});
$("#f_nombre_grado_academico").keyup(function(){/////////////cambiar/////////////
  if ($("#f_nombre_grado_academico").val() == "") {
    $( "#btn_agregar_grado_academico" ).prop( "disabled", true );/////////////cambiar/////////////
  }else {
    $( "#btn_agregar_grado_academico" ).prop( "disabled", false );/////////////cambiar/////////////
  }
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__grado_academico.find(element => element.id_grado_academico == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre del grado_academico</label>
      <input type="text" class="form-control"/ id="f_edit">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.grado_academico);/////////////cambiar/////////////
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
      <p class="text-danger">¿Está seguro que desea ${estado} el grado académico: ${arrayID.grado_academico}?</p>
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
  g__grado_academico_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__grado_academico,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_grado_academico"},
      {data: "grado_academico"},
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
        data: "id_grado_academico",
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
        fetch('API/V1/grado_academico/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}


function eventoCrear(obj){
    fetch('API/V1/grado_academico/create.php', {/////////////cambiar/////////////
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
    fetch(`API/V1/grado_academico/update.php?id_grado_academico=${data}`, {/////////////cambiar/////////////
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
  fetch(`API/V1/grado_academico/update.php?id_grado_academico=${data}`, {/////////////cambiar/////////////
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
