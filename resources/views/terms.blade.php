<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{ route('form-order') }}" method="post">
    @csrf
    <input type="submit">
</form>
</body>
</html>



{{--<x-guest-layout>--}}
{{--    <div class="pt-4 bg-gray-100">--}}
{{--        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">--}}
{{--            <div>--}}
{{--                <x-authentication-card-logo />--}}
{{--            </div>--}}

{{--            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">--}}
{{--                {!! $terms !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-guest-layout>--}}
