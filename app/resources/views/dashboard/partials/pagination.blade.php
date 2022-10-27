<div class="d-flex justify-content-between flex-wrap">
    <div class="d-flex align-items-center">
        <form method="GET">
            <div class="form-group">
                <select name="per_page" onchange="this.form.submit()" class="form-control">
                    <option {{ request()->per_page === '15' ? 'selected' : '' }} value="15">15</option>
                    <option {{ request()->per_page === '50' ? 'selected' : '' }} value="50">50</option>
                    <option {{ request()->per_page === '100' ? 'selected' : '' }} value="100">100</option>
                </select>
            </div>
        </form>
    </div>
    {{ $items->onEachSide(3)->appends(['per_page' => request()->per_page])->links() }}
</div>
