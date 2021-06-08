@include('layout.head')
<section class="bg-gradient">
  @include('layout.nav')
  <section class="container">
    <div class="row">
      <div class="col-12 white-box">
        <img src="/img/gear.svg" alt="configuração" class="config" id="openconfig">
        <h2 class="text-center">Novo Teste</h2>
        <form id="test" name="test" class="test" action="{{route('test.store')}}" method="post">
          {{ csrf_field() }}
          <label for="title">Título</label>
          <input type="text" name="title" id="title" required>
          <div class="modal" id="testconfig">
            <div class="internal">
              <label for="time_to_finish"
              data-tip="Tempo em minutos de duração máxima do teste">Tempo para termino em minutos</label>
              <input type="number" name="time_to_finish" id="time_to_finish" step="1" min="0" value="60">
              <a href="#_" class="acao f-right" id="fechar">Fechar</a>
            </div>
          </div>
          <div class="question">
            <span class="deletequestion">x</span>
            <label for="q0">Enunciado</label>
            <input type="text" name="question[0][statement]" id="q0" required>
            <div class="answer">
              <div class="row no-gutters">
                <div class="col-9">
                  <p>Opções</p>
                </div>
                <div class="col-2">
                  <p class="text-center">Resposta correta?</p>
                </div>
                <div class="col-1">
                  <p class="text-center">Excluir</p>
                </div>
              </div>
              <div class="row no-gutters item" data-item="0">
                <div class="col-9">
                  <input type="text" 
                  class="m-0"
                  name="question[0][answer][0][option]" required>
                </div>
                <div class="col-2 d-flex">
                  <input type="checkbox"
                  class="m-auto" name="question[0][answer][0][isCorrect]">
                </div>
                <div class="col-1 d-flex">
                  <img src="/img/fechar.svg" alt="deletar" class="delete">
                </div>
              </div>
              <div class="row no-gutters item" data-item="1">
                <div class="col-9">
                  <input type="text" 
                  class="m-0"
                  name="question[0][answer][1][option]" required>
                </div>
                <div class="col-2 d-flex">
                  <input type="checkbox"
                  class="m-auto" name="question[0][answer][1][isCorrect]">
                </div>
                <div class="col-1 d-flex">
                  <img src="/img/fechar.svg" alt="deletar" class="delete">
                </div>
              </div>
            </div>
            <img src="/img/plus.svg" alt="add" class="add">
          </div>
        </form>
        <div class="row no-gutters">
          <button id="newquestion" class="acao">Novo enunciado</button>
          <button type="submit" form="test" class="acao ml-auto">Salvar</button>
        </div>
      </div>
    </div>
  </section>
</section>
<script src="/js/testescript.js"></script>
@include('layout.footer')