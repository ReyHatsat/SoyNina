<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
    <i class="fas fa-plus"></i>Agregar nueva ocupacón
</button>

<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva ocupacón</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <label class="form-label">Nombre de la provincia</label>
              <input type="text" class="form-control" id="f_nombre_ocupacion"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_cancelar_nueva_ocupacion">Cancelar</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                id="btn_agregar_nueva_ocupacion" disabled><i class="fas fa-plus"></i>Agregar nueva ocupacón</button>
            </div>
        </div>
    </div>
</div>





<div class="container">
  <table class="table table-bordered table-row-dashed table-row-gray-300 gy-7" id="dt_ocupacion"><!--Cambiar------------------>
      <thead>
          <tr class="fw-bolder fs-6 text-gray-800">
            <th>ID de la ocupacón</th>
            <th>Nombre de la ocupacón</th>
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
                <h5 class="modal-title">Afectar Ocupación <i class="fas fa-exclamation-triangle"></i></h5><!--Cambiar------------------>

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
