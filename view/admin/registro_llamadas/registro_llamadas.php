<!--DataTable------------------>
<div class="card card-bordered">
    <div class="card-header">
        <h3 class="card-title">Lista de los registros de llamada</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1" id="btn_agregar_nuevo_registro_llamadas_modal">
              <i class="fas fa-plus"></i>Agregar nuevo registro de llamada
          </button>
        </div>
    </div>
    <div class="card-body table-responsive">
      <table id="dt" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%;"><!--Cambiar------------------>
          <thead>
              <tr class="fw-bold fs-6 text-muted">
                <th>ID del registro de la llamada</th>
                <th>Persona</th>
                <th>fecha</th>
                <th>Estado</th>
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
                <h5 class="modal-title">Registro de llamadas</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>
            <form class="" id="f_form" method="post">
            <div class="modal-body">
              <div class="">
              <label class="form-label">Persona</label>
                <select class="form-select" data-control="select2" id="f_persona">
                </select>
              </div>
              <label class="form-label">Fecha y hora</label>
              <input class="form-control" placeholder="Seleccione la fecha" id="f_fecha"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_cancelar_registro_llamadas">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" disabled id="btn_agregar_registro_llamadas"><i class="fas fa-plus"></i>Agregar nuevo registro de llamada</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="md_afectar_registro_llamadas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Afectar registro de llamadas <i class="fas fa-exclamation-triangle"></i></h5><!--Cambiar------------------>

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
