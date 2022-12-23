<x-app-layout>
	<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Form') }}
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right;">Create Student</button>
        </h2>
		
    </x-slot>
	
	
	<div class="container">
	  <!-- Button to Open the Modal -->
	  

	  <!-- The Modal -->
	  <div class="modal fade" id="myModal">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Student Create</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div style='color: green;margin-left: 20px;'>
				@if(Session::has('msg'))
				{{Session::get('msg')}}
				@endif
			</div>
			<div class="modal-body">
			  <form method='post' action="{{Route('student-save')}}" enctype="multipart/form-data">
			  @csrf
				<div class="col-xl-12">
					<div class='form-group'>
						<label>Name : </label>
						<input type='text' name='name' class='form-control'>
						<span style='color:red;'>@error('name') {{$message}} @enderror</span>
					</div>
				</div>
				<div class="col-xl-12">
					<div class='form-group'>
						<label>Email : </label>
						<input type='text' name='email' class='form-control'>
						<span style='color:red;'>@error('email') {{$message}} @enderror</span>
					</div>
				</div>
				<div class="col-xl-12">
					<div class='form-group'>
						<label>Password : </label>
						<input type='password' name='password' class='form-control'>
						<span style='color:red;'>@error('password') {{$message}} @enderror</span>
					</div>
				</div>
				<div class="col-xl-12">
					<div class='form-group'>
						<label>Mobile : </label>
						<input type='text' name='mobile' class='form-control'>
						<span style='color:red;'>@error('mobile') {{$message}} @enderror</span>
					</div>
				</div>
				<div class='col-xl-12'>
					<div class='form-group'>
						<label>Course : </label>
						<select name='subject[]' multiple class='form-control'>
							<option>PHP</option>
							<option>JAVA</option>
							<option>CSS</option>
							<option>SQL</option>
							<option>HTML</option>
							<option>LARAVEL</option>
						</select>
					</div>
				</div>
				<div class="col-xl-12">
					<div class="form-group">
						<label>Image : </label>
						<input type="file" name="pic" class="form-control">
					</div>
				</div>
				<input type='submit' class='btn btn-info btn-block'>
			  </form>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
			
		  </div>
		</div>
	  </div>
	  
	  
	  <!--  datatable  -->
	  <table class="table table-bordered data-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Pic</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody></tbody>
	  </table> 
	  
	</div>

<script type="text/javascript">
  $(function () {
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('student.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
			{data: 'mobile', name: 'mobile'},
			{data: 'pic', name: 'pic'},
			/*{data: 'pic', name: 'pic',
				render: function( data, type, full, meta ) {
                        return "<img src=\"{{asset('public/image')}}/" + data + "\" height=\"50\"/>";
                    }
			},*/
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });
</script>
</x-app-layout>