<belich::fields :field="$field">
    <slot name="input">
        <textarea
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::formAttribute($field, 'rows', $field->rows ?? 3) !!}
            {!! Helper::formAttribute($field, 'maxlength') !!}
            {!! $field->render !!}
        >
         </textarea>
    </slot>
</belich::fields>

@section('markdown')
    <link rel="dns-prefetch" href="//unpkg.com">
    <link rel="stylesheet" href="//unpkg.com/easymde/dist/easymde.min.css">
    <script src="//unpkg.com/easymde/dist/easymde.min.js"></script>
@endsection

@push('javascript')
    <script>
        var easyMDE = new EasyMDE({
            autoDownloadFontAwesome: false,
            element: document.getElementById('{{ $field->id }}'),
            initialValue: '{!! $field->value !!}'
        });
    </script>
@endpush
