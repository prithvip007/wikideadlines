<div class="card bg-light mb-3">
    <div class="card-header px-3">
        <div class="d-flex align-items-center justify-content-between">
            <div>There are no deadlines to be calculated, but it might be helpful to check best practices:</div>
        </div>
    </div>
    <div class="card-body px-3 pb-2 pt-4 bg-light-blue">
        @foreach($calculation->getSnapshotInstance()->deadlines as $deadline)
            @if($deadline->best_practices)
                <div class="d-flex">
                    <div style="flex: 1 1 auto">
                        <div class="mt-1 py-1 px-2 rounded border border-light-blue bg-light-yellow text-break">
                            {{ $deadline->best_practices }}
                        </div>
                        @if ($loop->last === false)
                            <hr>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
