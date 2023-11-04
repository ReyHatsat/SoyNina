//-----------------------Variables grobales-----------------------//
let g__Provincia = [];/////////////cambiar/////////////
let g__Provincia_datatables = null;/////////////cambiar/////////////
let g__Active = 0;
//-----------------------End Variables grobales-----------------------//

//-----------------------init-----------------------//
init();

async function init() {
  await cargar();
}
//-----------------------init-----------------------//


//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto provincia-----------------------//
  function generarObjeto() {
    return {
        nombre_provincia:$("#f_nombre_provincia").val(),
        active:1,
    }
  }

  function generarObjetoEdit(data){
    return {
        /////////////cambiar/////////////
        id_provincia:data,
        nombre_provincia:$("#f_edit").val(),
        active:1,
      }
    };

  function generarObjetoActivar(data){
    let arrayID = buscarPorID(data);
    let activoTmp = "";
    if (arrayID.active == 0) {
      activoTmp = "1";
    }else {
      activoTmp = "0";
    }
    return {
        /////////////cambiar/////////////
        id_provincia:arrayID.id_provincia,
        nombre_provincia:arrayID.nombre_provincia,
        active:activoTmp,
      }
    };
  //-----------------------End Creación de objeto provincia-----------------------//
//-----------------------Creación de objeto-----------------------//


//-----------------------Eventos del formulario-----------------------//
$("#f_nombre_provincia").keyup(function() {
  if ($("#f_nombre_provincia").val() != "") {
    $("#btn_agregar_nueva_provincia").prop("disabled", false);
  }else {
    $("#btn_agregar_nueva_provincia").prop("disabled", true);
  }
});
$("#btn_cancelar_nueva_provincia").click(function() {
  $("#f_nombre_provincia").val(""),
  $("#btn_agregar_nueva_provincia").prop("disabled", true);
})
$("#btn_agregar_nueva_provincia").click(function() {
  eventoCrear();
  $("#f_nombre_provincia").val(""),
  $("#btn_agregar_nueva_provincia").prop("disabled", true);
})
function buscarPorID(data) {
  const found = g__Provincia.find(element => element.id_provincia == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre de la provincia</label>
      <input type="text" class="form-control"/ id="f_edit">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.nombre_provincia);/////////////cambiar/////////////
};
function activar(data) {
  let arrayID = buscarPorID(data);/////////////cambiar el arrayID.xxx/////////////
  let estado = "";
  if (arrayID.active == 0) {
    estado = "activar"
  }else {
    estado = "desactivar"
  }
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea ${estado} la dirección ${arrayID.nombre_provincia}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
//-----------------------End Eventos del formulario-----------------------//


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__Provincia_datatables = $("#dt_provincia").DataTable({/////////////cambiar/////////////
    data: g__Provincia,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_provincia"},
      {data: "nombre_provincia"},
      {
        data: 'active',
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
        data: "id_provincia",
        render:function (data) {
          let icoActive = "";
          if (g__Active == 1) {
            icoActive = `<i class="fas fa-ban"></i>`;
          }else { icoActive = `<i class="fas fa-plus-circle"></i>`}
          return `
            <button class="btn btn-success" onclick="editar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo">${icoActive}</i></button>
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
  request('<?=PATH_API?>provincia/create.php', function(r){/////////////cambiar/////////////
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
  request('<?=PATH_API?>provincia/update.php?id_grado='+data, function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Editado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}

function eventoActivar(data){
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  request('<?=PATH_API?>provincia/update.php?id_provincia='+data, function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Editado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}


function cargar(){
  return request('<?=PATH_API?>provincia/read.php?', function(r){
      g__Provincia = r.data.records;;/////////////cambiar/////////////
      renderDataTable();
    });
}
//-----------------------End Eventos de la base de datos-----------------------//
