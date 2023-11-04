//-----------------------Variables grobales-----------------------//
let g__Ocupacion = [];/////////////cambiar/////////////
let g__Ocupacion_datatables = null;/////////////cambiar/////////////
//-----------------------End Variables grobales-----------------------//

//-----------------------init-----------------------//
init();

async function init() {
  await cargar();
}
//-----------------------init-----------------------//


//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto ocupacón-----------------------//
  function generarObjeto() {
    return {
        nombre_ocupacion:$("#f_nombre_ocupacion").val(),
        active:1,
    }
  };

  function generarObjetoEdit(data){
    return {
        id_ocupacion:data,/////////////cambiar/////////////
        nombre_ocupacion:$("#f_edit").val(),
        active:1,
      }
    };
  //-----------------------End Creación de objeto provincia-----------------------//
//-----------------------Creación de objeto-----------------------//


//-----------------------Eventos del formulario-----------------------//
$("#f_nombre_ocupacion").keyup(function() {
  if ($("#f_nombre_ocupacion").val() != "") {
    $("#btn_agregar_nueva_ocupacion").prop("disabled", false);
  }else {
    $("#btn_agregar_nueva_ocupacion").prop("disabled", true);
  }
});
$("#btn_cancelar_nueva_ocupacion").click(function() {
  $("#f_nombre_ocupacion").val(""),
  $("#btn_agregar_nueva_provincia").prop("disabled", true);
})
$("#btn_agregar_nueva_ocupacion").click(function() {
  eventoCrear();
  $("#f_nombre_ocupacion").val(""),
  $("#btn_agregar_nueva_ocupacion").prop("disabled", true);
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Ocupacion.find(element => element.id_ocupacion == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {

  $("#contenedor_del_modal").html(`
      <label class="form-label">Ocupación</label>
      <input type="text" class="form-control"/ id="f_edit"><br>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.nombre_ocupacion	);/////////////cambiar/////////////
}
function borrar(data) {
  let arrayID = buscarPorID(data);/////////////cambiar el arrayID.xxx/////////////
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea borrar ${arrayID.nombre_ocupacion	}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoBorrar(${data})">Borrar</button>
    `);
};
//-------------------------------->>
//-----------------------End Eventos del formulario-----------------------//


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__Ocupacion_datatables = $("#dt_ocupacion").DataTable({/////////////cambiar/////////////
    data: g__Ocupacion,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_ocupacion"},
      {data: "nombre_ocupacion"},
      {data: "active"},
      {
        data: "id_ocupacion",
        render:function (data) {
          return `
            <button class="btn btn-success" onclick="editar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger" onclick="borrar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-trash-alt"></i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//




//-----------------------Eventos de la base de datos-----------------------//

function eventoCrear(){
  let value = generarObjeto();
  if(!value){ return };
  request('<?=PATH_API?>ocupacion/create.php', function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Creado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}

function eventoEditar(data){
  let arrayID = buscarPorID(data);
  let value = generarObjetoEdit(data);
  if(!value){ return };
  request('<?=PATH_API?>ocupacion/update.php?id_ocupacion='+data, function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Editado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}

function eventoBorrar(data) {
  let value = {id_ocupacion:data}/////////////cambiar/////////////
  if(!value){ return };
  request('<?=PATH_API?>ocupacion/delete.php?', function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Borrado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}


function cargar(){
  return request('<?=PATH_API?>ocupacion/read.php?', function(r){
      g__Ocupacion = r;/////////////cambiar/////////////
      g__Ocupacion = g__Ocupacion.data.records;/////////////cambiar/////////////
      renderDataTable();
    });
}
//-----------------------End Eventos de la base de datos-----------------------//
