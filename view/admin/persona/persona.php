
<!--begin::Agregar-->
<div class="modal fade" tabindex="-1" id="modal_agregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva persona</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label for="identificacion_add" class="required form-label">Identificacion</label>
                <input type="text" class="form-control" placeholder="Identificacion..." id="identificacion_add"/>
              </div>
              <div class="mb-3">
                <label for="nombre_add" class="required form-label">Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre..." id="nombre_add"/>
              </div>
              <div class="mb-3">
                <label for="primer_apellido_add" class="required form-label">Primer Apellido</label>
                <input type="text" class="form-control" placeholder="Primer apellido..." id="primer_apellido_add"/>
              </div>
              <div class="mb-3">
                <label for="segundo_apellido_add" class="required form-label">Segundo Apellido</label>
                <input type="text" class="form-control" placeholder="Segundo apellido..." id="segundo_apellido_add"/>
              </div>
              <div class="mb-3">
                <label for="fecha_nacimiento_add" class="required form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" placeholder="Fecha de nacimiento..." id="fecha_nacimiento_add"/>
              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_agregar_persona">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_agregar_persona">Confirmar</button>
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
                <h5 class="modal-title">Editar persona</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label for="identificacion_edit" class="required form-label">Identificacion</label>
                <input type="text" class="form-control" placeholder="Identificacion..." id="identificacion_edit"/>
              </div>
              <div class="mb-3">
                <label for="nombre_edit" class="required form-label">Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre..." id="nombre_edit"/>
              </div>
              <div class="mb-3">
                <label for="primer_apellido_edit" class="required form-label">Primer Apellido</label>
                <input type="text" class="form-control" placeholder="Primer apellido..." id="primer_apellido_edit"/>
              </div>
              <div class="mb-3">
                <label for="segundo_apellido_edit" class="required form-label">Segundo Apellido</label>
                <input type="text" class="form-control" placeholder="Segundo apellido..." id="segundo_apellido_edit"/>
              </div>
              <div class="mb-3">
                <label for="fecha_nacimiento_edit" class="required form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" placeholder="Fecha de nacimiento..." id="fecha_nacimiento_edit"/>
              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_editar_persona">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_editar_persona">Confirmar</button>
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
                <h5 class="modal-title">Desactivar persona</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <p>¿Desea confirmar la desactivacion de esta persona?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_eliminar_persona">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_eliminar_persona">Confirmar</button>
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
                <h5 class="modal-title">Activar persona</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              <p>¿Desea confirmar la reactivacion de esta persona?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelar_activar_persona">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmar_activar_persona">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!--end::Reactivar-->

<!--begin::Card-->
<div class="card card-bordered">
    <div class="card-header">
        <h3 class="card-title">Lista de personas</h3>
        <div class="card-toolbar">
          <a href="?adm=add_persona" type="button" class="btn btn-primary" >
              <i class="fas fa-plus" id="test"></i>Agregar nueva persona
          </a>
        </div>
    </div>
    <div class="card-body table-responsive">
      <!--begin::table-->

      <table id="kt_datatable_persona" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%;">
          <thead>
              <tr class="fw-bold fs-6 text-muted">
                  <th>ID</th>
                  <th>Identificacion</th>
                  <th>Nombre</th>
                  <th>Primer Apellido</th>
                  <th>Segundo Apellido</th>
                  <th>Fecha de nacimiento</th>
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
