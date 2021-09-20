$(document).ready(function () {
  $(window).keydown(function (event) {
    if (event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  $('#answer2').keydown(function (event) {
    if (event.keyCode == 13) {
      $(".addAnswer").click();
    }
  });
  function naturalCompare(a, b) {
    var ax = [], bx = [];

    a.replace(/(\d+)|(\D+)/g, function(_, $1, $2) { ax.push([$1 || Infinity, $2 || ""]) });
    b.replace(/(\d+)|(\D+)/g, function(_, $1, $2) { bx.push([$1 || Infinity, $2 || ""]) });
    
    while(ax.length && bx.length) {
        var an = ax.shift();
        var bn = bx.shift();
        var nn = (an[0] - bn[0]) || an[1].localeCompare(bn[1]);
        if(nn) return nn;
    }

    return ax.length - bx.length;
}
  $(".addAnswer").on("click",
    (e) => {
       e.preventDefault();
      let answerVal = $('#answer2').val();
      var arrayNumber = $('input[name^="answer["]').length;
      let answerInputs=[];
      $('input[name^="answer["]').each(function(i){answerInputs.push($(this).attr('name'));});
      answerInputs.sort(naturalCompare);
      if (arrayNumber!==0){
        jQuery.each(answerInputs,
          function(i){
            if(this=='answer['+arrayNumber+']')
            { 
                arrayNumber++;  
            }
          }
        );
    }
      if (answerVal) {
        var add_option = '<div id="answerDiv" class="input-group answerDiv' + arrayNumber + '">' +
          '<input type="checkbox" id="answerOption" name="answerOption[' + arrayNumber + ']" value="' + answerVal + '">' +
          '<input type="text" id="answer6" name="answer[' + arrayNumber + ']" value="' + answerVal + '" class="form-control">' +
          '<div class="input-group-prepend"><button id="delAnswer' + arrayNumber + '" class="btn btn-danger fas fa-trash "/></div></div>';
        $(add_option).insertBefore('hr');
        $('#answer2').val('');
        $('input[name="answer[' + arrayNumber + ']"]').on('change',
          () => {
            $('input[name="answerOption[' + arrayNumber + ']"]').val($('input[name="answer[' + arrayNumber + ']"]').val());
          }
        );
        $('#delAnswer' + arrayNumber).on("click",
          (e) => {
            e.preventDefault();
            $('.answerDiv' + arrayNumber).remove();
          }
        );
      } else {
        alert('The answer box is empty!');
      }
    });

});