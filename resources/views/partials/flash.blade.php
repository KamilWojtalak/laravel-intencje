@if (session()->has('success'))
    <div class="" style="color: green;">
        {{ session('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div class="" style="color: red;">
        {{ session('error') }}
    </div>
@endif
