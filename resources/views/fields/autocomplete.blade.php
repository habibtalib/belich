<belich::datalist
    :field="$field"
    :value="$field->responseArray[$field->value] ?? $field->value ?? null"
>
</belich::datalist>
