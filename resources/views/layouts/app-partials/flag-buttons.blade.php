<div class="inner-info-content flag_button">
    {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id]), 'class' => 'flag_trusted']) }}
        {{ Form::hidden('flag', 'trusted')}}
        {{ Form::button('FLAG TRUSTED', ['type' => 'submit', 'class' => 'btn btn-flag pull-left']) }}
    {{ Form::close() }}
    {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id]), 'class' => 'flag_fake']) }}
        {{ Form::hidden('flag', 'fake')}}
        {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
    {{ Form::close() }}
</div>
