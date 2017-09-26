var words_obj = 's';
var get_file_content = function(filepath, divToFill, fillMode, params){
  var result = null;
  $.ajax({
    url: filepath,
    type: 'POST',
    data: params,
    async: false,
    success: function (data) {
      if(fillMode == 'append'){
          $('.'+divToFill).append(data);
      }else {
          $('.'+divToFill).html(data);
      }
      result = data;
    }
  });
  return result;
};
var get_unit = function(str, type){
  str = str.substring(0, str.indexOf('<'));
  if (type == 'number'){
    return str.substring(0, str.indexOf('-')-1);
  }else if (type == 'name') {
    return str.substring(str.indexOf('-')+2);
  }
};

var update_counter = function(counterName, sign, value){
  switch (sign) {
    case '+':
        $(counterName).html(parseInt($(counterName).html()) + value);
      break;
    case '-':
        $(counterName).html(parseInt($(counterName).html()) - value);
      break;
    case '*':
        $(counterName).html(parseInt($(counterName).html()) * value);
      break;
    case '/':
        $(counterName).html(parseInt($(counterName).html()) / value);
      break;
    default:
      $(counterName).html($(counterName).html());
  }
}


var check_correct = function(words, wordToCheck, wordTyped){
  var correct = false;
  var elementToRemove = null;
  for(var i = 0; i < words.length; i++){
    if(words[i].pol == wordToCheck){
      if(words[i].eng == wordTyped){
        correct = true;
        update_counter('.goodWords', '+', 1);
        update_counter('.allWords', '-', 1);
        elementToRemove = i;
      }else {
        update_counter('.badWords', '+', 1);
      }
    }
  }
  return new Array(correct, elementToRemove);
};

var give_hint = function(words, wordToCheck){
  for(var i = 0; i < words.length; i++){
    if(words[i].pol == wordToCheck){
      return words[i].eng.substring(0,1);
      break;
    }
  }
};

$(document).on('click', '.give-a-hint', function(){
  var hint = give_hint(window.words_obj, $('.display_word').html());
  $('.word-control').val(hint);
  $('.give-a-hint').attr('disabled', true);
});

$(document).on('click', '.check-result', function(){
      if(window.words_obj.length > 0){
        console.log('Jestem tu');
        $('.give-a-hint').attr('disabled', false);
        var results = check_correct(window.words_obj, $('.display_word').html(), $('.word-control').val());
        if(results[0]){
          window.words_obj.splice(results[1],1);
        }
        if(window.words_obj.length > 0){
          var new_number_no = Math.floor(Math.random() * window.words_obj.length);
          $('.display_word').html(window.words_obj[new_number_no].pol);
          $('.word-control').val('');
        }
      }
      console.log(window.words_obj.length);
      if(window.words_obj.length == 0){
        $('#endOfLearn').modal();
      }
      console.log(window.words_obj);
});

$(document).on('click', '.unitlist', function(){
  var $sidebar_content_back;
  $sidebar_content_back = "<h4 class='text-center sidebar-title'>Wybierz rozdział:</h4>";
  $('.sidebar').html($sidebar_content_back);
  get_file_content('./templates/unit_list.php', 'sidebar', 'append', {bookid: $('input[name=bookid]').val(), pathToConnect: '../../mysql_connect/connect.php'});
  $('.learn-mode').fadeOut(0);
  $('.loading').fadeIn("slow").delay(1000).fadeOut("slow");
  $('.choose-unit').delay(2000).fadeIn("slow");
  $('.page-header').html('<h2>'+$('input[name=bookname]').val()+'<small> '+$('input[name=bookpublisher]').val()+'</small></h2>');
});

$(document).on('click', '.nav-sidebar > li > a.unit' ,function(){
  $('.page-header > h2').html("Rozdział: "+$(this).html());
  $('.learn-mode').fadeOut(0);
  $('.choose-unit').fadeOut("slow").delay(1000);
  $('.loading').fadeIn("slow").delay(1000).fadeOut("slow");
  var unitid = $(this).children().val();
  var that = $(this);
  var get_words = function(){
    var req = $.ajax({
      url: './templates/word_list.php',
      type: 'POST',
      global: false,
      async: false,
      data: {
        unitid: unitid,
        bookid: $('input[name=bookid]').val()
      },
      success: function (msg) {
        var obj_msg = JSON.parse(msg);
        $('.goodWords').html('0');
        $('.badWords').html('0');
        $('.allWords').html(obj_msg.length);

        var unitno = get_unit(that.html(), 'number');
        var unitname = get_unit(that.html(), 'name');
        var $sidebar_content;
        var pcount = 0;
        for(var prop in obj_msg){
          if(obj_msg[prop].level == 'P'){
            pcount++;
          }
        }
        var rcount = obj_msg.length - pcount;
        $sidebar_content = "<h4 class='text-center sidebar-title'>Informacje:</h4>";
        $sidebar_content += "<ul class='nav nav-sidebar'>";
        $sidebar_content += "<li><a href='#' disabled>"+"Numer rodziału: "+unitno+"</a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Nazwa rodziału: "+unitname+"</a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Ilość słówek: "+obj_msg.length+"</a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Ilość słówek (PP): "+pcount+"</a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Ilość słówek (PR): "+rcount+"</a></li>";
        $sidebar_content += "<h4 class='text-center sidebar-title'>Dostosuj naukę:</h4>";
        $sidebar_content += "<li><a href='#' disabled>Tryb nauki: <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<li><a href='#' disabled>Poziom rozszerzony: <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<li><a href='#' disabled>(POL-ENG): <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Słuchaj i mów (PRO): <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Powiedz w zdaniu (PRO): <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<div class='btn-group btn-group-justified'><a href='http://localhost/wordtool' class='btn btn-default'><span class='glyphicon glyphicon-home' aria-hidden='true'></span></a><a href='#' class='btn btn-default unitlist'><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></a><a href='#' class='btn btn-default'><span class='label label-danger'>PRO</span></a></div>";
        $('.sidebar').html($sidebar_content);
        return obj_msg;
      }
    });
    return JSON.parse(req.responseText);
  }
  $('.learn-mode').delay(2500).fadeIn("slow");
  window.words_obj = get_words();
  var firstWord = Math.floor(Math.random() * window.words_obj.length);
  $('.display_word').html(window.words_obj[firstWord].pol);
});


$(document).ready(function(){
  var sidebar = $('.sidebar').html();

  $(window).load(function(){
    $('.learn-mode').fadeOut(0);
    $('.loading').fadeOut("slow");
    var bookid = $('input[name=bookid]').val();
    $('.choose-unit').delay(1000).fadeIn("slow");
  });
});
