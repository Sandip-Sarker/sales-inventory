<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>

    @include('backend.include.style')

    @include('backend.include.script')

</head>

<body>

    @include('backend.include.header')

    @include('backend.include.sidebar')


    <div id="contentRef" class="content">

        @yield('content')

    </div>

    @yield('script')

</body>
</html>
