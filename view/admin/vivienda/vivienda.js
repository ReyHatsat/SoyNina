//-----------------------Variables grobales-----------------------//
let g__Vivienda = [];/////////////cambiar/////////////
let g__Vivienda_datatables = null;/////////////cambiar/////////////
let g__Active = 0;
//-----------------------End Variables grobales-----------------------//

//-----------------------init-----------------------//
init();

async function init() {
  await cargar();
}
//-----------------------init-----------------------//

//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto vivienda-----------------------//
  function generarObjeto() {
    return{
        descripcion_vivienda:$("#f_descripcion_vivienda").val(),
        ingresos_mensuales:$("#f_ingresos_mensuales").val(),
        descripcion_barrio:$("#f_descripcion_barrio").val(),
        active:1,

    }
  }

  function generarObjetoEdit(data){
    return {
        id_vivienda:data,/////////////cambiar/////////////
        descripcion_vivienda:$("#f_descripcion_vivienda_edit").val(),
        ingresos_mensuales:$("#f_ingresos_mensuales_edit").val(),
        descripcion_barrio:$("#f_descripcion_barrio_edit").val(),
        active:1,
    }
  };
  function generarObjetoViviendaActivar(data){
    let arrayID = buscarPorID(data);
    let activoTmp = "";
    if (arrayID.active == 0) {
      activoTmp = "1";
    }else {
      activoTmp = "0";
    }
    return {
      id_vivienda:arrayID.id_vivienda,
      descripcion_vivienda:arrayID.descripcion_vivienda,
      ingresos_mensuales:arrayID.ingresos_mensuales,
      descripcion_barrio:arrayID.descripcion_barrio,
      active:activoTmp,
    }
  }
  //-----------------------End Creación de objeto vivienda-----------------------//
//-----------------------End Creación de objeto-----------------------//


//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_nueva_vivienda").click(function(){
  $("#f_descripcion_vivienda").val("");
  $("#f_ingresos_mensuales").val("");
  $("#f_descripcion_barrio").val("");
});
$("#btn_agregar_nueva_vivienda").click(function(){
  eventoCrear();
  $("#f_descripcion_vivienda").val("");
  $("#f_ingresos_mensuales").val("");
  $("#f_descripcion_barrio").val("");
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Vivienda.find(element => element.id_vivienda == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {

  $("#contenedor_del_modal").html(`
      <label class="form-label">Descripción de la vivienda</label>
      <input type="text" class="form-control"/ id="f_descripcion_vivienda_edit">
      <label class="form-label">Ingresos mensuales</label>
      <input type="text" class="form-control"/ id="f_ingresos_mensuales_edit">
      <label class="form-label">Descripción del barrio</label>
      <input type="text" class="form-control"/ id="f_descripcion_barrio_edit"><br>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
  let arrayID = buscarPorID(data);
  $("#f_descripcion_vivienda_edit").val(arrayID.descripcion_vivienda);
  $("#f_ingresos_mensuales_edit").val(arrayID.ingresos_mensuales);
  $("#f_descripcion_barrio_edit").val(arrayID.descripcion_barrio);
}

function activar(data) {
  let arrayID = buscarPorID(data);/////////////cambiar el arrayID.xxx/////////////
  let estado = "";
  if (arrayID.active == 0) {
    estado = "activar"
  }else {
    estado = "desactivar"
  }
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea ${estado} la vivienda ${arrayID.descripcion_vivienda}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
//-------------------------------->>
//-----------------------End Eventos del formulario-----------------------//

//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__Vivienda_datatables = $("#dt_vivienda").DataTable({/////////////cambiar/////////////
    data: g__Vivienda,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_vivienda"},
      {data: "descripcion_vivienda"},
      {data: "ingresos_mensuales"},
      {data: "descripcion_barrio"},
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
        data: "id_vivienda",
        render:function (data) {
          let icoActive = "";
          if (g__Active == 1) {
            icoActive = `<i class="fas fa-ban"></i>`;
          }else { icoActive = `<i class="fas fa-plus-circle"></i>`}
          return `
            <button class="btn btn-success" onclick="editar(${data})" data-bs-toggle="modal" data-bs-target="#kt_modal_1"><i class="fas fa-pencil-alt"></i></button>
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
  request('<?=PATH_API?>vivienda/create.php', function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Creado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      //Fnon.Hint.Danger('Error updating your data', {position:'center-center'});
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}

function eventoEditar(data){
  let arrayID = buscarPorID(data);
  let value = generarObjetoEdit(data);
  if(!value){ return };
  request('<?=PATH_API?>vivienda/update.php?id_grado='+data, function(r){/////////////cambiar/////////////
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
  let value = generarObjetoViviendaActivar(data);
  if(!value){ return };
  request('<?=PATH_API?>vivienda/update.php?id_canton='+data, function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Editado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}


function cargar(){
  return request('<?=PATH_API?>vivienda/read.php?', function(r){
      g__Vivienda = r;/////////////cambiar/////////////
      g__Vivienda = g__Vivienda.data.records;/////////////cambiar/////////////
      renderDataTable();
    });
}
//-----------------------End Eventos de la base de datos-----------------------//
