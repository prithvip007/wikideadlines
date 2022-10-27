<table>
    <tbody>
        <tr>
            <td
                style="
                    font-family: 'gordita' , 'helvetica' , 'arial' , sans-serif;
                "
            >
                You have recently added a document <strong>{{ $request->mapToDocument()['document']['name'] }}</strong>. <br> Would you like to add more deadlines to this document?
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
                        background-color: #3490dc;
                        border-color: #3490dc;
                        padding: 8px 16px;
                        font-size: 17px;
                        line-height: 1.5;
                        border-radius: 4px;
                        text-decoration: none;
                    "
                    href="{{ route('calculate', ['documentRequestId' => $request->id ]) . '#document' }}"
                >
                    Add More Deadlines
                </a>

            </td>
        </tr>
    </tbody>
</table>
