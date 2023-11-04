//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto nuevo telefono-----------------------//
  function generarObjetoTelefono(){
    var numero = $("#f_numero").val().replace(/[() -]/g,'');
    return {
      telefono:{
        numero:numero,
        active:1,
      }
    }
  }
  //-----------------------End Creación de objeto nuevo telefono-----------------------//
  //-----------------------Creación de objeto nuevo telefono persona-----------------------//
  function generarObjetoTelefonoPersona(){
    return {
      telefono_persona:{
        id_persona:$("#f_persona").val(),
        id_telefono:$("#f_telefono").val(),
        active:1,
      }
    }
  }
  //-----------------------Creación de objeto nuevo telefono persona-----------------------//
//-----------------------End Creación de objeto-----------------------//
//-----------------------Eventos del formulario-----------------------//
Inputmask({
    "mask" : "(999) 9999-9999"
}).mask("#f_numero");
$("#f_telefono").click(function(){
  if ($("#f_telefono").val() == "n") {
    $("#d_telefono").removeClass("d-none");
  }
  if ($("#f_telefono").val() != "n") {
    $("#d_telefono").addClass("d-none");
  }
});
$("#btn_calcelar_nuevo_numero").click(function(){
  $("#d_telefono").addClass("d-none");
  $("#f_telefono").val(0);
});
$("#btn_crear_nuevo_numero").click(function(){
  console.log(generarObjetoTelefono());
  $("#d_telefono").addClass("d-none");
});
$("#btn_calcelar_telefono_persona").click(function(){
  $("#f_persona").val(0);
  $("#f_telefono").val(0);
});
$("#btn_crear_telefono_persona").click(function(){
  console.log(generarObjetoTelefonoPersona());
});
//-----------------------End Eventos del formulario-----------------------//
