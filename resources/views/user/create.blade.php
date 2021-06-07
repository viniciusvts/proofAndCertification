@include('layout.head')
<section class="bg-base">
  @include('layout.headerlogo')
  <div class="container">
    <div class="row">
      <div class="col-8 mx-auto white-box">
        <form id="dnaformkt-trilha" method="post" action="{{route('user.store')}}" name="dnaformkt-trilha" class="test">
          <h4>Login: Certificação Trilha de aprendizagem</h4>
          <p>Insira corretamente seus dados</p>
          {{ csrf_field() }}
          <input type="text" placeholder="Nome" name="name">
          <input type="email" placeholder="Email" name="email">
          <input type="submit" name="submit" class="acao" value="Cadastrar"/>
          <a href="{{ route('login.index') }}">
            <input type="text" class="acao" value="Voltar" style="float: right"/>
          </a>
        </form>
      </div>
    </div>
    @isset ($isIncorrectCredencials)
    <div class="err-resp">
      <p>Houve um erro, Tente novamente mais tarde</p>
    </div>
    @endisset
  </div>
@include('layout.footer')