@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ $models->getTotal() }}</span> @choice('files::global.files', $models->getTotal())
@stop

@section('addButton')
	<a id="uploaderAddButtonContainer" href=""><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span></a>
@stop

@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		{{ Form::open(array('route' => array('admin.files.upload'), 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}
			@foreach (Config::get('app.locales') as $locale)
				{{ Form::hidden($locale.'[alt_attribute]', '') }}
				{{ Form::hidden($locale.'[status]', 1) }}
			@endforeach
			{{ Form::hidden('fileable_id', $parent->id); }}
			{{ Form::hidden('fileable_type', get_class($parent)); }}
			<div class="fallback">
			{{ Form::file('file', null, array('class' => 'fileInput', 'accept' => 'image/*')); }}
			{{ Form::button('send', array('type' => 'submit')) }}
			</div>

			<div class="dropzone-previews clearfix sortable sortable-thumbnails">
			@foreach ($models as $key => $model)
				<a href="{{ route('admin.' . $parent->route . '.files.edit', array($model->fileable_id, $model->id)) }}" class="thumbnail @if($model->status == 1) online @else offline @endif" id="item_{{ $model->id }}">
					<input type="checkbox" value="{{ $model->id }}">
					<img src="{{ Croppa::url('/'.$model->path.'/'.$model->filename, 100, 100) }}" alt="{{ $model->alt_attribute }}">
					<div class="caption">
						<div>{{ $model->filename }}</div>
						<div>{{ $model->alt_attribute }}</div>
					</div>
				</a>
			@endforeach
			</div>
			<!-- <div class="dropzone-previews"></div> -->
			<div class="dz-message">@lang('files::global.Drop files to upload')</div>

		{{ Form::close() }}

	</div>

	{{ $models->appends(Input::except('page'))->links() }}

@stop