@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    <form name="form-edit" id="form-edit" method="POST" action="">
        @csrf
        @method('PATH')
        @foreach($request as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Button</button>
    </form>
@endsection

@section('javascript')

@endsection
