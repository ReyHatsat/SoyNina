let g__persona_datatable = null;
let g__persona = [];


function Init() {
  LoadPersonas();
}
Init();

// Trigger Add button
trigger('#confirmar_agregar_persona', 'click', function(e) {
  let data = {
      id_persona: "",
      identificacion: findone('#identificacion_add').value,
      nombre_persona: findone('#nombre_add').value,
      primer_apellido: findone('#primer_apellido_add').value,
      segundo_apellido: findone('#segundo_apellido_add').value,
      fecha_nacimiento: new Date(findone('#fecha_nacimiento_add').value).toISOString(),
      active: "1"
  };

  if (validar(config)) {


    // request('<?=PATH_API?>persona/create.php', function(r) {
    //   notification('Persona agregada', 'Se ha agregado la persona correctamente', 'success');
    //   loadPersonaTable();
    // }, config);
  }
});

trigger('#confirmar_editar_persona', 'click', function(e) {
  let config = {
    data: {
      id_persona: currentValue.id_persona,
      identificacion: findone('#identificacion_edit').value,
      nombre_persona: findone('#nombre_edit').value,
      primer_apellido: findone('#primer_apellido_edit').value,
      segundo_apellido: findone('#segundo_apellido_edit').value,
      fecha_nacimiento: new Date(findone('#fecha_nacimiento_edit').value).toISOString(),
      active: "1"
    }
  };

  if (validar(config) && !executing) {
    executing = true;
    request('<?=PATH_API?>persona/update.php', function(r) {
      notification('Persona actualizada', 'Se ha actualizado la persona correctamente', 'success');
      loadPersonaTable();
      executing = false;
    }, config);
  }
});

trigger('#confirmar_activar_persona', 'click', function(e) {
  const {
    id_persona,
    identificacion,
    nombre_persona,
    primer_apellido,
    segundo_apellido,
    fecha_nacimiento,
    active
  } = currentValue;

  let config = {
    data: {
      id_persona:id_persona,
      identificacion:identificacion,
      nombre_persona:nombre_persona,
      primer_apellido:primer_apellido,
      segundo_apellido:segundo_apellido,
      fecha_nacimiento:fecha_nacimiento,
      active:"1"
    }
  };
  request('<?=PATH_API?>persona/update.php', function(r) {
    notification('persona activado', 'Se ha reactivado el persona correctamente', 'success');

    loadPersonaTable();

  }, config);
});

trigger('#confirmar_eliminar_persona', 'click', function(e) {
  const {
    id_persona,
    identificacion,
    nombre_persona,
    primer_apellido,
    segundo_apellido,
    fecha_nacimiento,
    active
  } = currentValue;

  let config = {
    data: {
      id_persona:id_persona,
      identificacion:identificacion,
      nombre_persona:nombre_persona,
      primer_apellido:primer_apellido,
      segundo_apellido:segundo_apellido,
      fecha_nacimiento:fecha_nacimiento,
      active:"0"
    }
  };
  request('<?=PATH_API?>persona/update.php', function(r) {
    notification('persona desactivado', 'Se ha desactivado el persona correctamente', 'warning');

    loadPersonaTable();

  }, config);
});

// End Trigger Add button

// Inicio Funciones
function editar(id) {
  currentValue = g__persona.find(x => x.id_persona == id);
  findone('#identificacion_edit').value = currentValue.identificacion;
  findone('#nombre_edit').value = currentValue.nombre_persona;
  findone('#primer_apellido_edit').value = currentValue.primer_apellido;
  findone('#segundo_apellido_edit').value = currentValue.segundo_apellido;
  findone('#fecha_nacimiento_edit').value = new Date(currentValue.fecha_nacimiento).toISOString().substring(0, 10);
  $('#modal_editar').modal('show')

}
function LoadPersonas() {
  fetch('API/V1/persona/read.php')
  .then(r => r.json())
  .then(data => g__persona = data.document.records)
  .then(()=>loadPersonaTable(g__persona));
}

function desactivar(id) {
  currentValue = g__persona.find(x => x.id_persona == id);
  $('#modal_eliminar').modal('show');
}

function reactivar(id) {
  currentValue = g__persona.find(x => x.id_persona == id);
  $('#modal_activar').modal('show');
}

function LoadSelectpersona(select) {
  let content = `
    <option></option>

  `;
  content += LoadSelect("#select_persona_add", g__persona, 'persona', 'id_persona', false);
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
function loadPersonaTable(g__persona) {

  if (g__persona_datatable) {
    g__persona_datatable.destroy();
  }
    g__persona_datatable = $('#kt_datatable_persona').DataTable({
      data: g__persona,
      destroy: true,
      searching: true,
      responsive: true,
      columns: [
        {
          data: 'id_persona'
        },
        {
          data: 'identificacion'
        },
        {
          data: 'nombre'
        },
        {
          data: 'primer_apellido'
        },
        {
          data: 'segundo_apellido'
        },
        {
          data: 'fecha_nacimiento',
          render: function(data, type, row) {
            return new Date(data).toISOString().substring(0, 10);
          }
        },
        {
          data: 'activo',
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
          data: 'id_persona',
          render: function(data, type, row) {
            if (row.activo == "1") {
              return `
              <button class="btn btn-primary editar_persona" onclick="editar(${Number(data)})" ><i class="fas fa-edit"></i></button>
              <button class="btn btn-danger desactivar_persona" onclick="desactivar(${Number(data)})" ><i class="fas fa-ban"></i></button>`;
            } else {
              return `<button class="btn btn-danger reactivar_persona" onclick="reactivar(${Number(data)})" ><i class="fas fa-plus-circle"></i></button>`;
            }
          }
        }
      ]
    });


}
// Final Instancia Datatable

// Inicio Validaciones
function validar(data) {
  console.log(data);
  if (data.identificacion != "" && data.nombre_persona != "" && data.primer_apellido != "" && data.segundo_apellido != ""&& !data.fecha_nacimiento ) {
    return true;
  } else {
    notification('Informacion incorrecta', 'La informacion esta incompleta o incorrecta', 'warning');
    return false;
  }

}
// Final Validaciones
