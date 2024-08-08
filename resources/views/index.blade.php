@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-3 text-right">
                <strong>Select Language: </strong>
            </div>
            <div class="col-md-4">
                <select class="form-control Langchange">
                    <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                    <option value="zh-hans" {{ session()->get('locale') == 'zh-hans' ? 'selected' : '' }}>Chinese</option>
                </select>
            </div>
            <h1 style="margin-top: 80px;">{{ __('message.welcome') }}</h1>
            <h1 style="margin-top: 80px;">{{ trans('message.welcome') }}</h1>
            <h1>@lang("Hi there!")</h1>
        </div>
    </div>

    <script type="text/javascript">
        var url = "{{ route('LangChange') }}";
        $(".Langchange").change(function() {
            window.location.href = url + "?lang=" + $(this).val();
        });
    </script>
@endsection