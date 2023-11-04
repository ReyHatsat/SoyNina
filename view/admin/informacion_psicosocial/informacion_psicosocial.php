<?php
$id = $_GET['id']

?>
<div class="modal fade" tabindex="-1" id="md_ver">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <label class="form-label">Rendimiento académico</label>
                <label class="form-label" id="lb_rendimiento_academico"></label>
                <label class="form-label">¿Estidia acompañada?</label>
                <label class="form-label" id="lb_rendimiento_academico"></label>
                <label class="form-label">Acompañante</label>
                <label class="form-label" id="lb_acompanante"></label>
                <label class="form-label">Persona con la que vice</label>
                <label class="form-label" id="lb_persona_vive"></label>
                <label class="form-label">¿Recibe apoyo?</label>
                <label class="form-label" id="lb_recibe_apoyo"></label>
                <label class="form-label">Descripcion del apoyo</label>
                <label class="form-label" id="lb_descripcion_apoyo"></label>
                <label class="form-label">¿Recibe beca?</label>
                <label class="form-label" id="lb_recibe_beca"></label>
                <label class="form-label">Descripcion de la beca</label>
                <label class="form-label" id="lb_descripcion_beca"></label>
                <label class="form-label">Relacion con los companeros</label>
                <label class="form-label" id="lb_relacion_companeros"></label>
                <label class="form-label">Acontecimientos en la escuela</label>
                <label class="form-label" id="lb_acontecimiento_escuela"></label>
                <label class="form-label">¿Tiene hermanos?</label>
                <label class="form-label" id="lb_tiene_hermanos"></label>
                <label class="form-label">Descripcion de los hermanos</label>
                <label class="form-label" id="lb_descripcion_hermanos"></label>
                <label class="form-label">Vivienda</label>
                <label class="form-label" id="lb_vivienda"></label>
                <label class="form-label">Descripcion del nucleo familiar</label>
                <label class="form-label" id="lb_descripcion_nucleo_familiar"></label>
                <label class="form-label">¿Conducta Alarmante?</label>
                <label class="form-label" id="lb_conducta_alarmante"></label>
                <label class="form-label">Descripcion de la conducta</label>
                <label class="form-label" id="lb_descripcion_conducta"></label>
                <label class="form-label">¿Situacion de violencia?</label>
                <label class="form-label" id="lb_situacion_violencia"></label>
                <label class="form-label">Descripcion de la situacion de violencia</label>
                <label class="form-label" id="lb_descripcion_situacion_violencia"></label>
                <label class="form-label">Comentarios adicionales</label>
                <label class="form-label" id="lb_comentarios_adicionales"></label>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="container">
  <table class="table table-bordered table-row-dashed table-row-gray-300 gy-7" id="dt_psicosocial"><!--Cambiar------------------>
      <thead>
          <tr class="fw-bolder fs-6 text-gray-800">
            <th>ID de la inf psicosocial</th>
            <th>ID Niña</th>
            <th>Active</th>
            <th>Acciones</th>
          </tr>
      </thead>
  </table>
</div>
