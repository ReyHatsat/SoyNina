
<!--begin::Agregar-->
<div class="modal fade" tabindex="-1" id="modal_agregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo nina</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label for="nina_add" class="required form-label">Nombre de nina</label>
                <input type="text" class="form-control" placeholder="Nombre de nina..." id="nina_add"/>
              </div>
              <div class="mb-3">
                <label for="select_nina_add" class="required form-label">nina</label>
                <select class="form-select" id="select_nina_add" data-control="select2" data-placeholder="Selecciona un nina">
                  <option></option>
                </select>
              </div>
              <div class="mb-3">
                <label for="codigo_add" class="required form-label">Codigo</label>
                <input type="text" class="form-control" placeholder="Codigo..." id="codigo_add"/>
              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_nuevo_nina">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_agregar_nina">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!--end::Agregar-->

<!--begin::Editar-->
<div class="modal fade" tabindex="-1" id="modal_editar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar nina</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label for="nina_edit" class="required form-label">Nombre de nina</label>
                <input type="text" class="form-control" placeholder="Nombre de nina..." id="nina_edit"/>
              </div>
              <div class="mb-3">
                <label for="select_nina_edit" class="required form-label">nina</label>
                <select class="form-select" id="select_nina_edit" data-control="select2" data-placeholder="Selecciona un nina">
                  <option></option>
                </select>
              </div>
              <div class="mb-3">
                <label for="codigo_edit" class="required form-label">Codigo</label>
                <input type="text" class="form-control" placeholder="Codigo..." id="codigo_edit"/>
              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_editar_nina">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_editar_nina">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!--end::Editar-->

<!--begin::Eliminar-->
<div class="modal fade" tabindex="-1" id="modal_eliminar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desactivar nina</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <p>¿Desea confirmar la desactivacion de este nina?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_eliminar_nina">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_eliminar_nina">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!--end::Eliminar-->

<!--begin::Reactivar-->
<div class="modal fade" tabindex="-1" id="modal_activar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activar nina</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <p>¿Desea confirmar la reactivacion de este nina?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_activar_nina">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_activar_nina">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!--end::Reactivar-->

<!--begin::Card-->
<div class="card card-bordered">
    <div class="card-header">
        <h3 class="card-title">Lista de niñas</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_agregar">
              <i class="fas fa-plus" id="test"></i>Agregar nueva niña
          </button>
        </div>
    </div>
    <div class="card-body table-responsive">
      <!--begin::table-->

      <table id="kt_datatable_nina" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%;">
          <thead>
              <tr class="fw-bold fs-6 text-muted">
                  <th>ID</th>
                  <th>Identificacion</th>
                  <th>Codigo Niña</th>
                  <th>Nombre</th>
                  <th>Primer Apellido</th>
                  <th>Segundo Apellido</th>
                  <th>Fecha de Ingreso</th>
                  <th>Activo</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
      <!--end::table-->

    </div>
    <div class="card-footer">

    </div>
</div>
<!--end::card-->
