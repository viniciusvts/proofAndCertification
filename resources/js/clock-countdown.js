/*!Vinicius de Santana*/
//https://javascript-minifier.com/
//https://skalman.github.io/UglifyJS-online/
(function ssw(window, document, console, querySelector, querySelectorAll) {
    // nav menu
    document.addEventListener("DOMContentLoaded", DOMContentLoaded);
    /** O evento DOMContentLoaded é acionado quando todo o HTML foi
     * completamente carregado e analisado, sem aguardar pelo CSS, imagens,
     * e subframes para encerrar o carregamento.
     */
    function DOMContentLoaded(evt) {
        initCountdown();
    }

    /** O evento de carga é disparado quando toda a página é carregada,
     * incluindo todos os recursos dependentes, como folhas de estilo e imagens.
     */
    function initCountdown() {
        var countdowndiv = querySelector('[data-time_to_finish]');
        this.time_to_finish = countdowndiv.dataset.time_to_finish;
        this.timeInMili = this.time_to_finish * 60 * 1000;
        this.divHora = countdowndiv.querySelector('.hour');
        this.divMin = countdowndiv.querySelector('.min');
        this.divSec = countdowndiv.querySelector('.sec');

        this.countdownInterval = setInterval(()=>{ setCountdown(); }, 1000);
        this.formDiv = querySelector('#dotest');
        formDiv.addEventListener('submit', function(){
            clearInterval(countdownInterval);
        })
    }

    function setCountdown(){
        // define os valores em milisegundos
        const secInMilli = 1000;
        const minInMilli = secInMilli * 60;
        const hourInMilli = minInMilli * 60;
        var aux = this.timeInMili
        // obtem quantas horas faltam e diminui a diferença
        const hours = Math.floor(aux / hourInMilli);
        aux = aux - (hours * hourInMilli);
        // obtem quantas minuutos faltam e diminui a diferença
        const min = Math.floor(aux / minInMilli);
        aux = aux - (min * minInMilli);
        // obtem quantas segundos faltam e diminui a diferença
        const sec = Math.floor(aux / secInMilli);
        // printa no contador
        this.divHora.innerText = hours;
        if(hours < 10) this.divHora.prepend('0');
        this.divMin.innerText = min;
        if(min < 10) this.divMin.prepend('0');
        this.divSec.innerText = sec;
        if(sec < 10) this.divSec.prepend('0');
        if (!(hours || min || sec)){
            //envia o form.submit
            this.formDiv.submit();
            clearInterval(this.countdownInterval);
        }
        // tira um segundo do tempo
        this.timeInMili -= 1000;
    }

})(window, document, console, x=>document.querySelector(x), x=>document.querySelectorAll(x));

// /**
//  * classe que define o countdown
//  * @param {HTMLElement} _div div do contator que possui a estrutura esperada
//  * @param {Date} _finishDate data final do contator
//  * @author Vinicius de Santana
//  */
// function Countdown(_div) {
//     try {
//         this.time_to_finish = _div.dataset.time_to_finish;
//         this.divHora = _div.querySelector('.hour');
//         this.divMin = _div.querySelector('.min');
//         this.divSec = _div.querySelector('.sec');
//     } catch (error) {
//         throw new TypeError('parametro não é uma div válida');
//     }
//     this.setCountdown = _setCountdown;
//     this.countdownInterval = setInterval(()=>{ this.setCountdown(this.time_to_finish) }, 1000);
//     // um evento que, quando o submit for clicado encerra o contador
//     /** preservar contexto da classe */
//     var that = this;
//     document.querySelector('[data-time_to_finish]').addEventListener('submit', function(){
//         console.log('form submit event');
//         clearInterval(that.countdownInterval);
//     });

//     /**
//      * função seta o horário no front partir de uma data
//      * @param {Date} _time_to_finish tempo em minutos do backend
//      * @author Vinicius de Santana
//      */
//     function _setCountdown(_time_to_finish) {
//         // define os valores em milisegundos
//         const secInMilli = 1000;
//         const minInMilli = secInMilli * 60;
//         const hourInMilli = minInMilli * 60;
//         // define em quanto tempo em mili segundos vamos contar
//         let timeInMili = _time_to_finish * minInMilli;
//         // obtem quantas horas faltam e diminui a diferença
//         const hours = Math.floor(timeInMili / hourInMilli);
//         timeInMili = timeInMili - (hours * hourInMilli);
//         // obtem quantas minuutos faltam e diminui a diferença
//         const min = Math.floor(timeInMili / minInMilli);
//         timeInMili = timeInMili - (min * minInMilli);
//         // obtem quantas segundos faltam e diminui a diferença
//         const sec = Math.floor(timeInMili / secInMilli);
//         // printa no contador
//         this.divHora.innerText = hours;
//         if(hours < 10) this.divHora.prepend('0');
//         this.divMin.innerText = min;
//         if(min < 10) this.divMin.prepend('0');
//         this.divSec.innerText = sec;
//         if(sec < 10) this.divSec.prepend('0');
//         if (!(hours || min || sec)){
//             //envia o form.submit
//             document.querySelector('#dotest').submit();
//             clearInterval(this.countdownInterval);
//         }
//     }
// }

// window.addEventListener('load', function() {
//     div = document.querySelector('[data-time_to_finish]');
//     countdown = new Countdown(div);
// })