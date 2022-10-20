@extends('dashboard.layouts.index')

@section('content')
    <h1 class="d-inline-block">Users</h1>
    <small>({{ $usersCount }} users)</small>
    <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Subscription</th>
            <th>Date Registered (UTC+0)</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->second_name }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-capitalize">
                    {{ $user->getSubscriptionPlan() }}
                </td>
                <td>{{ $user->created_at->format('l, F j, Y g:i A') }}</td>
                <td>
                    <a href="{{ route('dashboard.user', ['id' => $user->id]) }}"><i class="fa fa-id-card-o mr-1" aria-hidden="true"></i>View</a>
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      @include('dashboard.partials.pagination', [
        'items' => $users
      ])
@endsection