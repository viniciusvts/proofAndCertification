@include('layout.head')
<section class="bg-base">
  @include('layout.nav')
  <section class="container">
    @forelse ($tests as $test)
    <?php
    // se user já vez o teste e caso fez, se passou
    $didTest = $user->tests()->find($test->id);
    if ($didTest) {
      $is_approved = $didTest->pivot->is_approved == 1;
    }
    ?>
    <div class="row test-list">
      <div class="col-12 white-box">
        <h3>{{ $test->title }}</h3>
        <p>{{ count($test->questions) }} questões, {{ $test->time_to_finish }} minutos para concluir.</p>
        <div class="d-flex">
          @if ($isAdmin)
          <form action="{{ route('test.destroy', ['id' => $test->id]) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" class="acao" value="Excluir">
          </form>
          @endif
          @if (isset($is_approved) && $is_approved)
          <a href="{{ route('test.getCertificate', ['id' => $test->id]) }}">
            <button class="acao">Certificado</button>
          </a>
          @endif
          @if ($isAdmin)
          <a href="{{ route('test.edit', ['id' => $test->id]) }}" class="ml-auto">
            <button class="acao">Editar</button>
          </a>
          @else
          <a href="{{ route('test.do', ['id' => $test->id]) }}" class="ml-auto">
            <button class="acao">Realizar Teste</button>
          </a>
          @endif
        </div>
      </div>
    </div>
    @empty
    <div class="row">
      <div class="col-12 white-box">
        <p class="text-center my-0">Ainda não há testes cadastrados</p>
      </div>
    </div>
    @endforelse
  </section>
  <section class="container">
    <div class="row">
      <div class="col">
        {{ $tests->links('layout.pagination') }}
      </div>
    </div>
  </section>
</section>

@include('layout.footer')