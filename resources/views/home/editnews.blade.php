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
				<legend>Edit News</legend>
			<table>
				<tr>
					<td>News ID</td>
					<td><input type="text" name="newsid" value="{{$newsid}}"></td>
				</tr>
				<tr>
					<td>Date</td>
					<td><input type="text" name="date" value="{{$date}}"></td>
				</tr>
				<tr>
					<td>Headline</td>
					<td><input type="text" name="headline" value="{{$headline}}"></td>
				</tr>
				<tr>
					<td>Details</td>
					<td><input type="text" name="detail" value="{{$detail}}"></td>
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