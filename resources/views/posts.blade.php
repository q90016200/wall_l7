@extends('layouts.app')

@section('headerScript')
<script src="{{ asset('js/postApp.js') }}" defer></script>
@endsection

@section('content')
<div class="container" >
    <div id="post"></div>
</div>
@endsection
