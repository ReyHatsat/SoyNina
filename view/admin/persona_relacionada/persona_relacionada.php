<button type="button" class="btn btn-primary" id="btn_agregar_persona_relacionada">
    <i class="fas fa-plus" id="test"></i>Agregar persona relacionada
</button>


<div class="container">
  <table class="table table-bordered table-row-dashed table-row-gray-300 gy-7" id="dt_persona_relacionada"><!--Cambiar------------------>
      <thead>
          <tr class="fw-bolder fs-6 text-gray-800">
            <th>Persona Relacionada</th>
            <th>Lugar de ocupacón</th>
            <th>Grado académico</th>
            <th>ID Dirección</th>
            <th>ID Ocupación</th>
            <th>ID Autorizado a recoger</th>
            <th>Niña</th>
            <th>Parentesco</th>
            <th>Descripción de la relación con Niña</th>
            <th>¿Es privado de livertad?</th>
            <th>Descripción del privado de livertad</th>
            <th>¿Consume drogas?</th>
            <th>Descripción del consumo de drogas</th>
            <th>¿Denuncia interpuesta?</th>
            <th>Descripción de la denuncia</th>
            <th>Active</th>
            <th>Acciones</th>
          </tr>
      </thead>
  </table>
</div>



<div class="modal fade" tabindex="-1" id="md_afectar_campo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Afectar Persona Relacionada <i class="fas fa-exclamation-triangle"></i></h5><!--Cambiar------------------>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" id="contenedor_del_modal">

            </div>
        </div>
    </div>
</div>
