/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/functions.js ***!
  \***********************************/
$(function () {
  var atual_fs, next_fs, prev_fs;
  var formulario = $('form[name=formulario]');

  function next(elem) {
    atual_fs = $(elem).parent();
    next_fs = $(elem).parent().next();
    $('#progress li').eq($('fieldset').index(next_fs)).addClass('ativo');
    atual_fs.hide(800);
    next_fs.show(800);
  }

  $('.prev').click(function () {
    atual_fs = $(this).parent();
    prev_fs = $(this).parent().prev();
    $('#progress li').eq($('fieldset').index(atual_fs)).removeClass('ativo');
    atual_fs.hide(800);
    prev_fs.show(800);
  });
  $('input[name=next1]').click(function () {
    var array = formulario.serializeArray();

    if (array[0].value == '') {
      $('.resp').html('<div class="erros"><p>Preencha os dados da primeira etapa.</p></div>');
    } else {
      $('.resp').html('');
      next($(this));
    }
  });
  $('input[name=next2]').click(function () {
    var array = formulario.serializeArray();

    if (array[0].value == '') {
      $('.resp').html('<div class="erros"><p>Preencha os dados da segunda etapa.</p></div>');
    } else {
      $('.resp').html('');
      next($(this));
    }
  });
  $('input[name=next3]').click(function () {
    var array = formulario.serializeArray();

    if (array[0].value == '') {
      $('.resp').html('<div class="erros"><p>Preencha os dados da segunda etapa.</p></div>');
    } else {
      $('.resp').html('');
      next($(this));
    }
  });
  formulario.submit(function (evento) {
    var array = formulario.serializeArray();
    /*PASSANDO OS DADOS ARMAZENADOS PARA UM ARRAY JSON*/

    $.ajax({
      method: 'post',
      url: 'forms/certificacao.php',
      data: {
        cadastrar: 'sim',
        campos: array
      },
      dataType: 'json',
      beforeSend: function beforeSend() {
        $('.resp').html('<div class="ok"><p>Aguarde enquanto enviamos sua resposta</p></div>');
        $('input[type=submit]').css({
          'display': 'none'
        });
        $('input[type=button]').css({
          'display': 'none'
        });
      },
      success: function success(valor) {
        if (valor.erro == 'sim') {
          $('.resp').html('<div class="erros"><p>' + valor.getErro + '</p></div>');
        } else {
          $('.resp').html('<div class="ok"><p>' + valor.mensagem + '</p>');
          setTimeout(function () {
            $('.resp').html('<div class="download"><a href="pdf/template/emitir-certificado.php" target="_blank">Clique para emitir seu Certificado</a></div>');
          }, 4000);
        }
      }
    });
    evento.preventDefault();
  });
});
/******/ })()
;