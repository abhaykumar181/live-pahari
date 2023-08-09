@if ($errors->any())
    <div class="container-fluid">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div class="container-fluid">
        <div class="alert alert-danger">
            @if(is_array(session()->get('error')))
                @foreach(session()->get('error') as $errorKey=>$errorText)
                    <div>{{ $errorText }}</div>
                @endforeach
            @else
                {{ session()->get('error') }}
            @endif
        </div>
    </div>
@endif

@if(session()->has('message'))    
    <div class="container-fluid">
        <div class="alert alert-success">
            @if(is_array(session()->get('message')))
                @foreach(session()->get('message') as $messageKey=>$messageText)
                <div>{{ $messageText }}</div>
                @endforeach
            @else
                {{ session()->get('message') }}
            @endif
        </div>
    </div>
@endif