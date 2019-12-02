<belich::fields :field="$field">
    <slot name="input">
        <div class="flex" style="max-height: 300px !important">
            <textarea
                class="flex-1 m-1"
                {!! Helper::formAttribute($field, 'rows', $field->rows ?? 20) !!}
                {!! Helper::formAttribute($field, 'maxlength') !!}
                {!! $field->render !!}
            >
                {!! str_replace(["\r"], '&#13;&#10;', $field->value) !!}
             </textarea>
            <div class="flex-1 overflow-y-auto m-1 rounded p-3 border border-gray-400 bg-gray-100" id="editor-{!! $field->id !!}">
                {!! Helper::markdown($field->value) !!}
            </div>
        </div>
    </slot>
</belich::fields>

@section('markdown')
    <link rel="dns-prefetch" href="//unpkg.com">
    <script src="https://unpkg.com/marked@0.3.6"></script>
@endsection

@push('javascript')
    <script>
        // Listen for changes to inputs and textareas
        document.getElementById('{!! $field->id !!}').addEventListener('input', function (event) {
            document.getElementById('editor-{!! $field->id !!}').innerHTML = marked(event.target.value, { sanitize: true });
        }, false);
    </script>
@endpush
