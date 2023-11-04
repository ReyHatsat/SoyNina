//-----------------------Variables grobales-----------------------//
let g__club = [];
let g__ciclo = [];
let g__club_datatables = [];
let g__activo = 0;
//-----------------------End Variables grobales-----------------------//


//-----------------------init-----------------------//
init();
async function init() {
  g__club = await cargarClub();
  g__club = g__club.document.records;

  g__ciclo = await cargarCiclo();
  g__ciclo = g__ciclo.document.records;
  console.log(g__club);
  renderDataTable();
}
//-----------------------init-----------------------//



//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto rubro-----------------------//
  function generarObjeto(){
    return{
        nombre:$("#f_nombre").val(),
        id_ciclo:$("#f_ciclo").val(),
        codigo:$("#f_codigo").val(),
        activo:1,
    }
  };

  function generarObjetoEdit(data){
    return {
        id_club:data,
        nombre:$("#f_edit_nombre").val(),
        id_ciclo:$("#f_edit_ciclo").val(),
        codigo:$("#f_edit_codigo").val(),
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
        id_club:arrayID.id_club,
        nombre:arrayID.nombre,
        id_ciclo:arrayID.id_ciclo,
        codigo:arrayID.codigo,
        activo:activoTmp,

      }
    };
  //-----------------------End Creación de objeto rubro-----------------------//
//-----------------------End Creación de objeto-----------------------//


//-----------------------Eventos del formulario-----------------------//

//Cancelar
$("#btn_cancelar_club").click(function(){
  $("#f_nombre").val("");
  $("#f_ciclo").val("null");
  $("#f_codigo").val("");
  $( "#btn_agregar_club" ).prop( "disabled", true );
});

$("#btn_agregar_ciclo").click(function(){
    let obj = generarObjeto()
    eventoCrear(obj);

  $("#f_nombre").val("");
  $("#f_ciclo").val("");
  $("#f_codigo").val("");

});

//Cargar la información de persona para el select del modal agregar
$("#btn_agregar_nuevo_club_modal").click(function(){
  cargarSelect();
});

//Agregar asesor
$("#btn_agregar_club").click(function(){
    let obj = generarObjeto()
    eventoCrear(obj);
  $("#f_nombre").val("");
  $("#f_ciclo").val("");
  $("#f_codigo").val("");

});

//Valida el ingreso de letras únicamente para el modal agregar
$('#f_nombre').on('keyup', function() {

  $('#demo_nombre').html('');
  if(validarTexto(this.value) == false){
    $('#demo_nombre').html('Ingrese únicamente letras');
  }
    validarCampo();
});

//Valida el ingreso de letras únicamente para el modal agregar
$('#f_codigo').on('keyup', function() {

  $('#demo_codigo').html('');
  if(validarTextoCodigo(this.value) == false){
    $('#demo_codigo').html('Ingrese únicamente letras, números y espacios');
  }
    validarCampo();
});

//Valida el ingreso de letras únicamente para el modal agregar
/*$('#f_edit_nombre').on('keyup', function() {
      //$('#demo').html('Ingrese únicamente letras' + validarTexto(this.value));
      if(validarTexto(this.value) == true){
        $('#demo_edit').html('');
        $( "#btn_editar_club" ).prop( "disabled", false );
      }else{
        $('#demo_edit').html('Ingrese únicamente letras');
        $( "#btn_editar_club" ).prop( "disabled", true );
      }
});
*/

$("#f_ciclo").change(function(){
validarCampo();
});
$("#f_nombre").change(function(){
validarCampo();
});
$("#f_codigo").change(function(){
validarCampo();
});

function buscarPorID(data) {
  const found = g__club.find(element => element.id_club == data);
  return found;
};


function editar(data) {
  $("#contenedor_del_modal").html(`
    <form class="" id="f_form" method="post">
      <div class="modal-body">
        <label class="form-label">Nombre</label>
        <input type="text" class="form-control"/ id="f_edit_nombre">
        <div id="demo_edit"></div>
        </div>
        <div class="modal-body">
          <label class="form-label">Ciclo</label>
          <select class="form-select js-example-basic-single" data-control="select2" id="f_edit_ciclo">
          </select>
        </div>
        <div class="modal-body">
        <label class="form-label">Codigo</label>
        <input type="text" class="form-control"/ id="f_edit_codigo">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-success" id="btn_editar_asesor" data-bs-dismiss="modal" onclick="eventoEditar(${data})">Editar</button>
      </div>
    </form>
    `);

    $(document).ready(function() {
        $('#f_edit_ciclo').select2();
    });

    cargarSelectEdit();

  let arrayID = buscarPorID(data);
  $("#f_edit_nombre").val(arrayID.nombre);
  $("#f_edit_ciclo").val(arrayID.id_ciclo);
  $("#f_edit_codigo").val(arrayID.codigo);
};

