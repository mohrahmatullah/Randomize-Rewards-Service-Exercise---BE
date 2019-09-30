<!DOCTYPE html>
<html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title></title>
	<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet"/> -->	
</head>
<body>
	@foreach($rewards as $key => $s)
		@if($key < 1)
		<form action="{{ route('edit', $s->id)}}" method="POST">
			@csrf
			<table cellpadding="10" cellspacing="0">
				<tr>
					<td>{{$s->user}}</td>
					<td>:</td>
					<td>
						<!-- <a href="#" id="industryName" data-type="text" data-pk="{{ $s->id }}" data-title="Edit industry">Rp. {{ number_format($s->details, 0, ".", ".") }}</a> -->
						<input type="text" name="daily_limit_rewards" value="{{ $s->details}}">
						
					</td>
					<td><input type="submit" value="save"></td>
					<!-- <td contenteditable="true" onBlur="saveToDatabase(this,'question',$s->id" onClick="showEdit(this);">Rp. {{ number_format($s->details, 0, ".", ".") }}</td> -->
				</tr>
			</table>
		</form>
		@endif
	@endforeach	
	
	<br>
	<hr>
	<br>
	<form action="" method="POST">
		@csrf
		<table border="0" cellpadding="10" cellspacing="0">
			<tr>
				<td>Users</td>
				<td><input type="text" name="name" required></td>
			</tr>
			<tr>
				<td>Random Reward ( range )</td>
				<td>
					<select name="random_reward" required>
						<option value="Rp. 10.000 - Rp. 20.000">Rp. 10.000 - Rp. 20.000</option>
						<option value="Rp. 45.000 - Rp. 75.000">Rp. 45.000 - Rp. 75.000</option>
						<option value="Rp. 60.000 - Rp. 80.000 ">Rp. 60.000 - Rp. 80.000</option>
						<option value="Rp. 30.000 - Rp. 50.000 ">Rp. 30.000 - Rp. 50.000</option>
						<option value="Rp. 30.000 - Rp. 50.000 ">Rp. 25.000 - Rp. 35.000</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Get Reward</td>
				<td><input type="text" name="get_reward" required></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Save"></td>
			</tr>
		</table>
	</form>
	<br>
	<hr>
	<br>	

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>No</th>
			<th>Users</th>
			<th>Random Reward ( range )</th>
			<th>Get Reward</th>
			<th>Balance / Daily limit rewards</th>
			<th>Action</th>
		</tr>		
		@foreach($rewards as $key => $s)		
			@if($key > 0)		
				@foreach(json_decode($s->details) as $d)
				<tr>
						<td>{{ $key }}</td>
						<td>{{ $s->user }}</td>				
						<td>{{ $d->random_reward }} </td>
						<td>Rp. {{ number_format($d->get_reward, 0, ",", ".") }} </td>
						<td>Rp. {{ number_format($d->balance_daily_limit_rewards, 0, ",", ".") }} </td>
						<td>
							<form action="{{ route('delete', $s->id) }}" method="POST" >
			                      @csrf
			                    <input type="submit" name="delete" value="Delete">
			                </form>
						</td>
				</tr>		
				@endforeach
			@endif
		@endforeach
	</table>
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js"></script>
	<script>
		$(document).ready(function() {

		     $.fn.editable.defaults.mode = 'inline';

		       $.fn.editable.defaults.params = function (params) 
		       {
		        params._token = $("#_token").data("token");
		        return params;
		       };

		     $('#industryName').editable({
		                validate: function(value) {
		                                            if($.trim(value) == '') 
		                                                return 'Value is required.';
		                                            },
		                type: 'text',
		                url:'/updateIndustry',   
		                send:'always',
		                ajaxOptions: {
		                dataType: 'json'
		                }

		                } );
		 } );
	</script> -->
</body>
</html>