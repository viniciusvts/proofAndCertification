@include('layout.head')
<section class="bg-base">
  @include('layout.headerlogo')
  <div class="container">
    <div class="row">
      <div class="col-8 mx-auto white-box">
        <form id="login" method="post" action="{{route('login.entrar')}}" name="login" class="test">
          <h4>Login: Certificação Trilha de aprendizagem - Módulo I</h4>
          <p>Insira corretamente seus dados para acessar prova de certificação</p>
          {{ csrf_field() }}
          <input type="email" placeholder="email" name="email">
          <input type="password" placeholder="senha" name="senha">
          <input type="submit" name="submit" class="acao" value="Entrar"/>
          <a href="cadastro.php">
            <input type="text" name="next1" class="acao" value="Primeiro Acesso" style="float: right"/>
          </a>
          @isset ($isIncorrectCredencials)
          <div class="resp">
            <p>Dados inválidos</p>
          </div>
          @endisset
        </form>
      </div>
    </div>
  </div>
</section>
@include('layout.footer')
