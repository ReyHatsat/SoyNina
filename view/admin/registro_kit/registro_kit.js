//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto registro kit-----------------------//
  function generarObjetoRegistroKit(){
    return {
      registro_kit:{
        id_registro:$("#f_registro").val(),
        id_kit:$("#f_kit").val(),
        recibido:$("#f_recibido").val(),
        detalles:$("#f_detalles").val(),
        active:1,
      }
    }
  }
  //-----------------------End Creación de objeto registro kit-----------------------//
  //-----------------------Creación de objeto cat kit-----------------------//
  function generarObjetoCatKit(){
    return {
      cat_kit:{
        kit:$("#f_nombre_kit").val(),
        active:1,
      }
    }
  }
  //-----------------------End Creación de objeto cat kit-----------------------//
//-----------------------End Creación de objeto-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_agregar_nuevo_registro_kit").click(function(){
  console.log(generarObjetoRegistroKit());
});
$("#f_kit").click(function(){
  if ($("#f_kit").val() == "n") {
    $("#d_kit").removeClass("d-none");
  }
  if ($("#f_kit").val() != "n") {
    $("#d_kit").addClass("d-none");
  }
});
$("#btn_calcelar_nuevo_kit").click(function(){
  $("#f_kit").val(0);
  $("#d_kit").addClass("d-none");
});
$("#btn_crear_nuevo_kit").click(function(){
  console.log(generarObjetoCatKit());
  $("#f_kit").val(0);
  $("#d_kit").addClass("d-none");
});
//-----------------------End Eventos del formulario-----------------------//
