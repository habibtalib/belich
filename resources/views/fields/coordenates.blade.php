{{-- Convert coordenates Latlng to Degrees --}}
@section('javascript-no-repeat')
    <script>
        function toDegreesMinutesAndSeconds(coordinate, type) {
            var absolute = Math.abs(coordinate);
            var degrees = Math.floor(absolute);
            var minutesNotTruncated = (absolute - degrees) * 60;
            var minutes = Math.floor(minutesNotTruncated);
            var seconds = Math.floor((minutesNotTruncated - minutes) * 60);
            var direction;

            if(type === 'latitude') {
                direction = coordinate >= 0 ? 'N' : 'S';
            } else {
                direction = coordinate >= 0 ? 'E' : 'W';
            }

            return degrees + '&#176; ' + minutes + "' " + seconds + '" ' + direction;
        }

        function updateCoordenates(item, key, type, decimals = 6) {
            window.setDecimals(item, decimals);
            document.getElementById(key).innerHTML = toDegreesMinutesAndSeconds(item.value, type);
        }
    </script>
@endsection

@push('javascript')
    <script>
        // Default setup
        document.addEventListener('DOMContentLoaded', function() {
            if(document.getElementById('toDegrees-{{ $field->uriKey }}')) {
                document.getElementById('toDegrees-{{ $field->uriKey }}').innerHTML = toDegreesMinutesAndSeconds('{{ $field->value }}', '{{ $field->coordenateType }}');
            }
        });
    </script>
@endpush
