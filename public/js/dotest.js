/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/dotest.js ***!
  \********************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/*!Vinicius de Santana*/
//https://javascript-minifier.com/
//https://skalman.github.io/UglifyJS-online/
(function ssw(window, document, console, querySelector, querySelectorAll) {
  // nav menu
  document.addEventListener("DOMContentLoaded", DOMContentLoaded);
  window.addEventListener("load", load);
  /** O evento DOMContentLoaded é acionado quando todo o HTML foi
   * completamente carregado e analisado, sem aguardar pelo CSS, imagens,
   * e subframes para encerrar o carregamento.
   */

  function DOMContentLoaded(evt) {
    var prevButton = querySelector('#prev');
    prevButton.addEventListener('click', prevEvt);
    var nextButton = querySelector('#next');
    nextButton.addEventListener('click', nextEvt);
  }
  /** O evento de carga é disparado quando toda a página é carregada,
   * incluindo todos os recursos dependentes, como folhas de estilo e imagens.
   */


  function load(evt) {//
  }
  /**
   * lança o evento de voltar doform
   */


  function prevEvt() {
    // encontra o fieldset atualmente ativo
    var fieldsets = querySelectorAll('fieldset');

    var _iterator = _createForOfIteratorHelper(fieldsets),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var field = _step.value;
        var isActive = field.classList.contains('active'); // ao encontrar o ativo, verifica se todos os selects estão preechidos

        if (isActive) {
          // se ativo verifico se há um item anterior
          var elemAnterior = field.previousElementSibling;

          if (elemAnterior) {
            field.classList.remove('active');
            field.previousElementSibling.classList.add('active'); // volto um passo na barra de progresso

            var progressItens = querySelectorAll('.progress li');

            var _iterator2 = _createForOfIteratorHelper(progressItens),
                _step2;

            try {
              progItens: for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
                var progItem = _step2.value;

                // se passei do último elemento ativo 
                if (!progItem.classList.contains('ativo')) {
                  progItem.previousElementSibling.classList.remove('ativo');
                  break progItens;
                } // se já estou no último elemento da barra e não há proximo


                if (!progItem.nextElementSibling) {
                  progItem.classList.remove('ativo');
                }
              }
            } catch (err) {
              _iterator2.e(err);
            } finally {
              _iterator2.f();
            } // se não há elemento anterior, desativo o prev button


            if (!elemAnterior.previousElementSibling) {
              var prevButton = querySelector('#prev');
              prevButton.classList.add('disabled');
            }
          }
        }
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
  }
  /**
   * lança o evento de next doform
   */


  function nextEvt() {
    // encontra o fieldset atualmente ativo
    var fieldsets = querySelectorAll('fieldset');

    var _iterator3 = _createForOfIteratorHelper(fieldsets),
        _step3;

    try {
      for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
        var field = _step3.value;
        var isActive = field.classList.contains('active'); // ao encontrar o ativo, verifica se todos os selects estão preechidos

        if (isActive) {
          var selects = field.querySelectorAll('select');

          var _iterator4 = _createForOfIteratorHelper(selects),
              _step4;

          try {
            for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
              var select = _step4.value;

              if (select.value === '') {
                // se algum vazio, retorna um alert
                return alert('Preencha todos os dados da página');
              }
            } // habilita o botão anterior caso esteja desativado ainda

          } catch (err) {
            _iterator4.e(err);
          } finally {
            _iterator4.f();
          }

          var prevButton = querySelector('#prev');
          prevButton.classList.remove('disabled'); // se ativo verifico se há um próximo item

          if (field.nextElementSibling) {
            field.classList.remove('active');
            field.nextElementSibling.classList.add('active'); // dou um passo na barra de progresso

            var progressItens = querySelectorAll('.progress li');

            var _iterator5 = _createForOfIteratorHelper(progressItens),
                _step5;

            try {
              progItens: for (_iterator5.s(); !(_step5 = _iterator5.n()).done;) {
                var progItem = _step5.value;

                // verifico se há um próximo item
                if (!progItem.classList.contains('ativo')) {
                  progItem.classList.add('ativo');
                  break progItens;
                }
              }
            } catch (err) {
              _iterator5.e(err);
            } finally {
              _iterator5.f();
            }

            return true;
          } // se não há próximo, envio o form


          document.forms.dotest.submit();
        }
      }
    } catch (err) {
      _iterator3.e(err);
    } finally {
      _iterator3.f();
    }
  }
})(window, document, console, function (x) {
  return document.querySelector(x);
}, function (x) {
  return document.querySelectorAll(x);
});
/******/ })()
;