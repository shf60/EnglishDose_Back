@extends('Layouts.master')
<h2>About Page</h2>

<div id="example"></div>
<script src="{{asset('js/app.js')}}"></script>
<form method="put">
@CSRF
<input type="answer[1]">
<input type="answer[2]">
<input type="submit">
</form>

