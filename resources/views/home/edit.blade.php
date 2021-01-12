<!DOCTYPE html>
<html>
<head>
	<title>Edit Page</title>
</head>
<body>
	<a href="{{route('home.index')}}">Back</a> |
	<a href="/logout">logout</a>
	<br>
	
		<form method="post" enctype="multipart/form-data">

			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<fieldset>
				<legend>Edit User</legend>
			<table>
				<tr>
					<td>Notice ID</td>
					<td><input type="text" name="nid" value="{{$nid}}"></td>
				</tr>
				<tr>
					<td>User ID</td>
					<td><input type="text" name="uid" value="{{$uid}}"></td>
				</tr>
				<tr>
					<td>Notice</td>
					<td><input type="text" name="notice" value="{{$notice}}"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="Update"></td>
				</tr>
			</table>
			</fieldset>
		</form>

		@foreach($errors->all() as $err)
			{{$err}} <br>
		@endforeach
</body>
</html>