function activar(data) {
  let arrayID = buscarPorID(data);
  let estado = "";
  if (arrayID.estado == 0) {
    estado = "activar"
  }else {
    estado = "desactivar"
  }
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea ${estado} el club ${arrayID.id_club}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoActivar(${data})">Sí</button>
    `);
};

function cargarSelect() {
  $('#f_ciclo').empty();
  $('#f_ciclo').append('<option disabled selected value="null">Seleccione una opción</option>');
  var $f_ciclo = $('#f_ciclo');
  $.each(g__ciclo, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_ciclo.append('<option value="'+value.id_ciclo+'">'+value.nombre +'</option>');
    }
  });
}

function cargarSelectEdit() {
  $('#f_edit_ciclo').empty();
  $('#f_edit_ciclo').append('<option disabled selected value="null">Seleccione una opción</option>');
  var $f_edit_ciclo = $('#f_edit_ciclo');
  $.each(g__ciclo, function(key, value) {/////////////aquí se incerta el objeto con los datos a llenar/////////////
    var $option = $("<option/>", {
      value: key,
      text: value,
    });
    if (value.activo == 1) {
      $f_edit_ciclo.append('<option value="'+value.id_ciclo+'">'+value.nombre+'</option>');
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

//-----------------------Validaciones-----------------------//

//Valida que solo se puedan ingresar letras en el campo de nombre
function validarTexto(data) {
    var regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
      return regex.test(data);

}

//Valida que se ingresen numeros, letras y espacios
function validarTextoCodigo(data) {
    //var regex = /^[a-zA-Z ]+$/;
    var regex = /^[A-Za-z0-9 ]+$/g;
      return regex.test(data);
}

//Validar campos vacíos
function validarCampo(){
  if ($("#f_nombre").val() == "" || $("#f_ciclo").val() == null || $("#f_codigo").val() == ""  || validarTexto($('#f_nombre').val()) == false || validarTextoCodigo($('#f_codigo').val()) == false) {
    $( "#btn_agregar_club" ).prop( "disabled", true );
  }else {
    $( "#btn_agregar_club" ).prop( "disabled", false );
  }
}


//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__club_datatables = $("#dt").DataTable({
    data: g__club,
    response: true,
    destroy: true,
    columns: [
      {data: "id_club"},
      {data: "nombre"},
      {data: "id_ciclo",
      render: function(data){
        const found = g__ciclo.find(element => element.id_ciclo == data)
        return found.nombre
      }
      },
      {data: "codigo"},
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
        data: "id_club",/////////////cambiar/////////////
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
            <button class="btn btn-success" onclick="editar(${data})" ${btn_disabled} data-bs-toggle="modal" data-bs-target="#md_afectar_club"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn ${btn_color}" onclick="activar(${data})" data-bs-toggle="modal" data-bs-target="#md_afectar_club">${icoactivo}</i></button>
          `
        }
      },
    ]
  });
};
//-----------------------End DataTable-----------------------//


