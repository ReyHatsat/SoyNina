//-----------------------Variables grobales-----------------------//
let g__equipo = [];
let g__equipo_datatables
let g__Active = 0;
//-----------------------End Variables grobales-----------------------//

//-----------------------init-----------------------//
init();
async function init() {
  g__equipo = await cargar();
  g__equipo = g__equipo.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//



//-----------------------Creación de objeto-----------------------//
  function generarObjeto(){
    return{
        nombre:$("#f_nombre_equipo").val(),
    }
  }
  function generarObjetoEdit(data){
      return {
          id_equipo:data,/////////////cambiar/////////////
          nombre:$("#f_edit").val(),
      }
    };
//-----------------------End Creación de objeto-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_equipo").click(function(){
  $("#f_nombre_equipo").val("");
});
$("#btn_agregar_equipo").click(function(){
  let obj = generarObjeto()
  eventoCrear(obj);
  $("#f_nombre_equipo").val("");
});
$("#f_nombre_equipo").keyup(function(){/////////////cambiar/////////////
  if ($("#f_nombre_equipo").val() == "") {
    $( "#btn_agregar_equipo" ).prop( "disabled", true );/////////////cambiar/////////////
  }else {
    $( "#btn_agregar_equipo" ).prop( "disabled", false );/////////////cambiar/////////////
  }
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__equipo.find(element => element.id_equipo == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre equipo</label>
      <input type="text" class="form-control"/ id="f_edit">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.nombre);/////////////cambiar/////////////
};
function borrar(data) {
  let arrayID = buscarPorID(data);/////////////cambiar el arrayID.xxx/////////////
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea borrar el tipo de persona: ${arrayID.nombre}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoBorrar(${data})">Sí</button>
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
  g__equipo_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__equipo,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_equipo"},
      {data: "nombre"},
      {
        data: "id_equipo",
        render:function (data) {
          return `
            <button class="btn btn-success" onclick="editar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger" onclick="borrar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-ban"></i></i></button>
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
        fetch('API/V1/equipo/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}


function eventoCrear(obj){
    fetch('API/V1/equipo/create.php', {/////////////cambiar/////////////
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
    fetch(`API/V1/equipo/update.php?id_equipo=${data}`, {/////////////cambiar/////////////
        method:'POST',
        body:JSON.stringify(value)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, "Edición:")
    })
}


function eventoBorrar(data){
    let value = generarObjetoEdit(data);
    fetch(`API/V1/equipo/delete.php?id_equipo=${data}`, {/////////////cambiar/////////////
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
