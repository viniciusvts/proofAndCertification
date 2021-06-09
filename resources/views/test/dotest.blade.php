@include('layout.head')
<section class="bg-base">
  @include('layout.nav')
  @include('layout.clock-countdown')
  <section class="container">
    <div class="row test-list">
      <div class="col-12 col-md-8 mx-auto white-box">
        <h4 class="text-center">Boa sorte {{ $user->name }}</h4>
        <h3 class="text-center">{{ $test->title }}</h3>
        <form action="{{ route('test.checkresults', ['id' => $test->id]) }}"
        method="post" class="dotest" id="dotest">
          {{ csrf_field() }}
          <fieldset class="active">
            @forelse ($test->questions as $question)
              <label for="{{ $question->id }}">{{ $question->statement }}</label>
              <select name="{{ $question->id }}" id="" required>
                <option value="">Escolha uma opção</option>
                @foreach ($question->answers as $answer)
                <option value="{{ $answer->id }}">{{ $answer->option }}</option>
                @endforeach
              </select>
          @if (($loop->iteration % $questionPerPage) == 0 && !$loop->last)
          </fieldset>
          <fieldset>
          @endif
            @empty
            <p class="text-center my-0">Esse teste não tem perguntas, entre em contato com o administrador do sistema</p>
            @endforelse
          </fieldset>
        </form>
        <div class="d-flex">
          <a href="#_" id="prev" class="acao disabled">Anterior</a>
          <a href="#_" id="next" class="acao ml-auto">Próximo</a>
        </div>
      </div>
    </div>
    <?php
    $qtdQuestions = count($test->questions);
    $pages = $qtdQuestions / $questionPerPage;
    $pages = ceil($pages);
    ?>
    <div class="row">
      <div class="col-12 col-md-8 mx-auto">
        <ul class="progress">
          @for ($i = 1; $i <= $pages; $i++)
          <li <?php if($i==1){ echo('class="ativo"'); }?>></li>
          @endfor
        </ul>
      </div>
    </div>
  </section>
</section>
<script src="/js/dotest.js"></script>

@include('layout.footer')