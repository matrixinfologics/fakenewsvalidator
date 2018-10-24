<div class="inner-info-content flag_button">
    {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id])]) }}
        {{ Form::hidden('flag', 'fake')}}
        {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
    {{ Form::close() }}
</div>
