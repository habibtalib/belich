<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::formAttribute($field, 'value') !!}
            {!! Helper::formAttribute($field, 'mask') !!}
            {!! $field->render !!}
            onkeyup="javascript:maskHandler(this);"
            type="text"
        >
    </slot>
</belich::fields>

@push('javascript')
    <script>
        //Set default values
        document.addEventListener("DOMContentLoaded", function() {
            window.maskHandler(document.getElementById('{{ $field->id }}'));
        })
    </script>
@endpush

@include('belich::fields.pattern-js')
