<div class="alert alert-danger mb-0">
    <strong class="d-block">This document was served late</strong>
    It should have a Proof of Service Date on or before
    <b>{{ $deadline->date->format('l, F j, Y') }}</b> in order

    @if($calculation->delivery_area === 1)
        to arrive by this method of delivery from outside the country.
    @elseif($calculation->delivery_area === 2)
        to arrive by this method of delivery from outside the state.
    @else
        to arrive by this method of delivery from inside the state.
    @endif
</div>
