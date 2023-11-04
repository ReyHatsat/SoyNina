//-----------------------Variables grobales-----------------------//
let g__rubro = [];
let g__rubro_datatables = [];
let g__activo = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  g__rubro = await cargarRubro();
  g__rubro = g__rubro.document.records;
  renderDataTable();
}
//-----------------------init-----------------------//



//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto rubro-----------------------//
  function generarObjeto(){
    return{
      nombre:$("#f_nombre").val(),
    }
  }

  function generarObjetoEdit(data){
    return {
        id_rubro:data,
        nombre:$("#f_edit_nombre").val(),
    }
  };

  /*function generarObjetoActivar(data){
    let arrayID = buscarPorID(data);
    let activoTmp = "";
    if (arrayID.activo == 0) {
      activoTmp = "1";
    }else {
      activoTmp = "0";
    }
    return {
        id_rubro:arrayID.id_rubro,
        rubro:arrayID.nombre_rubro,
        activo:activoTmp,
      }
    };*/
  //-----------------------End Creación de objeto rubro-----------------------//
//-----------------------End Creación de objeto-----------------------//


//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_rubro").click(function(){
  $("#f_nombre").val("");
});

$("#btn_agregar_rubro").click(function(){
    let obj = generarObjeto();
    eventoCrear(obj);
    $("#f_nombre").val("");
});

//Valida el ingreso de letras únicamente para el modal agregar
$('#f_nombre').on('keyup', function() {
      //$('#demo').html('Ingrese únicamente letras' + validarTexto(this.value));
      $('#demo').html('');
      $( "#btn_agregar_rubro" ).prop( "disabled", false );
      if(validarTexto(this.value) == false){
        $('#demo').html('Ingrese únicamente letras');

        $( "#btn_agregar_rubro" ).prop( "disabled", true );
      }

});
//Valida el ingreso de letras únicamente para el modal editar
$('#f_edit_nombre').on('keyup', function() {
        $('#demo_edit').html('');
        $( "#btn_editar_rubro" ).prop( "disabled", false );
        if(validarTexto(this.value) == false){
          $('#demo_edit').html('Ingrese únicamente letras');

          $( "#btn_editar_rubro" ).prop( "disabled", true );
      }
});


//-------------------------------->>
function buscarPorID(data) {
  const found = g__rubro.find(element => element.id_rubro == data);
  return found;
};

function editar(data) {
  $("#contenedor_del_modal").html(`
      <form class="" id="f_form" method="post">
        <div class="modal-body">
          <label class="form-label">Nombre del rubro</label>
          <input type="text" class="form-control" id="f_edit_nombre">
          <div id="demo_edit"></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="btn_editar_rubro" onclick="eventoEditar(${data})">Editar</button>
        </div>
      </form>
    `);
  let arrayID = buscarPorID(data);
  $("#f_edit_nombre").val(arrayID.nombre);
};

function borrar(data) {
  let arrayID = buscarPorID(data);
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea borrar el rubro: ${arrayID.nombre}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoBorrar(${data})">Sí</button>
    `);
};

/*function activar(data) {
  let arrayID = buscarPorID(data);
  let estado = "";
  if (arrayID.activo == 0) {
    estado = "activar"
  }else {
    estado = "desactivar"
  }
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea ${estado} el campo ${arrayID.valor_de_rubro}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};*/

/*function cargarSelect() {
  $('#f_select2').empty();
  $('#f_select2').append('<option disabled selected value="0">Seleccione una opción</option>');
  $('#f_select2').append('<option value="n">Nueva rubro</option>');
  var $f_select2 = $('#f_select2');
  $.each(g__VariableGlobalSelect, function(key, value) {/////////////aquí se inserta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_select2.append('<option value="'+value.id_rubro+'">'+value.rubro+'</option>');/////////////Nombre de los campos a mostrar/////////////
    }
  });
}*/
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



//----------------------------Validaciones------------------------//

// valida que solo se puedan ingresar letras en el campo de nombre
function validarTexto(data) {
    var regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
      return regex.test(data);

}

function validarCampo(){
  if ($("#f_nombre").val() == "") {
    $( "#btn_agregar_rubro" ).prop( "disabled", true );
  }else {
    $( "#btn_agregar_rubro" ).prop( "disabled", false );
  }
}


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__rubro_datatables = $("#dt").DataTable({
    data: g__rubro,
    response: true,
    destroy: true,
    columns: [
      {data: "id_rubro"},
      {data: "nombre"},
      {
        data: "id_rubro",
        render:function (data) {
          return `
            <button class="btn btn-success" onclick="editar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_rubro"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger" onclick="borrar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_rubro"><i class="fas fa-ban"></i></i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//


function eventoCrear(obj){
    fetch('<?=PATH_API?>rubro/create.php', {
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
    fetch(`<?=PATH_API?>rubro/update.php?id_rubro=${data}`, {
        method:'POST',
        body:JSON.stringify(value)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, "Edición: ")
    })
}


function eventoBorrar(data){
    let value = generarObjetoEdit(data);
    fetch(`<?=PATH_API?>rubro/delete.php?id_rubro=${data}`, {
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




//-----------------------Funciones de carga remota. API, CONSULTAS EXTERNAS-----------------------//
/*function cargarRubro(){
    fetch('<?=PATH_API?>rubro/read.php')/////////////cambiar/////////////
    .then( r => r.json() )
    .then( data => g__rubro = data.document.records )
    //.then(() => loadRubroTable())
}*/

function cargarRubro(){
    return new Promise( resolve => {
        fetch('<?=PATH_API?>rubro/read.php')
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}
