@if(session()->has('success'))
    <style>
        .alert {
            display: block;
            width: 100%;
            padding: 15px;
            color: white;
            margin-bottom: 15px;
            margin-top: -20px;
        }

        .alert.alert-success {
            background-color: #4caf50;
        }
    </style>

    <div class="alert alert-success">
        <ul class="message-header-list">
            <li>{!! session()->get('success') !!}</li>
        </ul>
    </div>
@endif