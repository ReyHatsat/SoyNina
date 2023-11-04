<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva vivienda</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <label class="form-label">Descripción de la vivienda</label>
              <input type="text" class="form-control"/ id="f_descripcion_vivienda">
              <br>
              <label class="form-label">Ingresos mensuales</label>
              <input type="text" class="form-control"/ id="f_ingresos_mensuales">
              <br>
              <label class="form-label">Descripción del barrio</label>
              <input type="text" class="form-control"/ id="f_descripcion_barrio">
              <br>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_cancelar_nueva_vivienda">Cancelar</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn_agregar_nueva_vivienda"><i class="fas fa-plus"></i>Agregar nuevo teléfono</button>
            </div>
        </div>
    </div>
</div>



<div class="card card-bordered">
    <div class="card-header">
        <h3 class="card-title">Lista de viviendas</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
              <i class="fas fa-plus"></i>Agregar a vivienda
          </button>
        </div>
    </div>
    <div class="card-body table-responsive">
      <!--begin::table-->
      <table id="dt_vivienda" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%;"><!--Cambiar------------------>
          <thead>
              <tr class="fw-bolder fs-6 text-gray-800">
                <th>ID de la vivienda</th>
                <th>Descripcion de la vivienda</th>
                <th>Ingresos mensuales</th>
                <th>Descripción del barrio</th>
                <th>Active</th>
                <th>Acciones</th>
              </tr>
          </thead>
      </table>
      <!--end::table-->

    </div>
    <div class="card-footer">

    </div>
</div>




<div class="modal fade" tabindex="-1" id="md_afectar_campo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Afectar vivienda <i class="fas fa-exclamation-triangle"></i></h5><!--Cambiar------------------>

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
