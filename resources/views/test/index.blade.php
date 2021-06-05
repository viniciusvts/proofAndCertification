@include('layout.head')
<section class="bg-base">
  @include('layout.nav')
  <section class="container">
    @forelse ($tests as $test)
    <div class="row test-list">
      <div class="col-12 white-box">
        <h3>{{ $test->title }}</h3>
        <div class="d-flex">
          @isset ($isAdmin)
          <form action="{{ route('test.destroy', ['id' => $test->id]) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" class="acao" value="Excluir">
          </form>
          @endisset
          @isset ($isAdmin)
          <a href="{{ route('test.edit', ['id' => $test->id]) }}" class="ml-auto">
            <button class="acao">Editar</button>
          </a>
          @endisset
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
      {{ $tests->links() }}
    </div>
  </section>
</section>

@include('layout.footer')