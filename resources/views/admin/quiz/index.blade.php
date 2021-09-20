@extends('layouts.master')

@section('content')
<style>
    div#answerDiv {
        align-items: center;
        background: whitesmoke;
        padding: 10px;
        border: solid 1px #d9d9d9;
        border-radius: 5px;
        margin: 5px;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }

    .fas {
        font-weight: 900;
    }
</style>
<h2><i class="fas fa-tasks" style='color:"#393939";'></i> Quiz Generator</h2>
<div id="quizGenerator">
</div>

<script src="{{asset('js/app.js')}}"></script>
@endsection