<!--DataTable------------------>
<div class="card card-bordered">
    <div class="card-header">
        <h3 class="card-title">Lista de tipos de monedas</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1" id="btn_agregar_nuevo_campo_modal">
              <i class="fas fa-plus"></i>Agregar nuevo tipo de moneda
          </button>
        </div>
    </div>
    <div class="card-body table-responsive">
      <table id="dt" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%;"><!--Cambiar------------------>
          <thead>
              <tr class="fw-bold fs-6 text-muted">
            <th>ID del tipo de moneda</th>
            <th>Tipo de moneda</th>
            <th>Activo</th>
            <th>Acciones</th>
          </tr>
      </thead>
  </table>
</div>
<div class="card-footer">
</div>
</div>
<!--End DataTable------------------>




<!--Modales------------------>
<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tipo de moneda</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <label class="form-label">Nombre del nuevo tipo de moneda</label>
              <input type="text" class="form-control" id="f_nombre_tipo_moneda">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_cancelar_tipo_moneda">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" disabled id="btn_agregar_tipo_moneda"><i class="fas fa-plus"></i>Agregar nuevo tipo de moneda</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="md_afectar_campo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Afectar Campo <i class="fas fa-exclamation-triangle"></i></h5><!--Cambiar------------------>

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
<!--End Modales------------------>
