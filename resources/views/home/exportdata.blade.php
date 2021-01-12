<!DOCTYPE html>
<html>
<head>
	<title>Export Data</title>
</head>
<body>

	<div class="table-responsive">
    <table id="list_table" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
           <td><b>Date</b></td>
          <td><b>Headline</b></td>
          <td><b>Details</b></td>
         </tr>
    </thead>
    <tbody>
      <tr>
            <td>{{$data->date}}</td>
            <td>{{$data->headline}}</td>
            <td>{{$data->detail}}</td>
        </tr>
      </tbody>
  </table>
</div>

</body>
</html>