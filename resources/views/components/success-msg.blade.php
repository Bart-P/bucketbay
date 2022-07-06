@if (session()->has('success_msg'))
  <div class="alert alert-success text-center position-absolute start-50 translate-middle-x" style="top: 75px;"
    role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
    {{ session()->get('success_msg') }}
  </div>
@endif
