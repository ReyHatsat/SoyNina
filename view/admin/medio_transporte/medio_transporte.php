<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
    <i class="fas fa-plus"></i>Agregar nuevo medio de transporte
</button>

<div class="modal fade" tabindex="-1" id="kt_modal_1">
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
              <label class="form-label">Nombre del nuevo medio de transporte</label>
              <input type="text" class="form-control" id="f_nombre_medio_transporte">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_cancelar_medio_transporte">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn_agregar_medio_transporte"><i class="fas fa-plus"></i>Agregar nuevo medio de transporte</button>
            </div>
        </div>
    </div>
</div>
