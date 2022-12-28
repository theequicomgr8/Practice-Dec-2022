<x-app-layout>
	<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student List') }}
        </h2>
		
    </x-slot>
	<br><br>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
	<div class="container">
  
	  
	  <!--  datatable  -->
	  
	  <table class="table table-bordered" id="posts">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody></tbody>
	  </table> 
	  
	  
	</div>

<script>
    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('allstudent') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "mobile" },
				{ "data": "options" }
            ]	 

        });
    });
</script>
</x-app-layout>