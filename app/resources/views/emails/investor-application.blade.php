<table style="width: 100%;text-align: left;background-color: #f8fafc; padding: 30px">
    <tbody>
        <tr>
            <th>First Name:</th>
            <td>{{ $investorApplication->first_name }}</td>
        </tr>
        <tr>
            <th>Last Name:</th>
            <td>{{ $investorApplication->last_name }}</td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>
                <a href="mailto:{{ $investorApplication->email }}">{{ $investorApplication->email }}</a>
            </td>
        </tr>
        <tr>
            <th>User Id:</th>
            <td>
                <a href="{{ $redirectURL }}">
                    {{ $investorApplication->user_id }}
                </a>
            </td>
        </tr>
    </tbody>
</table>
