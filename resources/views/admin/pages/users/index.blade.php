
@extends('admin.layouts.main')

@section('content')
        <!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Users</h1>
<hr />
{{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p> --}}

<!-- DataTales Example -->
<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between">
      <div class="p-2">
        <a class="btn btn-info" href="#" title="Add New">
          Add New
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    
    <hr />
    <div class="table-responsive">
      <table class="table table-hover" id="datatable" width="100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active</th>
            <th>Last Login</th>
            <th>Last Update</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['email'] ?? '-' }}</td> 
            <td>
                @if( $item['is_active'] )
                    Yes
                @else
                    No
                @endif
            </td>
            <td>{{ $item['login_at'] ? \Carbon\Carbon::parse($item['login_at'])->format('d M Y H:i:s') : '-' }}</td>
            <td>{{ $item['updated_at'] ? \Carbon\Carbon::parse($item['updated_at'])->format('d M Y H:i:s') : '-' }}</td>
            <td>
                <a class="btn btn-primary btn-xs mr-2" href="{{ route('admin.users.detail', $item['id']) }}" title="Detail">
                    <i class="fa fa-eye" style="color:white;"></i>
                </a>
                <a class="btn btn-warning btn-xs mr-2" href="{{ route('admin.users.edit', $item['id']) }}" title="Edit">
                    <i class="fa fa-edit" aria-hidden="true" style="color:white;"></i>
                </a>
              
              
                {{-- <button class="btn btn-danger btn-xs" onclick="deleteData(event, {{ $user['id'] }})"><i class="fa fa-trash"></i></button> --}}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').DataTable({
        // searching: false,
        // paging:  false,
        // bInfo : false,
        // lengthChange: false
      });
    });
</script>
@endsection