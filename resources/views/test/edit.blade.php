@include('layout.head')
<section class="bg-gradient">
  @include('layout.nav')
  <section class="container">
    <div class="row">
      <div class="col-12 white-box">
        <img src="/img/gear.svg" alt="configuração" class="config" id="openconfig">
        <h2 class="text-center">Editar teste</h2>
        <form id="test" name="test" class="test" action="{{ route('test.update', ['id' => $test->id]) }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PUT">
          <label for="title">Título</label>
          <input type="text" name="title" id="title" value="{{ $test->title }}" required>
          <div class="modal" id="testconfig">
            <div class="internal">
              <label for="time_to_finish"
              data-tip="Tempo em minutos de duração máxima do teste">Tempo para termino em minutos</label>
              <input type="number" name="time_to_finish" id="time_to_finish" step="1" min="0" value="60">
              <a href="#_" class="acao f-right" id="fechar">Fechar</a>
            </div>
          </div>
          <?php
          $questions = $test->questions;
          foreach($questions as $qkey => $question){
          ?>
          <div class="question">
            <span class="deletequestion">x</span>
            <label for="q0">Enunciado</label>
            <input type="text"
            name="question[{{ $qkey }}][statement]"
            id="q{{ $qkey }}"
            value="{{ $question->statement }}" required>
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
              <?php
              $answers = $question->answers;
              foreach($answers as $akey => $answer){
              ?>
              <div class="row no-gutters item" data-item="{{ $akey }}">
                <div class="col-9">
                  <input type="text"
                  class="m-0"
                  name="question[{{ $qkey }}][answer][{{ $akey }}][option]"
                  value="{{ $answer->option }}" required>
                </div>
                <div class="col-2 d-flex">
                  <input type="checkbox"
                  class="m-auto"
                  name="question[{{ $qkey }}][answer][{{ $akey }}][isCorrect]"
                  <?php if($answer->isCorrect){ echo 'checked'; }?>>
                </div>
                <div class="col-1 d-flex">
                  <img src="/img/fechar.svg" alt="deletar" class="delete">
                </div>
              </div>
              <?php
              }
              ?>
            </div>
            <img src="/img/plus.svg" alt="add" class="add">
          </div>
          <?php
          }
          ?>
        </form>
        <div class="row no-gutters">
          <button id="newquestion" class="acao">Novo enunciado</button>
          <button type="submit" form="test" class="acao ml-auto">Editar</button>
        </div>
      </div>
    </div>
  </section>
</section>
<script src="/js/testescript.js"></script>
@include('layout.footer')