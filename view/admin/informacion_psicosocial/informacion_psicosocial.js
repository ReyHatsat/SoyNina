//-----------------------Variables globales-----------------------//
let g__Informacion_Psicosocial = [];
let g__Informacion_Psicosocial_datatables = [];
//-----------------------End Variables globales-----------------------//


//-----------------------init-----------------------//
init();

async function init() {
  await cargar();
}
//-----------------------init-----------------------//

//-----------------------Eventos del formulario-----------------------//
//-------------------------------->>
function buscarPorID(data) {
  const found = g__Informacion_Psicosocial.find(element => element.id_informacion_psicosocial == data);/////////////cambiar/////////////
  return found;
};
function ver(data) {
  $("#lb_rendimiento_academico").val(arrayID.rendimiento_academico);
  $("#lb_rendimiento_academico").val(arrayID.estudia_acompañada);
  $("#lb_acompanante").val(arrayID.id_acompanante);
  $("#lb_persona_vive").val(arrayID.id_persona_vive);
  $("#lb_recibe_apoyo").val(arrayID.recibe_apoyo);
  $("#lb_descripcion_apoyo").val(arrayID.descripcion_apoyo);
  $("#lb_recibe_beca").val(arrayID.recibe_beca);
  $("#lb_descripcion_beca").val(arrayID.descripcion_beca);
  $("#lb_relacion_companeros").val(arrayID.relacion_companeros);
  $("#lb_acontecimiento_escuela").val(arrayID.acontecimiento_escuela);
  $("#lb_tiene_hermanos").val(arrayID.tiene_hermanos);
  $("#lb_descripcion_hermanos").val(arrayID.descripcion_hermanos);
  $("#lb_vivienda").val(arrayID.id_vivienda);
  $("#lb_descripcion_nucleo_familiar").val(arrayID.descripcion_nucleo_familiar);
  $("#lb_conducta_alarmante").val(arrayID.conducta_alarmante);
  $("#lb_descripcion_conducta").val(arrayID.descripcion_conducta);
  $("#lb_situacion_violencia").val(arrayID.situacion_violencia);
  $("#lb_descripcion_situacion_violencia").val(arrayID.descripcion_situacion_violencia);
  $("#lb_comentarios_adicionales").val(arrayID.comentarios_adicionales);
}
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
function borrar(data) {
  let arrayID = buscarPorID(data);/////////////cambiar el arrayID.xxx/////////////
  $("#contenedor_del_modal").html(`
      <p class="text-danger">¿Está seguro que desea borrar ${arrayID.numero}?</p>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="eventoBorrar(${data})">Borrar</button>
    `);
};
//-------------------------------->>
//-----------------------End Eventos del formulario-----------------------//





//-----------------------DataTable-----------------------//
function renderDataTable() {
  g__Informacion_Psicosocial_datatables = $("#dt_psicosocial").DataTable({/////////////cambiar/////////////
    data: g__Informacion_Psicosocial,/////////////cambiar/////////////
    response: true,
    destroy: true,
    columns: [/////////////cambiar/////////////
      {data: "id_informacion_psicosocial"},
      {data: "id_nina"},
      {data: "active"},
      {
        data: "id_informacion_psicosocial",
        render:function (data) {
          return `
            <button class="btn btn-light" onclick="ver(${data})" data-bs-toggle="modal" data-bs-target="#md_ver"><i class="fas fa-eye"></i></button>
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
function cargar(){
  return request('<?=PATH_API?>informacion_psicosocial/read.php?', function(r){
      g__Informacion_Psicosocial = r.data.records;/////////////cambiar/////////////
      renderDataTable();
    });
}
//-----------------------End Eventos de la base de datos-----------------------//
