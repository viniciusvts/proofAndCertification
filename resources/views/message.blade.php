@include('layout.head')
<section class="bg-base">
  @include('layout.nav')
  <section class="container">
    <div class="row">
      <div class="col-12 white-box">
        <p class="text-center my-0">{{ $message }}</p>
      </div>
    </div>
  </section>
</section>
@include('layout.footer')