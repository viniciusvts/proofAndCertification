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
    function load(evt) {
        //
    }

    /**
     * lança o evento de voltar doform
     */
    function prevEvt (){
        // encontra o fieldset atualmente ativo
        var fieldsets = querySelectorAll('fieldset');
        for (const field of fieldsets) {
            var isActive = field.classList.contains('active');
            // ao encontrar o ativo, verifica se todos os selects estão preechidos
            if (isActive){
                // se ativo verifico se há um item anterior
                var elemAnterior = field.previousElementSibling
                if (elemAnterior){
                    field.classList.remove('active');
                    field.previousElementSibling.classList.add('active');
                    // volto um passo na barra de progresso
                    var progressItens = querySelectorAll('.progress li');
                    progItens:for (const progItem of progressItens) {
                        // se passei do último elemento ativo 
                        if (!progItem.classList.contains('ativo')){
                            progItem.previousElementSibling.classList.remove('ativo');
                            break progItens;
                        }
                        // se já estou no último elemento da barra e não há proximo
                        if(!progItem.nextElementSibling){
                            progItem.classList.remove('ativo');
                        }
                    }
                     // se elemento anterior não é fildset, desativo o prev button
                    if(elemAnterior.previousElementSibling.tagName !== 'FIELDSET'){
                        var prevButton = querySelector('#prev');
                        prevButton.classList.add('disabled');
                    }
                }
            }
        }
    }

    /**
     * lança o evento de next doform
     */
    function nextEvt (){
        // encontra o fieldset atualmente ativo
        var fieldsets = querySelectorAll('fieldset');
        for (const field of fieldsets) {
            var isActive = field.classList.contains('active');
            // ao encontrar o ativo, verifica se todos os selects estão preechidos
            if (isActive){
                var selects = field.querySelectorAll('select');
                for (const select of selects) {
                    if (select.value === ''){ // se algum vazio, retorna um alert
                        return alert('Preencha todos os dados da página');
                    }
                }
                // habilita o botão anterior caso esteja desativado ainda
                var prevButton = querySelector('#prev');
                prevButton.classList.remove('disabled');
                // se ativo verifico se há um próximo item
                if (field.nextElementSibling){
                    field.classList.remove('active');
                    field.nextElementSibling.classList.add('active');
                    // dou um passo na barra de progresso
                    var progressItens = querySelectorAll('.progress li');
                    progItens:for (const progItem of progressItens) {
                        // verifico se há um próximo item
                            if (!progItem.classList.contains('ativo')){
                                progItem.classList.add('ativo');
                                break progItens;
                            }
                    }
                    return true;
                }
                // se não há próximo, envio o form
                document.forms.dotest.submit();
            }
        }
    }

})(window, document, console, x=>document.querySelector(x), x=>document.querySelectorAll(x));