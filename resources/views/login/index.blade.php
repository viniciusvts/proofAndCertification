@include('layout.head')
<section class="bg-base">
  @include('layout.headerlogo')
  <div class="container">
    <div class="row">
      <div class="col-8 mx-auto white-box">
        <form id="login" method="post" action="{{route('login.entrar')}}" name="login" class="test">
          <h4>Login: Certificação Trilha de aprendizagem</h4>
          <p>Insira corretamente seus dados para acessar as provas de certificação</p>
          {{ csrf_field() }}
          <input type="email" placeholder="Email" name="email">
          <input type="password" placeholder="Senha" name="senha">
          <input type="submit" name="submit" class="acao" value="Entrar"/>
          <a href="{{ route('user.create') }}">
            <input type="text" name="next1" class="acao" value="Primeiro Acesso" style="float: right"/>
          </a>
        </form>
      </div>
    </div>
    @isset ($isIncorrectCredencials)
    <div class="err-resp">
      <p>Dados inválidos, Tente novamente</p>
    </div>
    @endisset
  </div>
</section>
@include('layout.footer')
