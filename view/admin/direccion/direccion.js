//-----------------------Variables grobales-----------------------//
let g__Direccion = [];
let g__Direccion_datatables  = [];
let g__Distrito = [];
let g__DistritoOne = [];
let g__Canton = [];
let g__Provincia = [];
let g__Active = 0;
//-----------------------Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  cargarDireccion();
}
//-----------------------init-----------------------//


//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto direccion-----------------------//
  function generarObjeto(){
    return {
        id_distrito:$("#f_distrito").val(),
        otras_senas:$("#f_otras_senas").val(),
        active:1,
    }
  }
  //-----------------------End Creación de objeto direccion-----------------------//

  //-----------------------Creación de objeto direccion editar-----------------------//
    function generarObjetoEdit(data){
      return {
          id_direccion:data,
          id_distrito:$("#f_distrito").val(),
          otras_senas:$("#f_otras_senas").val(),
          active:1,
      }
    };
  //-----------------------End Creación de objeto direccion editar-----------------------//


    //-----------------------Creación de objeto direccion activar-----------------------//
      function generarObjetoActivar(data){
        let arrayID = buscarPorID(data);
        let activoTmp = "";
        if (arrayID.active == 0) {
          activoTmp = "1";
        }else {
          activoTmp = "0";
        }
        return {
            id_direccion:arrayID.id_direccion,
            id_distrito:arrayID.id_distrito,
            otras_senas:arrayID.otras_senas,
            active:activoTmp,
        }
      };
    //-----------------------End Creación de objeto direccion editar-----------------------//
  //-----------------------End Creación de objeto direccion-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_agregar_nueva_direccion_modal").click(function () {
  $("#d_botones_nuevo").removeClass("d-none");
  $("#titulo_nueva_direccion").removeClass("d-none");
  $("#d_botones_editar").addClass("d-none");
  $("#titulo_editar_direccion").addClass("d-none");
  cargarProvincia();
  $("#f_distrito").val(0);
  $("#f_canton").val(0);
  $("#f_provincia").val(0);
  $("#d_distrito").addClass("d-none");
  $("#d_canton").addClass("d-none");
  $("#f_otras_senas").val("");
  $("#btn_agregar_nueva_direccion").prop( "disabled", true );
})
$("#f_provincia").change(function(){
  cargarCanton(parseInt($("#f_provincia").val()));
  $("#d_canton").removeClass("d-none");
  $("#d_distrito").addClass("d-none");
});
$("#f_canton").click(function(){
  cargarDistritoOne(parseInt($("#f_canton").val()))
  $("#d_distrito").removeClass("d-none");
});
$("#f_otras_senas").keyup(function () {
  if ($("#f_otras_senas").val() != "" && $("#f_distrito").val() > 0) {
    $("#btn_editar_si").prop( "disabled", false );
    $("#btn_agregar_nueva_direccion").prop( "disabled", false );
  }else {
    $("#btn_agregar_nueva_direccion").prop( "disabled", true );
    $("#btn_agregar_nueva_direccion").prop( "disabled", true );
  }
})
$("#btn_calcelar_nueva_direccion").click(function(){
  $("#f_direccion").val(0);
  $("#f_provincia").val(0);
  $("#f_canton").val(0);
  $("#f_otras_senas").val("");
  $("#d_canton").addClass("d-none");
  $("#d_distrito").addClass("d-none");
});

