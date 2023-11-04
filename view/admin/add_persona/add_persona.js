let g__tipo_persona = [];
let g__stepper = "";



function init() {
  // Stepper element
  var element = document.querySelector("#kt_stepper_example_vertical");

  // Initialize Stepper
  g__stepper = new KTStepper(element);

  LoadTipoPersona();

}
init();

$('#tipo_persona_tab input').on('change', function() {
  alert();

});

function LoadTipoPersona() {
  fetch('<?=PATH_API?>tipo_persona/read.php')
    .then(r => r.json())
    .then(data => g__tipo_persona = data.document.records)
    .then(() => viewTipoPersona(g__tipo_persona));
}

function viewTipoPersona(data) {
  let content = "";
  data.forEach(item => {
    // <input type="radio" class="btn-check" name="tipo_persona_option" value="${item.id_tipo_persona}" id="tipo-persona-${item.id_tipo_persona}"/>
    // <label class="btn btn-outline btn-outline-secondary p-7 d-flex align-items-center mb-5" for="tipo-persona-${item.id_tipo_persona}">
    //   <span class="me-4">
    //     <i class="fas fa-portrait fa-2x" style="font-size: 2em;"></i>
    //   </span>
    //
    //   <span class="d-block fw-bold text-start">
    //     <span class="text-dark fw-bolder d-block fs-3">${item.tipo_persona}</span>
    //
    //   </span>
    // </label>
    content += `
    <!--begin::Radio button-->
    <label class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
        <!--end::Description-->
        <div class="d-flex align-items-center me-2">
            <!--begin::Radio-->
            <div class="form-check form-check-custom form-check-solid form-check-success me-6">
                <input class="form-check-input" type="radio" name="tipo_persona_option" value="${item.id_tipo_persona}"/>
            </div>
            <!--end::Radio-->

            <!--begin::Info-->
            <div class="flex-grow-1">
                <h2 class="d-flex align-items-center fs-3 fw-bolder flex-wrap">
                    ${item.tipo_persona}
                </h2>
            </div>
            <!--end::Info-->
        </div>
        <!--end::Description-->
    </label>
    <!--end::Radio button-->
    `
  });
  findone("#tipo_persona_tab").innerHTML = content;
}

/*******************************Inicializacion de plugins**************************************/



// Handle next step
g__stepper.on("kt.stepper.next", function(g__stepper) {
  if (g__stepper.getCurrentStepIndex()==1) {
    alert('kiubo papi')
  }
  switch ($("input[name='tipo_persona_option']:checked").val()) {
    case '1':

      break;
    case '2':

      break;
    case '3':

      break;
    case '4':

      break;
    case '5':

      break;
    case '6':

      break;

    default:

  }
  g__stepper.goNext(); // go next step
});

// Handle previous step
g__stepper.on("kt.stepper.previous", function(g__stepper) {
  g__stepper.goPrevious(); // go previous step
});

var myDropzone = new Dropzone("#dropzone_profile_pic", {
  url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
  paramName: "file", // The name that will be used to transfer the file
  maxFiles: 10,
  maxFilesize: 10, // MB
  addRemoveLinks: true,
  accept: function(file, done) {
    if (file.name == "wow.jpg") {
      done("Naha, you don't.");
    } else {
      done();
    }
  }
});

var myDropzone = new Dropzone("#dropzone_cv", {
  url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
  paramName: "file", // The name that will be used to transfer the file
  maxFiles: 1,
  maxFilesize: 10, // MB
  addRemoveLinks: true,
  accept: function(file, done) {
    if (file.name == "wow.jpg") {
      done("Naha, you don't.");
    } else {
      done();
    }
  }
});


$("#fecha_nacimiento").flatpickr();