function eventoCrear(obj){
    fetch('<?=PATH_API?>club/create.php', {
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
    fetch(`<?=PATH_API?>club/update.php?id_asesor=${data}`, {
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
    fetch(`<?=PATH_API?>club/delete.php?id_asesor=${data}`, {
        method:'POST',
        body:JSON.stringify(value)
    })
    .then( r => r.json() )
    .then( r => {
        init();
        eventoResponse(r, "Borrado:")
    })
}

function eventoActivar(data) {
  let arrayID = buscarPorID(data);
  let value = generarObjetoActivar(data);
  if(!value){ return };
  fetch(`<?=PATH_API?>club/update.php?id_club=${data}`, {/////////////cambiar/////////////
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




//-----------------------Funciones de carga remota. API, CONSULTAS EXTERNAS-----------------------//

function cargarClub(){
    return new Promise( resolve => {
        fetch('<?=PATH_API?>club/read.php')
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}

function cargarCiclo(){
    return new Promise( resolve => {
        fetch('<?=PATH_API?>ciclo/read.php')
        .then( r => r.json() )
        .then( r => resolve(r) )
    })
}
















/*let g__club_datatable = null;
let g__club = [];
let g__ciclo = [];
let executing = false;
let currentValue = "";
Init();

async function Init() {
  let a = await loadCiclos();
  LoadSelectClub("#select_club_add");
  loadClubTable();
}

// Trigger Add button
trigger('#confirmar_agregar_club', 'click', function(e) {
  let config = {
    data: {
      id_club: "",
      nombre_club: findone('#club_add').value,
      codigo: findone('#codigo_add').value,
      id_ciclo: findone('#select_club_add').value,
      active: "1"
    }
  };
  if (validar(config.data)) {
    request('<?=PATH_API?>club/create.php', function(r) {
      notification('Club agregado', 'Se ha agregado el club correctamente', 'success');
      loadClubTable();
    }, config);
  }
});

trigger('#confirmar_editar_club', 'click', function(e) {
  let config = {
    data: {
      id_club: currentValue.id_club,
      nombre_club: findone('#club_edit').value,
      codigo: findone('#codigo_edit').value,
      id_ciclo: findone('#select_club_edit').value,
      active: "1"
    }
  };

  if (validar(config.data) && !executing) {
    executing = true;
    request('<?=PATH_API?>club/update.php', function(r) {
      notification('Club actualizado', 'Se ha actualizado el club correctamente', 'success');
      loadClubTable();
      executing = false;
    }, config);
  }
});

trigger('#confirmar_activar_club', 'click', function(e) {
  const {
    id_club,
    nombre_club,
    codigo,
    id_ciclo,
    active
  } = currentValue;

  let config = {
    data: {
      id_club: id_club,
      nombre_club: nombre_club,
      codigo: codigo,
      id_ciclo: id_ciclo,
      active: "1"
    }
  };
  request('<?=PATH_API?>club/update.php', function(r) {
    notification('Club activado', 'Se ha reactivado el Club correctamente', 'success');

    loadClubTable();

  }, config);
});

trigger('#confirmar_eliminar_club', 'click', function(e) {
  const {
    id_club,
    nombre_club,
    codigo,
    id_ciclo,
    active
  } = currentValue;

  let config = {
    data: {
      id_club: id_club,
      nombre_club: nombre_club,
      codigo: codigo,
      id_ciclo: id_ciclo,
      active: "0"
    }
  };
  request('<?=PATH_API?>club/update.php', function(r) {
    notification('Club desactivado', 'Se ha desactivado el club correctamente', 'warning');

    loadClubTable();

  }, config);
});

// End Trigger Add button

// Inicio Funciones
function editar(id) {
  currentValue = g__club.find(x => x.id_club == id);
  LoadSelectClub("#select_club_edit");
  findone('#club_edit').value = currentValue.nombre_club;
  findone('#select_club_edit').value = currentValue.id_ciclo;
  findone('#codigo_edit').value = currentValue.codigo;
  $('#modal_editar').modal('show')

}

function desactivar(id) {
  currentValue = g__club.find(x => x.id_club == id);
  $('#modal_eliminar').modal('show');
}

function reactivar(id) {
  currentValue = g__club.find(x => x.id_club == id);
  $('#modal_activar').modal('show');
}

function LoadSelectClub(select) {
  let content = `
    <option></option>

  `;
  content += LoadSelect("#select_ciclo_add", g__ciclo, 'ciclo', 'id_ciclo', false);
  findone(select).innerHTML = content;
}

function hide(elem) {
  $(elem).addClass("d-none");

}

function show(elem) {
  $(elem).removeClass("d-none");

}
// Final  Funciones

// Inicio Instancia Datatable
function loadClubTable() {

  if (g__club_datatable) {
    g__club_datatable.destroy();
  }

  request(`<?=PATH_API?>club/read.php?`, function(r) {
    //IMPORTANTE GUARDAR REFERENCIA A LA TABLA EN UNA VARIABLE.
    g__club = r.data.records;
    g__club_datatable = $('#kt_datatable_club').DataTable({
      data: g__club,
      destroy: true,
      searching: true,
      responsive: true,
      columns: [{
          data: 'id_club'
        },
        {
          data: 'nombre_club'
        },
        {
          data: 'codigo'
        },
        {
          data: 'ciclo'
        },
        {
          data: 'active',
          render: function(data, type, row) {
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
          data: 'id_club',
          render: function(data, type, row) {
            if (row.active == "1") {
              return `<button class="btn btn-primary editar_club" onclick="editar(${Number(data)})" ><i class="fas fa-edit"></i></button>
              <button class="btn btn-danger desactivar_club" onclick="desactivar(${Number(data)})" ><i class="fas fa-ban"></i></button>`;
            } else {
              return `<button class="btn btn-danger reactivar_club" onclick="reactivar(${Number(data)})" ><i class="fas fa-plus-circle"></i></button>`;
            }
          }
        }
      ]
    });

    $('body').off();
  });
}
// Final Instancia Datatable

// Inicio Validaciones
function validar(data) {
  if (data.codigo != "" && data.id_ciclo != "" && data.nombre_club != "") {
    return true;
  } else {
    notification('Informacion incorrecta', 'La informacion esta incompleta o incorrecta', 'warning');
    return false;
  }

}
// Final Validaciones

function loadCiclos(){
  return new Promise(resolve => {
    request(`<?=PATH_API?>ciclo/read.php?`, function(r) {
      g__ciclo = r.data.records;
      resolve(true);
    });
  });

}*/
