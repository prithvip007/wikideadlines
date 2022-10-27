<table>
    <tbody>
        <tr>
            <td
                style="
                    font-family: 'gordita' , 'helvetica' , 'arial' , sans-serif;
                "
            >
                @switch($request->type)
                    @case('edit_deadline')
                        You have a new request for editing a deadline
                        @break
                    @case('add_deadline')
                        You have a new request for adding a deadline
                        @break
                    @case('document_type')
                        You have a new request for adding a document
                        @break
                    @case('edit_document_type')
                        You have a new request for editing a document
                        @break
                    @case('feedback')
                        You have a new feedback
                        @break
                    @default
                        You have a new request
                @endswitch
            </td>
        </tr>
    </tbody>
</table>
<table style="margin-top:15px;">
    <tbody>
        <tr>
            <td>
                <a
                    style="
                        font-family: 'gordita' , 'helvetica' , 'arial' , sans-serif;
                        color: #fff;
                        background-color: #38c172;
                        border-color: #38c172;
                        padding: 8px 16px;
                        font-size: 17px;
                        line-height: 1.5;
                        border-radius: 4px;
                        text-decoration: none;
                    "
                    href="{{ $url }}"
                >
                    Check it
                </a>

            </td>
        </tr>
    </tbody>
</table>


{{-- {{
    @switch($request->type)
        @case('edit_deadline')
        @case('add_deadline')
            {{ route('dashboard.deadline-rules.request', ['id' => $request->id]) }}
            @break
        @case('document_type')
            {{ route('dashboard.documents.request', ['id' => $request->id]) }}
            @break
        @default
            #
    @endswitch
}} --}}