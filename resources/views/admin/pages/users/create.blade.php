
@extends('admin.layouts.main')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Create Users</h1>
<hr />
{{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p> --}}

<!-- DataTales Example -->
<div class="card">
  <!-- <div class="card-header">
    <div class="d-flex justify-content-between">
      <div class="p-2">
        <a class="btn btn-info" href="{{ route('admin.users.create') }}" title="Add New">
          Add New
        </a>
      </div>
    </div>
  </div> -->
  <div class="card-body">
    <div class="row">
        <div class="col-lg-12 col-12">
            @if (Session::has('errors'))
            <div class="alert alert-danger" role="alert">
            <ul>
                @foreach (Session::get('errors') as $error)
                @if (is_array($error))
                @foreach ($error as $err)
                    <li>{{ $err }}</li>
                @endforeach
                @else
                <li>{{ $error }}</li> 
                @endif
                @endforeach
            </ul>
            </div>
            @endif
            @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
            </div>
            @endif
            <div class="box">
            <div class="box-body">
                <div class="container">
                <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                    <input type="text" name="name" required class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                    <input type="email" name="email" required class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                    <select name="role" class="form-control">
                        <option value="superadmin">Administrator</option>
                        <option value="adminops">Admin Operational</option>
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                    <div class="input-group">
                        <input type="password" name="password" required class="form-control" id="passwordField"/>
                        <div class="input-group-prepend">
                        <button onclick="previewPassword(event)" class="btn btn-secondary"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Is Active</label>
                    <div class="col-sm-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="active" name="status" value="true" class="custom-control-input" checked>
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="inactive" name="status" value="false" class="custom-control-input">
                        <label class="custom-control-label" for="inactive">Inactive</label>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-right">
                        <a class="btn btn-warning" href="{{ route('admin.users.index') }}">Cancel</a>
                        <button class="btn btn-info" type="submit">Create</button>
                    </div>
                </div>
                </form>
            </div>
            </div>
            </div>
        </div>
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
  const previewPassword = (event) => {
    event.preventDefault();
    let pw = $('#passwordField');

    if (pw.attr('type') === 'password') {
      pw.attr('type', 'text');
    } else {
      pw.attr('type', 'password');
    }
  }
</script>
@endsection