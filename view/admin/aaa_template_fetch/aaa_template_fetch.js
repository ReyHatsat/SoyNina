//-----------------------Variables grobales-----------------------//
let g__Campo = [];
let g__Campo_datatables = [];
let g__activo = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  g__Campo = await cargar();
  g__Campo = g__Campo.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//

//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto medio transporte-----------------------//
  function generarObjeto(){
    return{
        campo:$("#f_campo").val(),/////////cambiar
        activo:1,
    }
  }

  function generarObjetoEdit(data){
    return {
        id_campo:data,/////////////cambiar/////////////
        campo:$("#f_edit").val(),
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
        id_campo:arrayID.id_campo,/////////////cambiar/////////////
        campo:arrayID.nombre_campo,/////////////cambiar/////////////
        activo:activoTmp,
      }
    };
  //-----------------------End Creación de objeto medio transporte-----------------------//
//-----------------------End Creación de objeto-----------------------//




//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_campo").click(function(){
  $("#f_campo").val("");
});
$("#btn_agregar_campo").click(function(){
  let obj = generarObjeto()
  eventoCrear(obj);
  $("#f_campo").val("");
});
$("#btn_agregar_nuevo_campo_modal").click(function(){
  cargarSelect();
});
$("#f_campo").keyup(function(){/////////////cambiar/////////////
  if ($("#f_campo").val() == "") {
    $( "#btn_agregar_campo" ).prop( "disabled", true );/////////////cambiar/////////////
  }else {
    $( "#btn_agregar_campo" ).prop( "disabled", false );/////////////cambiar/////////////
  }
});
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Campo.find(element => element.id_campo == data);/////////////cambiar/////////////
  return found;
};
function editar(data) {/////////////cambiar/////////////
  $("#contenedor_del_modal").html(`
      <label class="form-label">Nombre del campo</label>
      <input type="text" class="form-control"/ id="f_edit">
      <label class="form-label">select2</label>
        <select class="form-select js-example-basic-single" data-control="select2" id="f_edit_select2">
        </select>
        <label class="form-label">Fecha y hora</label>
        <input class="form-control" placeholder="Seleccione la fecha" id="f_edit_fecha"/>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
    `);
    $("#f_edit_fecha").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
    $(document).ready(function() {
        $('#f_edit_select2').select2();
    });
  let arrayID = buscarPorID(data);
  $("#f_edit").val(arrayID.valor_de_campo);/////////////cambiar/////////////
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
      <p class="text-danger">¿Está seguro que desea ${estado} el campo ${arrayID.valor_de_campo}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};
function cargarSelect() {
  $('#f_select2').empty();
  $('#f_select2').append('<option>Seleccione una opción</option>');
  $('#f_select2').append('<option disabled selected value="null">Seleccione una opción</option>');
  $('#f_select2').append('<option value="n">Nueva campo</option>');
  var $f_select2 = $('#f_select2');
  $.each(g__VariableGlobalSelect, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_select2.append('<option value="'+value.id_campo+'">'+value.campo+'</option>');/////////////Nome de los campos a mostrar/////////////
    }
  });
}
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
  g__Campo_datatables = $("#dt").DataTable({/////////////cambiar/////////////
    data: g__Campo,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_campo"},/////////////cambiar/////////////
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
        data: "id_campo",/////////////cambiar/////////////
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
        fetch('API/V1/campo/read.php')/////////////cambiar/////////////
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}


function eventoCrear(obj){
    fetch('API/V1/campo/create.php', {/////////////cambiar/////////////
        method:'POST',
        body:JSON.stringify(obj)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, 'Creación')
    })
}


function eventoEditar(data){
  let arrayID = buscarPorID(data);
  let value = generarObjetoEdit(data);
  if(!value){ return };

  fetch(`API/V1/campo/update.php?id_campo=${data}`, {/////////////cambiar/////////////
      method:'POST',
      body:JSON.stringify(value)
  })
  .then( r => r.json() )
  .then( r => {
      init();
      eventoResponse(r, 'Edición')
  })
}



function eventoActivar(data) {
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  fetch(`API/V1/campo/update.php?id_campo=${data}`, {/////////////cambiar/////////////
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
    fetch(`API/V1/campo/delete.php?id_campo=${data}`, {/////////////cambiar/////////////
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
