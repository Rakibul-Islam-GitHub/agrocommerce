<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container mb-2">
                @if(count($errors)>0)
                    <div class="alert alert-danger p-3" role="alert">
                    @foreach($errors->all() as $err)
                    {{$err}} <br>
                    @endforeach
                    </div>
                @endif

                @if(session('msg'))
                <div class="'alert alert-{{session('type')}} p-3" role="alert">
                {{session('msg')}}
                </div>
                @endif
</div>
<a href="{{route('customer.github')}}">Sign in with GitHub account</a>
</body>
</html>