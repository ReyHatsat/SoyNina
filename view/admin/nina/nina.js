let g__nina_datatable = null;
let g__nina = [];
let g__ni = [];
let executing = false;
let currentValue = "";
Init();

async function Init() {
  loadNinatable();
}

// Trigger Add button
trigger('#confirmar_agregar_nina', 'click', function(e) {
  let config = {
    data: {
      id_nina: "",
      nombre_nina: findone('#nina_add').value,
      codigo: findone('#codigo_add').value,
      active: "1"
    }
  };
  if (validar(config.data)) {
    request('<?=PATH_API?>nina/create.php', function(r) {
      notification('nina agregado', 'Se ha agregado el nina correctamente', 'success');
      loadNinatable();
    }, config);
  }
});

trigger('#confirmar_editar_nina', 'click', function(e) {
  let config = {
    data: {
      id_nina: currentValue.id_nina,
      nombre_nina: findone('#nina_edit').value,
      codigo: findone('#codigo_edit').value,
      active: "1"
    }
  };

  if (validar(config.data) && !executing) {
    executing = true;
    request('<?=PATH_API?>nina/update.php', function(r) {
      notification('nina actualizado', 'Se ha actualizado el nina correctamente', 'success');
      loadNinatable();
      executing = false;
    }, config);
  }
});

trigger('#confirmar_activar_nina', 'click', function(e) {
  const {
    id_nina,
    nombre_nina,
    codigo,
    active
  } = currentValue;

  let config = {
    data: {
      id_nina: id_nina,
      nombre_nina: nombre_nina,
      codigo: codigo,
      active: "1"
    }
  };
  request('<?=PATH_API?>nina/update.php', function(r) {
    notification('nina activado', 'Se ha reactivado el nina correctamente', 'success');

    loadNinatable();

  }, config);
});

trigger('#confirmar_eliminar_nina', 'click', function(e) {
  const {
    id_nina,
    nombre_nina,
    codigo,
    active
  } = currentValue;

  let config = {
    data: {
      id_nina: id_nina,
      nombre_nina: nombre_nina,
      codigo: codigo,
      active: "0"
    }
  };
  request('<?=PATH_API?>nina/update.php', function(r) {
    notification('nina desactivado', 'Se ha desactivado el nina correctamente', 'warning');

    loadNinatable();

  }, config);
});

// End Trigger Add button

// Inicio Funciones
function editar(id) {
  currentValue = g__nina.find(x => x.id_nina == id);
  LoadSelectnina("#select_nina_edit");
  findone('#nina_edit').value = currentValue.nombre_nina;
  findone('#select_nina_edit').value = currentValue.id_nina;
  findone('#codigo_edit').value = currentValue.codigo;
  $('#modal_editar').modal('show')

}

function desactivar(id) {
  currentValue = g__nina.find(x => x.id_nina == id);
  $('#modal_eliminar').modal('show');
}

function reactivar(id) {
  currentValue = g__nina.find(x => x.id_nina == id);
  $('#modal_activar').modal('show');
}

function LoadSelectnina(select) {
  let content = `
    <option></option>

  `;
  content += LoadSelect("#select_nina_add", g__nina, 'nina', 'id_nina', false);
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
function loadNinatable() {

  if (g__nina_datatable) {
    g__nina_datatable.destroy();
  }

  request(`<?=PATH_API?>nina/read.php?`, function(r) {
    //IMPORTANTE GUARDAR REFERENCIA A LA TABLA EN UNA VARIABLE.
    g__nina = r.data.records;
    console.log(g__nina);
    g__nina_datatable = $('#kt_datatable_nina').DataTable({
      data: g__nina,
      destroy: true,
      searching: true,
      responsive: true,
      columns: [{
          data: 'id_nina'
        },
        {
          data: 'nombre_nina'
        },
        {
          data: 'codigo'
        },
        {
          data: 'nina'
        },
        {
          data: 'active',
          render: function(data, type, row) {
            switch (data) {
              case "1":
                return `<span class="badge badge-success">Activo</span>`;
                break;
              case "0":
                return `<span class="badge badge-danger">Eliminado</span>`;
                break;
              default:
                return "";
            }
          }
        },
        {
          data: 'id_nina',
          render: function(data, type, row) {
            if (row.active == "1") {
              return `<button class="btn btn-primary editar_nina" onclick="editar(${Number(data)})" ><i class="fas fa-edit"></i></button>
              <button class="btn btn-danger desactivar_nina" onclick="desactivar(${Number(data)})" ><i class="fas fa-ban"></i></button>`;
            } else {
              return `<button class="btn btn-danger reactivar_nina" onclick="reactivar(${Number(data)})" ><i class="fas fa-plus-circle"></i></button>`;
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
  if (data.codigo != "" && data.id_nina != "" && data.nombre_nina != "") {
    return true;
  } else {
    notification('Informacion incorrecta', 'La informacion esta incompleta o incorrecta', 'warning');
    return false;
  }

}
// Final Validaciones

function loadninas(){
  return new Promise(resolve => {
    request(`<?=PATH_API?>nina/read.php?`, function(r) {
      g__nina = r.data.records;
      resolve(true);
    });
  });

}
