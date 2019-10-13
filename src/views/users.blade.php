<p>This is the user list page</p>
<a href="/admin/logout">Logout user</a>

@foreach($users as $k => $user)	
	<p>{{$k}}. User name is: {{$user->name}} <a href="/admin/users/{{$user->id}}/edit">Edit user</a> <form action="/admin/users/{{ $user->id }}" method="POST">{{ method_field('DELETE') }} @csrf
   	<input type="submit" value="Delete user"/></form></p>
@endforeach

<a href="/admin/users/create">Create new user</a>
