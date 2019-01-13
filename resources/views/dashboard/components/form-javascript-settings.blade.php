@section('javascript-settings')
    <script>
        var dateFormat = "{{ $javascriptSettings['dateFormat'] ?? null }}";
    </script>
@endsection
