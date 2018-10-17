
$(document).ready(function(){

  $("body").on('click', 'button', function (event) {
      event.preventDefault();

      // Si el boton no tiene el atributo ajax no hacemos nada
      if ($(this).data('ajax') === undefined)
          return;

      // El metodo .data identifica la entrada y la castea al valor más correcto
      if ($(this).data('ajax') !== true)
          return;

      var form = $(this).closest("form");
      var button = $(this);
      var url = form.attr('action');



      if (button.data('confirm') !== undefined)
      {
          if (button.data('confirm') === '') {
              if (!confirm('¿Esta seguro de realizar esta acción?'))
                  return false;
          } else {
              //Agregar libreria para mostrar mejor los mensajes
              if (!confirm(button.data('confirm')))
                  return false;
          }
      }

      if (button.data('delete') !== undefined)
      {
          if (button.data('delete') === true)
          {
              url = button.data('url');
          }
      }

      // Creamos un div que bloqueara todo el formulario
      var block = $('<div class="block-loading" />');
      form.prepend(block);

      // Alert container
      var alertContainer = form.find('.alert-container');
      alertContainer.html('');

      // Escondomes los errores
      form.find(".form-validation-failed").html('');

      form.ajaxSubmit({
          dataType: 'JSON',
          type: 'POST',
          url: url,
          success: function (r) {
              block.remove();
              console.log(r);

              //console.log(r);
              if (r.response) {
                  if (!button.data('reset') !== undefined) {
                      if (button.data('reset'))
                          form.reset();
                      //spawnNotification("Información enviada con exito",undefined,"Envio de datos");
                  } else
                  {
                      form.find('input:file').val('');
                  }
              }

              // Mostrar mensaje
              if (r.message !== null) {
                  if (r.message.length > 0) {
                      var css = "";
                      if (r.response) {
                          css = "alert-success";
                      } else {
                          css = "alert-danger";
                      }

                      var message = '<div role="alert" class="alert ' + css + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>' + r.message + '</div>';

                      if(alertContainer.length > 0){
                          alertContainer.html(message);
                      } else {
                          form.prepend(message);
                      }
                  }
              }

              // Validaciones
              if(r.validations !== null) {
                for(var k in r.validations) {
                    var vmessage = typeof(r.validations[k]) === 'array' ? r.validations[k][0] : r.validations[k];
                   form.find("[data-key='" + k + "']").html(vmessage);
                }
              }

              // Ejecutar funciones que son especificadas por el servidor
              if (r.function !== null) {

                  setTimeout(r.function, 100);


              }

              // Ejecutar funciones que son especificadas por el cliente
              if (button.data('success') !== undefined && r.response) {
                  setTimeout('{0}()'.format(button.data('success')), 0);
              }

              // Redireccionar
              if (r.href !== null) {

                  if (r.href === 'self') window.location.reload(true);
                  else{

                      var str=r.href.split('/');
                      if(str[0]==='tab'){
                          $($('#' + button.data('target')).prop('elements')).each(function(){
                              if($(this).data('accion')!==undefined){
                                  $(this).disable(true);
                              }
                          });
                          //hayCambios=false;
                          $('#myModal').modal('toggle')
                          $('#modal-body').html('<p>Información guardada con éxito</p>');
                          //$("div[data-toggle='PP']").show();
                          if(button.data('next')!==undefined){
                              $("div[data-toggle='" + button.data('next') + "']").show();
                          }
                      }else{


                              redirect(r.href);

                      }
                  }
              }

              // Si el servidor retorno algo
              if (r.result !== null && button.data('result') !== undefined && r.response) {
                  var resultFunction = button.data('result') + '({0})';
                  resultFunction = resultFunction.format(JSON.stringify(r.result));
                  setTimeout(resultFunction, 0);
              }
          },
          error: function (jqXHR, textStatus, errorThrown) {

              if (jqXHR.status === 422) {
                  for(var k in jqXHR.responseJSON) {
                      var control = form.find('.validation-message[data-target="' + k + '"]');
                      control.text(jqXHR.responseJSON[k][0]);
                      control.css('display', 'block');
                  }
              } else {
                  var message = '<div class="alert alert-warning alert-dismissable response-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errorThrown + ' | <b>' + textStatus + '</b></div>';

                  if(alertContainer.length > 0){
                      alertContainer.html(message);
                  }
              }

              block.remove();
          }
      });

      return false;
  })
});

/*


if (!String.prototype.ucfirst) {
    String.prototype.ucfirst = function () {
        if(this.length > 0) {
          return this.substring(0, 1).toUpperCase() + this.substring(1, this.length);
        }
    }
}

if (!String.prototype.format) {
    String.prototype.format = function () {
        var text = this;

        for (var i = 0; i < arguments.length; i++) {
            text = text.replace("{" + i + "}", arguments[i]);
        }

        return text;
    }
}

if (!String.prototype.render) {
    String.prototype.render = function (obj) {
        var text = this;

        for (var k in obj) {
            text = text.replace("{" + k + "}", obj[k]);
        }

        return text;
    }
}

if (!Number.prototype.toMonth) {
    Number.prototype.toMonth = function () {
        var m = '';

        switch (parseInt(this)) {
            case 1:
                m = 'Enero';
                break;
            case 2:
                m = 'Febrero';
                break;
            case 3:
                m = 'Marzo';
                break;
            case 4:
                m = 'Abril';
                break;
            case 5:
                m = 'Mayo';
                break;
            case 6:
                m = 'Junio';
                break;
            case 7:
                m = 'Julio';
                break;
            case 8:
                m = 'Agosto';
                break;
            case 9:
                m = 'Setiembre';
                break;
            case 10:
                m = 'Octubre';
                break;
            case 11:
                m = 'Noviembre';
                break;
            case 12:
                m = 'Diciembre';
                break;
        }

        return m;
    };
}

if (!Number.prototype.format) {
    Number.prototype.format = function (decimals, moneySymbol) {
        decimals = decimals || 0;
        moneySymbol = moneySymbol || false;
        moneySymbol = moneySymbol ? 'USD' : '';

        return moneySymbol + this.toFixed(decimals).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    };
}

if (!Number.prototype.padLeft) {
    Number.prototype.padLeft = function (n) {
        n = n || 0;

        var zeros = '';

        for (var i = 0; i < n; i++) {
            zeros += '0';
        }

        return zeros.substring(0, zeros.length - this.toString().length) + this.toString();
    };
}

if (!moment.prototype.defaultFormat) {
    moment.prototype.defaultFormat = function () {
        return moment(this).format('DD/MM/YYYY');
    }
}

function mergeObjects(obj1, obj2) {
    for (var k in obj2) {
        obj1[k] = obj2[k];
    }

    return obj1;
}

function isNullOrEmpty(x) {
    if (x === undefined) return true;
    if (x === null) return true;
    if (x.toString().trim().length === 0) return true;
}


function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

jQuery.fn.extend({
    disable: function(state) {
        return this.each(function() {
            var $this = $(this);
            $this.prop('disabled', state);
        });
    }
});

jQuery.fn.reset = function () {
  $("input", $(this)).each(function(){
    var type = $(this).attr('type');

    if(type === 'checkbox' && $(this).is('checked')) {
      $(this).click();
    } else {
      $(this).val('');
    }
  })

  $("select", $(this)).val(0);
};
*/

