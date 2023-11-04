//-----------------------Variables grobales-----------------------//
let g__Pais = [];
let g__Pais_datatables = [];
let g__activo = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  g__Pais = await cargar();
  g__Pais = g__Pais .document.records;
  renderDataTable();
}
//-----------------------init-----------------------//

//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto medio transporte-----------------------//
  function generarObjeto(){
    return{
        nombre:$("#f_pais").val(),/////////cambiar
        nacionalidad:$("#f_nacionalidad").val(),/////////cambiar
        activo:1,
    }
  }

  function generarObjetoEdit(data){
    return {
        id_pais:data,
        nombre:$("#f_edit_pais").val(),/////////cambiar
        nacionalidad:$("#f_edit_nacionalidad").val(),/////////cambiar
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
        id_pais:arrayID.id_pais,
        nombre:arrayID.nombre,
        nacionalidad:arrayID.nombre,
        activo:activoTmp,
      }
    };
  //-----------------------End Creación de objeto medio transporte-----------------------//
//-----------------------End Creación de objeto-----------------------//




//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_pais").click(function(){
  $("#f_campo").val("");
});
$("#btn_agregar_nuevo_pais").click(function(){
  let obj = generarObjeto()
  console.log(obj);
  eventoCrear(obj);
  $("#f_campo").val("");
});
$("#f_pais").keyup(function(){/////////////cambiar/////////////
  if ($("#f_pais").val() == "") {
    $("#d_nacionalidad").addClass("d-none");
  }else {
    $("#d_nacionalidad").removeClass("d-none");
  }
});
$("#f_nacionalidad").keyup(function(){/////////////cambiar/////////////
  if ($("#f_nacionalidad").val() == "" || $("#f_pais").val() == "") {
    $( "#btn_agregar_nuevo_pais" ).prop( "disabled", true );/////////////cambiar/////////////
  }else {
    $( "#btn_agregar_nuevo_pais" ).prop( "disabled", false );/////////////cambiar/////////////
  }
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Pais.find(element => element.id_pais == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {/////////////cambiar/////////////
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre del país</label>
      <input type="text" class="form-control"/ id="f_edit_pais">
      <label class="form-label">Nacionalidad</label>
      <input type="text" class="form-control"/ id="f_edit_nacionalidad">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit_pais").val(arrayID.nombre);/////////////cambiar/////////////
  $("#f_edit_nacionalidad").val(arrayID.nacionalidad);/////////////cambiar/////////////
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
      <p class="text-danger">¿Está seguro que desea ${estado} el país ${arrayID.nombre}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
//-----------------------End Eventos del formulario-----------------------//

//-----------------------Funciones de ejecucion-----------------------//
function eventoResponse(r, tipo){
    if(r.code){
        notification(tipo,r.msg,"success");
        return
    }
    notification(tipo,r.msg,"error");
}
//-----------------------Funciones de ejecucion-----------------------//


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__Pais_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__Pais,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_pais"},/////////////cambiar/////////////
      {data: "nombre"},/////////////cambiar/////////////
      {data: "nacionalidad"},/////////////cambiar/////////////
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
        data: "id_pais",/////////////cambiar/////////////
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
            <button class="btn btn-success" onclick="editar(${data})" ${btn_disabled} data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn ${btn_color}" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo">${icoactivo}</i></button>
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
        fetch('API/V1/pais/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}


function eventoCrear(obj){
    fetch('API/V1/pais/create.php', {/////////////cambiar/////////////
        method:'POST',
        body:JSON.stringify( obj )
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

  fetch(`API/V1/pais/update.php?id_campo=${data}`, {/////////////cambiar/////////////
      method:'POST',
      body:JSON.stringify(value)
  })
  .then( r => r.json() )
  .then( r => {
      init();
      eventoResponse(r, 'Editado')
  })
}



function eventoActivar(data) {
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  fetch(`API/V1/pais/update.php?id_campo=${data}`, {/////////////cambiar/////////////
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
    fetch(`API/V1/pais/delete.php?id_campo=${data}`, {/////////////cambiar/////////////
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