$("#btn_agregar_nueva_direccion").click(function(){
  eventoCrear();
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Direccion.find(element => element.id_direccion == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {
  $('#btn_agregar_nueva_direccion_modal').trigger('click');
  let arrayID = buscarPorID(data);
  console.log(arrayID);
  $("#d_botones_editar").removeClass("d-none");
  $("#titulo_editar_direccion").removeClass("d-none");
  $("#d_botones_nuevo").addClass("d-none");
  $("#titulo_nueva_direccion").addClass("d-none");
  $("#d_botones_editar").html(`
      <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_editar_no">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})" id="btn_editar_si" disabled>Editar</button>
    `);
  $("#f_otras_senas").val(arrayID.otras_senas);/////////////cambiar/////////////
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
      <p class="text-danger">¿Está seguro que desea ${estado} la dirección ${arrayID.otras_senas}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
//-------------------------------->>
//-----------------------End Eventos del formulario-----------------------//


//-----------------------DataTables-----------------------//
function renderDireccionDataTables() {
  g__Direccion_datatables = $("#dt_direccion").DataTable({
    data: g__Direccion,
    response: true,
    destroy: true,
    columns: [
      {data: "id_direccion"},
      {data: "id_distrito"},
      {data: "otras_senas"},
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
        data: "id_direccion",
        render:function (data) {
          let icoActive = "";
          if (g__Active == 1) {
            icoActive = `<i class="fas fa-ban"></i>`;
          }else { icoActive = `<i class="fas fa-plus-circle"></i>`}
          return `
            <button class="btn btn-success" onclick="editar(${data})"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_campo">${icoActive}</i></button>
          `
        }
      },
    ]
  });
}
//-----------------------End DataTables-----------------------//

//-----------------------Eventos de la base de datos-----------------------//


function eventoCrear(){
  let value = generarObjeto();
  if(!value){ return };
  request('<?=PATH_API?>direccion/create.php', function(r){/////////////cambiar/////////////
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
  request('<?=PATH_API?>direccion/update.php?id_direccion='+data, function(r){/////////////cambiar/////////////
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
  request('<?=PATH_API?>direccion/update.php?id_direccion='+data, function(r){/////////////cambiar/////////////
    if(r.code){
      notification("Editado",r.msg,"success");
      setTimeout(function(){ init(); }, 50);
    }else{
      notification("Error",r.msg,"error");
    }
  }, { data:value })
}



function cargarDireccion(){
  return request('<?=PATH_API?>direccion/read.php?', function(r){
      g__Direccion = r;
      g__Direccion = g__Direccion.data.records;
      renderDireccionDataTables();
    });
}

function cargarProvincia(){
  return request('<?=PATH_API?>provincia/read.php?', function(r){
      g__Provincia = r;/////////////cambiar/////////////
      g__Provincia = g__Provincia.data.records;/////////////cambiar/////////////
      var $f_provincia = $('#f_provincia');
      $.each(g__Provincia, function(key, value) {
        var $option = $("<option/>", {
          value: key,
          text: value.nombre_provincia/*+" - "+value.nombre_provincia*/,
        });
        $f_provincia.append('<option value="'+value.id_provincia+'">'+value.nombre_provincia+'</option>');
      });
       g__Canton = [];
    });
}


function cargarCanton(id){
  $('#f_canton').empty();
  return request('<?=PATH_API?>canton/read_by_id_provincia.php?id_provincia='+id, function(r){
      g__Canton = r;/////////////cambiar/////////////
      g__Canton = g__Canton.data.records;/////////////cambiar/////////////
      var $f_canton = $('#f_canton');
      $.each(g__Canton, function(key, value) {
        $f_canton.append("");
        var $option = $("<option/>", {
          value: key,
          text: value.nombre_canton/*+" - "+value.nombre_provincia*/,
        });
        $f_canton.append('<option value="'+value.id_canton+'">'+value.nombre_canton+'</option>');
      });
    });
}


function cargarDistritoOne(id){
  $("#f_distrito").empty();
  return request('<?=PATH_API?>distrito/read_by_id_canton.php?id_canton='+id, function(r){
      g__DistritoOne = r;/////////////cambiar/////////////
      g__DistritoOne = g__DistritoOne.data.records;/////////////cambiar/////////////
      var $f_distrito = $('#f_distrito');
      $.each(g__DistritoOne, function(key, value) {
        var $option = $("<option/>", {
          value: key,
          text: value.nombre_distrito+" - "+value.nombre_canton,
        });
        $f_distrito.append('<option value="'+value.id_distrito+'">'+value.nombre_distrito+'</option>');
      });
    });
}
//-----------------------End Eventos de la base de datos-----------------------//
