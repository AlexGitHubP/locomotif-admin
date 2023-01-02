@if ($errors->any())
  <div class="errors-mask">
    <div class='errors-mask-holder'>
      <div class='errors-mask-holder-close'>X</div>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
