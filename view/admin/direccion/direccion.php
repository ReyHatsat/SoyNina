<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <div id="titulo_nueva_direccion">
                <h5 class="modal-title">Nueva dirección</h5>
              </div>
              <div id="titulo_editar_direccion">
                <h5 class="modal-title">Afectar Dirección <i class="fas fa-exclamation-triangle"></i></h5><!--Cambiar------------------>
              </div>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
            <div>
            <label for="" class="form-label">Seleccione la Provincia</label><br/>
            <label class="form-label">Provincia</label>
              <select class="form-select" aria-label="Select example" id="f_provincia">
                <option value="0" selected disabled>Seleccione una opción</option>
              </select>
            <br>
            <div class="d-none" id="d_canton">
            <label class="form-label">Cantón</label>
              <select class="form-select" aria-label="Select example" id="f_canton">
              </select>
              <br>
            </div>
            <div class="d-none" id="d_distrito">
              <label class="form-label">Distrito</label>
              <select class="form-select" aria-label="Select example" id="f_distrito">
              </select>
              <br>
            </div>
            </div>
              <label class="form-label">Otras señas</label>
              <input type="text" class="form-control" id="f_otras_senas"/>
            <div class="modal-footer" id="d_botones_nuevo">
                <button href="#" class="btn btn-white" data-bs-dismiss="modal" id="btn_calcelar_nueva_direccion">Cancelar</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn_agregar_nueva_direccion" disabled><i class="fas fa-plus"></i>Agregar nueva dirección</button>
            </div>
            <div class="modal-footer" id="d_botones_editar">

            </div>
        </div>
    </div>
</div>
</div>



<div class="card card-bordered">
    <div class="card-header">
        <h3 class="card-title">Lista de direcciones</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1" id="btn_agregar_nueva_direccion_modal">
              <i class="fas fa-plus"></i>Agregar nueva dirección
          </button>
        </div>
    </div>
    <div class="card-body table-responsive">
      <!--begin::table-->
      <table id="dt_direccion" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%;"><!--Cambiar------------------>
          <thead>
              <tr class="fw-bolder fs-6 text-gray-800">
                <th>ID de la dirección</th>
                <th>ID del distrito</th>
                <th>Señas de la dirección</th>
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
                <h5 class="modal-title">Afectar Dirección <i class="fas fa-exclamation-triangle"></i></h5><!--Cambiar------------------>

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
