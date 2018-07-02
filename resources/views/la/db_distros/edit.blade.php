@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/db_distros') }}">Db distro</a> :
@endsection
@section("contentheader_description", $db_distro->$view_col)
@section("section", "Db distros")
@section("section_url", url(config('laraadmin.adminRoute') . '/db_distros'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Db distros Edit : ".$db_distro->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($db_distro, ['route' => [config('laraadmin.adminRoute') . '.db_distros.update', $db_distro->id ], 'method'=>'PUT', 'id' => 'db_distro-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					@la_input($module, 'adress')
					@la_input($module, 'message')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/db_distros') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#db_distro-edit-form").validate({
		
	});
});
</script>
@endpush
