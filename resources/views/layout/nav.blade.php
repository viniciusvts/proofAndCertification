<nav class="container">
  <div class="row">
    <div class="col-3">
      <a href="{{route('test.index')}}">
        <img class="logo" src="/img/dna-for-marketing-white.png">
      </a>
    </div>
    <div class="col d-flex actions">
      <ul>
        @isset ($isAdmin)
        <a href="{{route('test.create')}}"><li>Novo</li></a>
        @endisset
        <a href="{{route('login.sair')}}"><li>Sair</li></a>
      </ul>
    </div>
  </div>
</nav>