@if ($errors->any())
    @foreach ($errors->all() as $error)
    <p><strong style="color:red;">{{ $error }}</strong></p>
    @endforeach 
@endif

@if(session()->has('success'))  
      <p><strong style="color:green;">{{ session()->get('success') }}</strong></p>
@endif

@if(session()->has('error'))  
      <p><strong style="color:red;">{{ session()->get('error') }}</strong></p>
@endif