<table style="width: 100%;text-align: left;background-color: #f8fafc; padding: 30px">
    <tbody>
        <tr>
            <th>UUID:</th>
            <td>{{ $incomingExceptionEntry['uuid'] }}</td>
        </tr>
        <tr>
            <th>Type:</th>
            <td>{{ $incomingExceptionEntry['type'] }}</td>
        </tr>
        <tr>
            <th>Created At:</th>
            <td>{{ $incomingExceptionEntry['created_at'] }}</td>
        </tr>
        <tr>
            <th>View in Telescope:</th>
            <td>
                <a href="{{ $telescopeURL }}">
                   Click
                </a>
            </td>
        </tr>
    </tbody>
</table>
