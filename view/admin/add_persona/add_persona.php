<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Agregar Persona</h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light">
                Volver
            </button>
        </div>
    </div>
    <div class="card-body">
      <!--begin::Stepper-->
      <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="kt_stepper_example_vertical">
          <!--begin::Aside-->
          <div class="d-flex flex-row-auto w-100 w-lg-300px">
              <!--begin::Nav-->
              <div class="stepper-nav flex-cente">
                  <!--begin::Step 1-->
                  <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                      <!--begin::Line-->
                      <div class="stepper-line w-40px"></div>
                      <!--end::Line-->

                      <!--begin::Icon-->
                      <div class="stepper-icon w-40px h-40px">
                          <i class="stepper-check fas fa-check"></i>
                          <span class="stepper-number">1</span>
                      </div>
                      <!--end::Icon-->

                      <!--begin::Label-->
                      <div class="stepper-label">
                          <h3 class="stepper-title">
                              Tipo Persona
                          </h3>

                          <div class="stepper-desc">
                              En esta etapa se selecciona el tipo de persona que se desea crear
                          </div>
                      </div>
                      <!--end::Label-->
                  </div>
                  <!--end::Step 1-->

                  <!--begin::Step 2-->
                  <div class="stepper-item me-5" data-kt-stepper-element="nav">
                      <!--begin::Line-->
                      <div class="stepper-line w-40px"></div>
                      <!--end::Line-->

                      <!--begin::Icon-->
                      <div class="stepper-icon w-40px h-40px">
                          <i class="stepper-check fas fa-check"></i>
                          <span class="stepper-number">2</span>
                      </div>
                      <!--begin::Icon-->

                      <!--begin::Label-->
                      <div class="stepper-label">
                          <h3 class="stepper-title">
                              informacion Personal
                          </h3>

                          <div class="stepper-desc">
                              Aqui se proporciona la informacion basica de la persona
                          </div>
                      </div>
                      <!--end::Label-->
                  </div>
                  <!--end::Step 2-->

                  <!--begin::Step 3-->
                  <div class="stepper-item me-5 d-none" data-kt-stepper-element="nav">
                      <!--begin::Line-->
                      <div class="stepper-line w-40px"></div>
                      <!--end::Line-->

                      <!--begin::Icon-->
                      <div class="stepper-icon w-40px h-40px">
                          <i class="stepper-check fas fa-check"></i>
                          <span class="stepper-number">3</span>
                      </div>
                      <!--begin::Icon-->

                      <!--begin::Label-->
                      <div class="stepper-label">
                          <h3 class="stepper-title">
                              Step 3
                          </h3>

                          <div class="stepper-desc">
                              Description
                          </div>
                      </div>
                      <!--end::Label-->
                  </div>
                  <!--end::Step 3-->

                  <!--begin::Step 4-->
                  <div class="stepper-item me-5 d-none" data-kt-stepper-element="nav">
                      <!--begin::Line-->
                      <div class="stepper-line w-40px"></div>
                      <!--end::Line-->

                      <!--begin::Icon-->
                      <div class="stepper-icon w-40px h-40px">
                          <i class="stepper-check fas fa-check"></i>
                          <span class="stepper-number">4</span>
                      </div>
                      <!--begin::Icon-->

                      <!--begin::Label-->
                      <div class="stepper-label">
                          <h3 class="stepper-title">
                              Step 4
                          </h3>

                          <div class="stepper-desc">
                              Description
                          </div>
                      </div>
                      <!--end::Label-->
                  </div>
                  <!--end::Step 4-->
              </div>
              <!--end::Nav-->
          </div>

          <!--begin::Content-->
          <div class="flex-row-fluid">
              <!--begin::Form-->
              <form class="form w-lg-500px mx-auto" novalidate="novalidate">
                  <!--begin::Group-->
                  <div class="mb-5">
                      <!--begin::Step 1-->
                      <div class="flex-column current" data-kt-stepper-element="content">
                        <div id="tipo_persona_tab" data-kt-buttons="true">




                        </div>
                      </div>
                      <!--begin::Step 1-->

                      <!--begin::Step 2-->
                      <div class="flex-column" data-kt-stepper-element="content">
                        <div class="row">
                          <div class="form-floating mb-7 col-8">
                            <input type="text" class="form-control" id="identificacion" placeholder="00000000000"/>
                            <label class="required" for="identificacion">Identificacion</label>
                          </div>

                        </div>
                        <div class="row">
                          <div class="form-floating mb-7 col-4">
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre"/>
                            <label class="required" for="nombre">Nombre</label>
                          </div>
                          <div class="form-floating mb-7 col-4">
                            <input type="text" class="form-control" id="primer_apellido" placeholder="Primer Apellido"/>
                            <label for="primer_apellido">Primer Apellido</label>
                          </div>
                          <div class="form-floating mb-7 col-4">
                            <input type="text" class="form-control" id="segundo_apellido" placeholder="Segundo Apellido"/>
                            <label for="segundo_apellido">Segundo Apellido</label>
                          </div>
                        </div>

                        <div class="row">
                          <div class="mb-7">
                              <label for="" class="form-label">Fecha de nacimiento</label>
                              <input class="form-control col-6" placeholder="Selecciona una fecha" id="fecha_nacimiento"/>
                          </div>
                        </div>

                        <div class="row mb-7">
                          <div class="input-group flex-nowrap">
                              <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                              <div class="overflow-hidden flex-grow-1">
                                  <select id="select_pais" class="form-select rounded-start-0" data-control="select2" data-placeholder="Selecciona un pais">
                                      <option></option>
                                      <option value="1">Option 1</option>
                                      <option value="2">Option 2</option>
                                      <option value="3">Option 3</option>
                                      <option value="4">Option 4</option>
                                      <option value="5">Option 5</option>
                                  </select>
                              </div>
                          </div>
                        </div>

                        <div class="row mb-7">
                          <div class="input-group flex-nowrap">
                              <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                              <div class="overflow-hidden flex-grow-1">
                                  <select id="select_club" class="form-select rounded-start-0" data-control="select2" data-placeholder="Selecciona el club al que pertenece">
                                      <option></option>
                                      <option value="1">Option 1</option>
                                      <option value="2">Option 2</option>
                                      <option value="3">Option 3</option>
                                      <option value="4">Option 4</option>
                                      <option value="5">Option 5</option>
                                  </select>
                              </div>
                          </div>
                        </div>

                        <div class="row mb-7">
                          <div class="input-group flex-nowrap">
                              <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                              <div class="overflow-hidden flex-grow-1">
                                  <select id="select_grado_academico" class="form-select rounded-start-0" data-control="select2" data-placeholder="Selecciona el grado academico">
                                      <option></option>
                                      <option value="1">Option 1</option>
                                      <option value="2">Option 2</option>
                                      <option value="3">Option 3</option>
                                      <option value="4">Option 4</option>
                                      <option value="5">Option 5</option>
                                  </select>
                              </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="fv-row col-6">
                            <div class="dropzone" id="dropzone_profile_pic">
                              <div class="dz-message needsclick">
                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                <div class="ms-4">
                                  <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Foto de perfil</h3>
                                  <span class="fs-7 fw-bold text-gray-400">Selecciona la foto de perfil de la persona</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="fv-row col-6">
                            <div class="dropzone" id="dropzone_cv">
                              <div class="dz-message needsclick">
                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                <div class="ms-4">
                                  <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Subir CV</h3>
                                  <span class="fs-7 fw-bold text-gray-400">Selecciona el archivo de CV de la persona</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--begin::Step 2-->

                      <!--begin::Step 3-->
                      <div class="flex-column" data-kt-stepper-element="content">
                          <!--begin::Input group-->
                          <div class="fv-row mb-10">
                              <!--begin::Label-->
                              <label class="form-label d-flex align-items-center">
                                  <span class="required">Input 1</span>
                                  <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Example tooltip"></i>
                              </label>
                              <!--end::Label-->

                              <!--begin::Input-->
                              <input type="text" class="form-control form-control-solid" name="input1" placeholder="" value=""/>
                              <!--end::Input-->
                          </div>
                          <!--end::Input group-->

                          <!--begin::Input group-->
                          <div class="fv-row mb-10">
                              <!--begin::Label-->
                              <label class="form-label">
                                  Input 2
                              </label>
                              <!--end::Label-->

                              <!--begin::Input-->
                              <input type="text" class="form-control form-control-solid" name="input2" placeholder="" value=""/>
                              <!--end::Input-->
                          </div>
                          <!--end::Input group-->
                      </div>
                      <!--begin::Step 3-->

                      <!--begin::Step 4-->
                      <div class="flex-column" data-kt-stepper-element="content">
                          <!--begin::Input group-->
                          <div class="fv-row mb-10">
                              <!--begin::Label-->
                              <label class="form-label d-flex align-items-center">
                                  <span class="required">Input 1</span>
                                  <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Example tooltip"></i>
                              </label>
                              <!--end::Label-->

                              <!--begin::Input-->
                              <input type="text" class="form-control form-control-solid" name="input1" placeholder="" value=""/>
                              <!--end::Input-->
                          </div>
                          <!--end::Input group-->

                          <!--begin::Input group-->
                          <div class="fv-row mb-10">
                              <!--begin::Label-->
                              <label class="form-label">
                                  Input 2
                              </label>
                              <!--end::Label-->

                              <!--begin::Input-->
                              <input type="text" class="form-control form-control-solid" name="input2" placeholder="" value=""/>
                              <!--end::Input-->
                          </div>
                          <!--end::Input group-->

                          <!--begin::Input group-->
                          <div class="fv-row mb-10">
                              <!--begin::Label-->
                              <label class="form-label">
                                  Input 3
                              </label>
                              <!--end::Label-->

                              <!--begin::Input-->
                              <input type="text" class="form-control form-control-solid" name="input3" placeholder="" value=""/>
                              <!--end::Input-->
                          </div>
                          <!--end::Input group-->
                      </div>
                      <!--begin::Step 4-->
                  </div>
                  <!--end::Group-->

                  <!--begin::Actions-->
                  <div class="d-flex flex-stack">
                      <!--begin::Wrapper-->
                      <div class="me-2">
                          <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                              Back
                          </button>
                      </div>
                      <!--end::Wrapper-->

                      <!--begin::Wrapper-->
                      <div>
                          <button type="button" class="btn btn-primary" data-kt-stepper-action="submit">
                              <span class="indicator-label">
                                  Submit
                              </span>
                              <span class="indicator-progress">
                                  Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                              </span>
                          </button>

                          <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                              Continue
                          </button>
                      </div>
                      <!--end::Wrapper-->
                  </div>
                  <!--end::Actions-->
              </form>
              <!--end::Form-->
          </div>
      </div>
      <!--end::Stepper-->

    </div>

</div>

<!--begin::Radio group-->

<!--end::Radio group-->
