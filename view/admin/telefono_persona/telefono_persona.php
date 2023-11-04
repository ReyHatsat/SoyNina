<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2">
    <i class="fas fa-plus" id="test"></i>Nuevo telefono de persona
</button>

<div class="modal bg-white fade" tabindex="-1" id="kt_modal_2">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h5 class="modal-title">Telefono de persona</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
            <label for="" class="form-label">Persona</label>
            <select class="form-select" aria-label="Select example" id="f_persona">
              <option disabled selected value="0">Seleccione una opción</option>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </select>
            <label for="" class="form-label">Escoge el teléfono</label>
            <select class="form-select" aria-label="Select example" id="f_telefono">
              <option disabled selected value="0">Seleccione una opción</option>
              <option value="n">Nuevo teléfono</option>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
            </select>
            <div class="d-none" id="d_telefono">
              <label for="" class="form-label">Nuevo numero</label>
              <input class="form-control form-control" id="f_numero" inputmode="text">
              <div class="form-text">Formato del numero:
													<code>(506) 9999-9999</code>
              </div>
              <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                <a href="#" class="btn btn-white" id="btn_calcelar_nuevo_numero">Cancelar</a>
                <a href="#" class="btn btn-primary" id="btn_crear_nuevo_numero"><i class="fas fa-plus"></i>Agregar nuevo numero</a>
              </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_calcelar_telefono_persona">Cerrar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn_crear_telefono_persona"><i class="fas fa-plus"></i>Nuevo telefono de persona</button>
            </div>
        </div>
    </div>
</div>
