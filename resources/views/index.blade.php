<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Multi Language Website In Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
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
</body>

<script type="text/javascript">
    var url = "{{ route('LangChange') }}";
    $(".Langchange").change(function() {
        window.location.href = url + "?lang=" + $(this).val();
    });
</script>

</html>