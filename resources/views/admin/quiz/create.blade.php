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
<form action="/admin/quiz/create" method="POST">
    @csrf
    <div class="form-group" style="width: 50%;">
        <div>
            <label for="question">Question</label>
            <input type="text" name="question" class="form-control">
        </div>

        <label for="answer">Add Answer</label>
        <div class="input-group" id="answer">
            <div class="input-group-prepend"><button class="btn btn-success fas fa-plus-square addAnswer" /></div>
            <input type="text" name="answerInput" id="answer2" class="form-control">
        </div>
        <label for="answers" id="answer3" style="margin-top:5px;">Answers</label>
        
        <hr>
    </div>
    <button class="btn btn-success">submit</button>
</form>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/createQuiz1.js') }}"></script>
<script src="{{ asset('js/app.js')}}"></script>

@endsection