<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PrivioAngular</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>

@extends('layouts.layout')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="m-t-none m-b">Addressee</h3>
                <form role="form" method="post" ">
                    <div class="form-group">
                        <label>Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="email" value="" placeholder="Name" required/>
                    </div>
                    <div class="form-group">
                        <label>Abbreviation <span class="required">*</span></label>
                        <input type="text" class="form-control" name="senha" value="" placeholder="Name" required/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<app-user></app-user>
<script src="js/runtime.js" defer></script>
<script src="js/polyfills.js" defer></script>
<script src="js/styles.js" defer></script>
<script src="js/vendor.js" defer></script>
<script src="js/main.js" defer></script>

</body>
</html>
