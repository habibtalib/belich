<belich::fields :field="$field">
    <slot name="input">
        <div class="flex" style="max-height: 300px !important">
            <textarea
                class="flex-1 m-1"
                onkeydown="insertTab(this, event);"
                {!! Helper::formAttribute($field, 'rows', $field->rows ?? 20) !!}
                {!! Helper::formAttribute($field, 'maxlength') !!}
                {!! $field->render !!}
            >
                {!! str_replace(["\r\n", "\r", "\n"], ['&#13;&#10;'], $field->value) !!}
             </textarea>
             @if($field->preview)
                <div class="flex-1 overflow-y-auto m-1 rounded p-3 border border-gray-400 bg-gray-100" id="editor-{!! $field->id !!}">
                    {!! Helper::markdown($field->value) !!}
                </div>
            @endif
        </div>
    </slot>
</belich::fields>

{{-- https://gist.github.com/cferdinandi/2218858af04d5306904fe57c184fc17a --}}

@section('markdown')
    <link rel="dns-prefetch" href="//unpkg.com">
    <script src="https://unpkg.com/marked@0.3.6"></script>
    <script>
        {{-- https://sumtips.com/snippets/javascript/tab-in-textarea/ --}}
        function insertTab(o, e) {
            var kC = e.keyCode ? e.keyCode : e.charCode ? e.charCode : e.which;
            if (kC == 9 && !e.shiftKey && !e.ctrlKey && !e.altKey) {
                var oS = o.scrollTop;
                if (o.setSelectionRange) {
                    var sS = o.selectionStart;
                    var sE = o.selectionEnd;
                    o.value = o.value.substring(0, sS) + "    " + o.value.substr(sE);
                    o.setSelectionRange(sS + 1, sS + 1);
                    o.focus();
                } else if (o.createTextRange) {
                    document.selection.createRange().text = "    ";
                    e.returnValue = false;
                }
                o.scrollTop = oS;
                if (e.preventDefault) {
                    e.preventDefault();
                }
                return false;
            }
            return true;
        }
    </script>
@endsection

@push('javascript')
    <script>
        // Listen for changes to inputs and textareas
        document.getElementById('{!! $field->id !!}').addEventListener('input', function (event) {
            document.getElementById('editor-{!! $field->id !!}').innerHTML = marked(event.target.value, { sanitize: true });
        }, false);

        var myInput = document.getElementById('{!! $field->id !!}');
        if(myInput.addEventListener ) {
            myInput.addEventListener('keydown', this.keyHandler,false);
        } else if(myInput.attachEvent ) {
            myInput.attachEvent('onkeydown', this.keyHandler); /* damn IE hack */
        }
        </script>
    </script>
@endpush
