@php

    $date = Carbon\Carbon::now();

    if($date instanceof Carbon\Carbon) {
        echo '<div>Correct Carbon object</div>';
    }

    $date2 = '2020-01-03';

    if(DateTime::createFromFormat('Y-m-d', $date2)) {
        echo '<div>Correct sql format</div>';
    } else {
        echo '<div>Error with sql format</div>';
    }

    if(DateTime::createFromFormat('Y/m/d', $date2)) {
        echo '<div>Correct english format</div>';
    } else {
        echo '<div>Error with english format</div>';
    }

    if(DateTime::createFromFormat('d/m/Y', $date2)) {
        echo '<div>Correct eeuropean format</div>';
    } else {
        echo '<div>Error with eeuropean format</div>';
    }
@endphp
