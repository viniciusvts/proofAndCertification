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
        console.log('DOMContentLoaded', evt);
    }

    /** O evento de carga é disparado quando toda a página é carregada,
     * incluindo todos os recursos dependentes, como folhas de estilo e imagens.
     */
    function load(evt) {
        startTesteFormScript();
        startModalEvents();
    }
    /**
     * inicia as ações que acontecem no formulário de inserção/edição de testes
     * @author Vinicius de Santana
     */
    function startTesteFormScript() {
        var form = querySelector('#test');
        // valida o formulário
        form.addEventListener('submit', validateForm)
        // insere o evento que adiciona uma nova questão
        var newQuestionButtons = querySelectorAll('#newquestion');
        for (const nqbutton of newQuestionButtons) {
            nqbutton.addEventListener('click', newQuestionEvt);
        }
        // insere o evento que remove uma questão
        var deleteQuestionButtons = querySelectorAll('.deletequestion');
        for (const dqbutton of deleteQuestionButtons) {
            dqbutton.addEventListener('click', deleteQuestionEvt);
        }
        // insere o evento que adiciona uma nova opção a cada questão
        var newOptionButtons = querySelectorAll('.add');
        for (const nobutton of newOptionButtons) {
            nobutton.addEventListener('click', newOptionEvt);
        }
        // insere o evento que remove uma opção a cada questão
        var deleteOptionButtons = querySelectorAll('.delete');
        for (const dobutton of deleteOptionButtons) {
            dobutton.addEventListener('click', deleteOptionEvt);
        }
    }

    /**
     * valida o formulário se há apenas um checkbox para cada questão
     * @author Vinicius de Santana
     */
    function validateForm(evt) {
        var answerDiv = this.querySelectorAll('.question .answer');
        for (const ad of answerDiv) {
            var checkboxes = ad.querySelectorAll('[type="checkbox"]');
            var countChecked = 0;
            for (const cb of checkboxes) {
                if(cb.checked) countChecked++;
            }
            if(countChecked !== 1){
                alert('Cada pergunta deve ter apenas uma resposta certa');
                return evt.preventDefault();
            }
        }
    }

    /**
     * Adiciona uma nova questão ao formulário de inserção/edição de testes
     * @author Vinicius de Santana
     */
    function newQuestionEvt() {
        var form = querySelector('#test');
        var questions = querySelectorAll('.question');
        // clona a última pergunta
        var questionLength = questions.length;
        var lastQuestion = questions[questionLength - 1];
        var newQuestion = lastQuestion.cloneNode(true);
        // altera o for=qx do label
        var statementLabel = newQuestion.querySelector('[for^="q"');
        /** q0 ou q1 ou q2 ou ... */
        var statementid = statementLabel.getAttribute('for');
        var qref = statementid.replace('q', '');
        qref = Number(qref) + 1;
        statementLabel.setAttribute('for', 'q' + qref);
        // altera o id e o name do input da pergunta e limpa o value
        var statementInput = newQuestion.querySelector('[id^="q"');
        statementInput.setAttribute('id', 'q' + qref);
        statementInput.setAttribute('name', 'question[' + qref + '][statement]');
        statementInput.value = '';
        // deixa apenas o primeiro item das opções, por isso o for começa em 1
        var answerDiv = newQuestion.querySelector('.answer');
        var itens = answerDiv.querySelectorAll('.item');
        for (let i = 2; i < itens.length; i++) {
            answerDiv.removeChild(itens[i]);
        }
        // modifica os names e limpa os values
        var optionText = itens[0].querySelector('[type="text"]');
        optionText.setAttribute('name', 'question[' + qref + '][answer][0][option]');
        optionText.value = '';
        var optionText = itens[1].querySelector('[type="text"]');
        optionText.setAttribute('name', 'question[' + qref + '][answer][1][option]');
        optionText.value = '';
        var optionCheckbox = itens[0].querySelector('[type="checkbox"]');
        optionCheckbox.setAttribute('name', 'question[' + qref + '][answer][0][isCorrect] ');
        optionCheckbox.checked = false;
        var optionCheckbox = itens[1].querySelector('[type="checkbox"]');
        optionCheckbox.setAttribute('name', 'question[' + qref + '][answer][1][isCorrect] ');
        optionCheckbox.checked = false;
        // adiciona os eventos
        var addButton = newQuestion.querySelector('.add');
        addButton.addEventListener('click', newOptionEvt);
        var deleteQuestionButton = newQuestion.querySelector('.deletequestion');
        deleteQuestionButton.addEventListener('click', deleteQuestionEvt);
        // insere o evento que remove uma opção a cada questão
        var deleteOptionButton = newQuestion.querySelector('.delete');
        deleteOptionButton.addEventListener('click', deleteOptionEvt);
        // adiciona ao form
        form.appendChild(newQuestion);
    }

    /**
     * remove uma questão no formulário de testes
     * Esse evento leva em considerção a estrutura do formulário, alterar essa estrutura causará erros
     * @author Vinicius de Santana
     */
    function deleteQuestionEvt(evt) {
        // verificar se a estrutura está ok e consigo encontrar as divs corretas
        var thisQuestion = evt.target.parentNode;
        if(!thisQuestion.classList.contains('question')) throw new Error('erro na estrutura do formulário: question');
        var thisForm = thisQuestion.parentNode;
        if(!thisForm.tagName == "FORM") throw new Error('erro na estrutura do formulário: FORM');
        // se houver apenas um item, não deletar
        var allQuestions = thisForm.querySelectorAll('.question');
        if(allQuestions.length == 1) return alert('Não delete todas as perguntas');
        thisForm.removeChild(thisQuestion);
    }

    /**
     * adiciona uma opção a questão no formulário de testes
     * Esse evento leva em considerção a estrutura do formulário, alterar essa estrutura causará erros
     * @author Vinicius de Santana
     */
    function newOptionEvt(evt) {
        // verificar se a estrutura está ok e consigo encontrar as divs corretas
        questionDiv = evt.target.parentNode;
        if(!questionDiv.classList.contains('question')) throw new Error('erro na estrutura do formulário: question');
        answerDiv = questionDiv.querySelector('.answer');
        if(!answerDiv) throw new Error('erro na estrutura do formulário: answer');
        // pegar a referencia de que número de questão está
        var statementInput = questionDiv.querySelector('[id^="q"');
        /** q0 ou q1 ou q2 ou ... */
        var statementid = statementInput.id;
        var qref = statementid.replace('q', '');
        // última resposta
        answersItens = answerDiv.querySelectorAll('.item');
        var answerLength = answersItens.length;
        var newAnswer = answersItens[answerLength - 1].cloneNode(true);
        // modifica os names e limpa o value
        var iref = Number(newAnswer.dataset.item) + 1;
        newAnswer.dataset.item = iref;
        var optionText = newAnswer.querySelector('[type="text"]');
        optionText.setAttribute('name', 'question[' + qref + '][answer][' + iref + '][option]');
        optionText.value = '';
        var optionCheckbox = newAnswer.querySelector('[type="checkbox"]');
        optionCheckbox.setAttribute('name', 'question[' + qref + '][answer][' + iref + '][isCorrect] ');
        optionCheckbox.checked = false;
        // insere o evento que remove uma opção a cada questão
        var deleteOptionButton = newAnswer.querySelector('.delete');
        deleteOptionButton.addEventListener('click', deleteOptionEvt);
        // adiciona ao form
        answerDiv.appendChild(newAnswer);
    }

    /**
     * remove uma nova opção a questão no formulário de testes
     * Esse evento leva em considerção a estrutura do formulário, alterar essa estrutura causará erros
     * @author Vinicius de Santana
     */
    function deleteOptionEvt(evt) {
        // verificar se a estrutura está ok e consigo encontrar as divs corretas
        var thisItem = evt.target.parentNode.parentNode;
        if(!thisItem.classList.contains('item')) throw new Error('erro na estrutura do formulário: item');
        var answerDiv = thisItem.parentNode;
        if(!answerDiv.classList.contains('answer')) throw new Error('erro na estrutura do formulário: answer');
        // se houver dois itens (qtd min) não deletar
        var allItens = answerDiv.querySelectorAll('.item');
        if(allItens.length <= 2) return alert('Cada questão deve ter ao menos duas opções');
        answerDiv.removeChild(thisItem);
    }

    function startModalEvents(){
        var openModalButton = querySelector('#openconfig');
        var fecharModalButton = querySelector('#fechar');
        var modalDiv = querySelector('#testconfig');
        openModalButton.addEventListener('click', ()=>{
            modalDiv.classList.add('active');
        })
        fecharModalButton.addEventListener('click', ()=>{
            modalDiv.classList.remove('active');
        })
    }
    
})(window, document, console, x=>document.querySelector(x), x=>document.querySelectorAll(x));