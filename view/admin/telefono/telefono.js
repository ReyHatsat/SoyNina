//-----------------------Variables grobales-----------------------//
let g__Telefono = [];/////////////cambiar/////////////
let g__Telefono_datatables = null;/////////////cambiar/////////////
let g__Active = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();

async function init() {
  await cargar();
}
//-----------------------init-----------------------//


//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto telefono-----------------------//
  function generarObjeto() {
    return{
        numero:$("#f_numero").val(),/////////////cambiar/////////////
        active:1,

    }
  }

  function generarObjetoEdit(data){
    return {
        id_telefono:data,/////////////cambiar/////////////
        numero:$("#f_edit").val(),
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
        id_telefono:arrayID.id_telefono,/////////////cambiar/////////////
        numero:arrayID.numero,
        active:activoTmp,
      }
    };

  //-----------------------End Creación de objeto telefono-----------------------//
//-----------------------End Creación de objeto-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_nuevo_telefono").click(function(){
  $("#f_numero").val("");
});
$("#btn_agregar_nuevo_telefono").click(function(){
  eventoCrear();
  $("#f_numero").val("");
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Telefono.find(element => element.id_telefono == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre del grado</label>
      <input type="text" class="form-control"/ id="f_edit">
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.numero);/////////////cambiar/////////////
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
      <p class="text-danger">¿Está seguro que desea ${estado} el numero ${arrayID.numero}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
//-------------------------------->>
//-----------------------End Eventos del formulario-----------------------//








//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__Telefono_datatables = $("#dt_telefono").DataTable({/////////////cambiar/////////////
    data: g__Telefono,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_telefono"},
      {data: "numero"},
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
        data: "id_telefono",
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
  request('<?=PATH_API?>telefono/create.php', function(r){/////////////cambiar/////////////
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
  request('<?=PATH_API?>telefono/update.php?id_grado='+data, function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Editado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}

function eventoActivar(data) {
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  request('<?=PATH_API?>telefono/update.php?id_telefono='+data, function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Editado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}


function cargar(){
  return request('<?=PATH_API?>telefono/read.php?', function(r){
      g__Telefono = r;/////////////cambiar/////////////
      g__Telefono = g__Telefono.data.records;/////////////cambiar/////////////
      renderDataTable();
    });
}
//-----------------------End Eventos de la base de datos-----------------------//
