@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    <form name="form-create" id="form-create" method="POST" action="{{ route(getRouteForm($settings, 'store')) }}">
        @csrf
        @foreach($request as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        <div class="text-center">
            <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">Button</button>
        </div>
    </form>
@endsection

@section('javascript')
<script type="text/javascript">
         $(document).ready(function(){
            $('#form-create').submit(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
               $.ajax({
                    url: $('#form-create').attr('action'),
                    method: 'post',
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        locale: $('#locale').val()
                    },
                    success: function(data) {

                        $( ".validation-error" ).html('&nbsp;');

                        if(data.errors) {
                            $.each(data.errors, function(key, value) {
                                $('#error-' + key).html(value);
                            });
                        } else {
                            console.log('success');
                        }
                    },
                });
            });
        });
</script>
@endsection
