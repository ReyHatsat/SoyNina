<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2">
    <i class="fas fa-plus"></i>Agregar la no participación
</button>

<div class="modal bg-white fade" tabindex="-1" id="kt_modal_2">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none" style="padding:4%">
            <div class="modal-header">
                <h5 class="modal-title">No participación de la niña</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
            <label class="form-label">Seleccione la niña</label>
            <select class="form-select" aria-label="Select example" id="select_nina">
              <option value="1">uno</option>
              <option value="2">dos</option>
            </select>
            <label class="form-label">Numero de la niña (¿se genera en la db?)</label>
            <input class="form-control form-control" id="f_numero_nina"/>
            <label class="form-label">Club de la niña (¿se genera en la db?)</label>
            <input class="form-control form-control" id="f_club_nina"/>
            <label class="form-label">¿Está en un grupo whatsapp?</label>
            <div class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" type="checkbox" value="" id="f_grupo_whatsapp"/>
            </div>
            <label class="form-label">¿Tienen comunicacion constante?</label>
            <div class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" type="checkbox" value="" id="f_comunicacion_constante"/>
            </div>
            <label class="form-label">¿Algún familiar con covid?</label>
            <div class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" type="checkbox" value="" id="f_familiar_covid"/>
            </div>
            <label class="form-label">¿Participa en tutorias?</label>
            <div class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" type="checkbox" value="" id="f_participa_tutorias"/>
            </div>
            <label class="form-label">Comentarios</label>
            <textarea class="form-control" id="f_comentarios" rows="3"></textarea>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i>Agregar la no participación</button>
            </div>
        </div>
    </div>
</div>
