<div class="modal fade" tabindex="-1" id="modal_agregar">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h5 class="modal-title">Nuevo usuario</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>


            <div class="modal-body" id="add_usuario_modal_body">
                
                <label class="form-label">Buscar persona por nombre</label>
                <div class="form-group">
                    <label for=""> Ingresa el nombre y busca una persona: </label>
                    <input type="search" autocomplete="off" class="form-control" id="buscar_persona-nombre" placeholder="Nombre">
                </div>
                <br>
                <select class="form-select" aria-label="Select example"  id="f_selec_persona">
                    <option value="null"> Digite un nombre arriba para buscar </option>
                </select>

                <br><br>
                <label for="" class="form-label">Nombre usuario</label>
                <input type="text" class="form-control" id="f_nombre_usuario"/>
                <br>

                <label for="" class="form-label">Constraseña</label>
                <input type="password" type="text" class="form-control" id="f_login_password"/>
                <br>
                <hr>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_calcelar_nuevo_usuario">Cancelar</button>
                <button onclick="crearUsuarioEvent()" type="button" class="btn btn-primary" id="btn_agregar_nuevo_usuario"><i class="fas fa-plus"></i>Agregar nuevo usuario</button>



            </div>

            
        </div>
    </div>
</div>





<div class="modal fade" tabindex="-1" id="modal_eliminar">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h5 class="modal-title">Eliminar Usuario</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>


            <div class="modal-body" id="delete_usuario_modal_content">
                
                <label class="form-label">¿De verdad quieres eliminar este usuario?</label>
                <br>
                <hr>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btn_calcelar_nuevo_usuario">
                    Cancelar
                </button>
                <button onclick="executeEliminarUsuario()" type="button" class="btn btn-danger" id="btn_agregar_nuevo_usuario">
                    <i class="fas fa-trash"></i> Eliminar
                </button>



            </div>

            
        </div>
    </div>
</div>








<!--begin::Card-->
<div class="card card-bordered" id="usuarios-card">


    <div id="pagination_example"></div>


    <div class="card-header" id="usuarios-main-contianer">
        <h3 class="card-title">Lista de Usuarios</h3>
        <div class="card-toolbar">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_agregar">
              <i class="fas fa-plus" id="test"></i>Agregar nuevo usuario
          </button>
        </div>
    </div>
    <div class="card-body table-responsive" id="usuarios-main-contianer2">
      <!--begin::table-->

      <table id="datatable_usuarios" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%;">
          <thead>
              <tr class="fw-bold fs-6 text-muted">
                  <th>ID Usuario</th>
                  <th>ID Persona</th>
                  <th>Nombre</th>
                  <th>Nombre Usuario</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
      <!--end::table-->

    </div>
    <div class="card-footer" id="users_pagination_container">
        
        <!-- <nav aria-label="Page navigation example">

            <ul class="pagination justify-content-center">
                <li id="pagina_anterior" class="page-item" onclick="movePage(-1)">
                    <button id="pagina_anterior-btn" class="page-link disabled">Anterior</button>
                </li>
                <li class="page-item disabled">
                    <span class="page-link">
                        Página: 
                        <span id="current_page_label" class="mx-2">1</span> 
                        de 
                        <span id="max_page_label" class="mx-2"></span>
                    </span>
                </li>
                <li id="pagina_siguiente" class="page-item" onclick="movePage(1)">
                    <button id="pagina_siguiente-btn" class="page-link">Siguiente</button>
                </li>
            </ul>
        </nav> -->
    </div>
</div>
<!--end::card-->