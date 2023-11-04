<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2">
    <i class="fas fa-plus" id="test"></i>Agregar nuevo registro del kit
</button>

<div class="modal bg-white fade" tabindex="-1" id="kt_modal_2">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
            <label for="" class="form-label">Selecciona un registro de no participacion</label>
            <select class="form-select" aria-label="Select example" id="f_registro">
              <option disabled selected value="0">Seleccione una opción</option>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </select>
            <label for="" class="form-label">Selecciona un kit</label>
            <select class="form-select" aria-label="Select example" id="f_kit">
              <option disabled selected value="0">Seleccione una opción</option>
              <option value="n">Nueva ocupación</option>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </select>
            <div class="d-none" id="d_kit">
              <label class="form-label">Nombre del nuevo kit</label>
              <input class="form-control form-control" id="f_nombre_kit" inputmode="text"/>
              <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                <a href="#" class="btn btn-white" id="btn_calcelar_nuevo_kit">Cancelar</a>
                <a href="#" class="btn btn-primary" id="btn_crear_nuevo_kit"><i class="fas fa-plus"></i>Agregar nuevo kit</a>
              </div>
            </div>
            <label class="form-label">¿Recibido?</label>
            <div class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" type="checkbox" value="" id="f_recibido"/>
            </div>
            <label class="form-label">Detalles</label>
            <input class="form-control form-control" id="f_detalles" inputmode="text"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_agregar_nuevo_registro_kit"><i class="fas fa-plus" id="test"></i>Agregar nuevo registro del kit</button>
            </div>
            </div>
        </div>
    </div>
</div>
