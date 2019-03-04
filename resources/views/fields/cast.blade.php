@if(!empty($field->cast))
    <input type="hidden" name="cast[]" value="{{ $field->cast }}|{{ $field->attribute }}">
@endif
