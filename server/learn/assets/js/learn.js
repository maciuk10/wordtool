var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList
var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent

var words_obj = '';
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
      }else if (fillMode == 'html') {
          $('.'+divToFill).html(data);
      }else {}
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
      $(counterName).html(value);
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

var push_to_word_list = function(from){
  var returned = new Array();
  for(var i = 0; i < from.length; i++){
    returned.push(from[i].eng);
  }
  return returned;
};

var speak = function(text) {
  var u = new SpeechSynthesisUtterance();
  u.text = text;
  u.lang = 'en-US';

  u.onend = function(){};
  u.onerror = function(e){
    console.log(e);
  };
  speechSynthesis.speak(u);
};

var roundAfterComma = function(number, countOfNumbersAfterComma){
  var factor = Math.pow(10, countOfNumbersAfterComma);
  return Math.round(number*factor)/factor;
};

$(document).on('click', '.cheatsheet', function(){
  $('#cheatSheet').modal();
});

$(document).on('click', '.skipAll', function(){
  $('.alert-result').fadeOut(0).html('');
  $('.alert-information').fadeOut(0).html('');
  $('.gotostep3').attr('disabled', 'true');
  $('.skip3').attr('disabled', 'true');
});

$(document).on('click', '.btn-say', function(){
  var wordToSay = $('input[name=lastWord]').val();
  var wordList = push_to_word_list(window.words_obj);
  var grammarList =  '#JSGF V1.0; grammar words; public <word> = ' + wordList.join(' | ') + ' ;'
  var recognition = new SpeechRecognition();
  var speechRecognitionList = new SpeechGrammarList();
  speechRecognitionList.addFromString(grammarList, 1);
  recognition.grammars = speechRecognitionList;
  recognition.lang = 'en-US';
  recognition.interimResults = false;
  recognition.maxAlternatives = 1;

  recognition.start();
  console.log('Recognition started');

  recognition.onresult = function(event){
    var lastFound = event.results.length - 1;
    var word = event.results[lastFound][0].transcript;
    var confidence = event.results[0][0].confidence;
    if(word == wordToSay || word.toLowerCase() == wordToSay.toLowerCase()){
        if((confidence*100) > 75){
          $('.alert-result').removeClass('alert-danger').addClass('alert-success').html('<strong>Brawo!</strong> Twoja wymowa jest na dobrym poziomie!!!<br>Twój wynik to: <strong>'+(roundAfterComma(confidence*100, 5))+'%</strong>');
          $('.alert-result').fadeIn('slow');
          $('.alert-information').html("Kliknij przycisk aby przejść do następnego kroku").fadeIn('slow');
          $('.gotostep3').removeAttr('disabled');
          $('.skip3').removeAttr('disabled');
        }else {
          $('.alert-result').removeClass('alert-success').addClass('alert-danger').html('<strong>Niestety :(</strong> Posłuchaj dokładnie jeszcze raz. Za kolejnym razem na pewno pójdzie lepiej:)' );
          $('.alert-result').fadeIn('slow');
        }
    }else {
      $('.alert-result').removeClass('alert-success').addClass('alert-danger').html('<strong>Niestety :(</strong> Posłuchaj dokładnie jeszcze raz. Za kolejnym razem na pewno pójdzie lepiej:)' );
      $('.alert-result').fadeIn('slow');
    }
    console.log(word);
    console.log(confidence);
  }
});

$(document).on('click', '.btn-listen', function(){
  var wordToSay = $('input[name=lastWord]').val();
  speak(wordToSay);
  console.log('This word is: '+wordToSay);
});

$(document).on('click', '.gotostep3', function(){
  $('.alert-result').fadeOut(0).html('');
  $('.alert-information').fadeOut(0).html('');
  $(this).attr('disabled', 'true');
  $('.skip3').attr('disabled', 'true');
  $('#sayAtPhrase').modal();
});

$(document).on('click', '.skip3', function(){
  $('.alert-result').fadeOut(0).html('');
  $('.alert-information').fadeOut(0).html('');
  $(this).attr('disabled', 'true');
  $('.gotostep3').attr('disabled', 'true');
});

$(document).on('change', '.extended_switch', function(){
  if (this.checked) {
    var all_words = get_file_content('./templates/word_list.php', '', 'none', {unitid: $('input[name=unitid]').val(), bookid: $('input[name=bookid]').val()});
    all_words = JSON.parse(all_words);
    window.words_obj = all_words;
    var first_pri_and_ext_word = Math.floor(Math.random() * window.words_obj.length);
    $('.display_word').html(window.words_obj[first_pri_and_ext_word].pol);
    update_counter('.allWords', 'value', window.words_obj.length);
    update_counter('.goodWords', 'value', 0);
    update_counter('.badWords', 'value', 0);
  } else {
    var primary_words = get_file_content('./templates/word_list.php', '', 'none', {unitid: $('input[name=unitid]').val(), bookid: $('input[name=bookid]').val(), level: 'P'});
    primary_words = JSON.parse(primary_words);
    window.words_obj = primary_words;
    var first_nonextended_word = Math.floor(Math.random() * window.words_obj.length);
    $('.display_word').html(window.words_obj[first_nonextended_word].pol);
    update_counter('.allWords', 'value', window.words_obj.length);
    update_counter('.goodWords', 'value', 0);
    update_counter('.badWords', 'value', 0);
  }
});

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
          $('input[name=lastWord]').val(window.words_obj[results[1]].eng);
          window.words_obj.splice(results[1],1);
          $('#listenAndSay').modal();
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
        update_counter('.goodWords', 'value', 0);
        update_counter('.badWords', 'value', 0);
        update_counter('.allWords', 'value', obj_msg.length);

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
        $sidebar_content += "<li><a href='#' class='cheatsheet' disabled>"+"Ściągawka :)</a></li>";
        $sidebar_content += "<h4 class='text-center sidebar-title'>Dostosuj naukę:</h4>";
        $sidebar_content += "<li><a href='#' disabled>Tryb pisania: <input type='checkbox' checked data-toggle='toggle' disabled></a></li>";
        $sidebar_content += "<li><a href='#' data-toggle='tooltip' title='UWAGA! To spowoduje usunięcie twojego postępu nauki!' disabled>Poziom rozszerzony: <input type='checkbox' checked data-toggle='toggle' class='extended_switch'></a></li>";
        $sidebar_content += "<li><a href='#' disabled>(POL-ENG): <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Słuchaj i mów (PRO): <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<li><a href='#' disabled>"+"Powiedz w zdaniu (PRO): <input type='checkbox' checked data-toggle='toggle'></a></li>";
        $sidebar_content += "<div class='btn-group btn-group-justified'><a href='http://localhost/wordtool' class='btn btn-default'><span class='glyphicon glyphicon-home' aria-hidden='true'></span></a><a href='#' class='btn btn-default unitlist'><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></a><a href='#' class='btn btn-default'><span class='label label-danger'>PRO</span></a></div>";
        $sidebar_content += "<input type='hidden' name='unitid' value='"+unitid+"'>";
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
