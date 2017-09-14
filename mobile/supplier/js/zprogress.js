// zprogress (c) 2013 Thomas Fuchs
// MIT-licensed - https://github.com/madrobby/zprogress
;(function($){
  var $wrapper, $indicator, value, timeout,
    MARGIN = 12.5,
    LMARGIN = MARGIN/100,
    RMARGIN = 1 - LMARGIN

  function init(){
    $wrapper = $('#zprogress')
    $indicator = $('#zprogress_indicator')
  }

  function anim(){
    $indicator.animate({ translateX: value*100+'%' }, 200)
  }

  function clear(){
    if(timeout) clearTimeout(timeout)
    timeout = undefined
  }

  function trickle(){
    timeout = setTimeout(function(){
      $.zprogress.inc((RMARGIN-value)*.035*Math.random())
      trickle()
    }, 350+(400*Math.random()))
  }

  $.zprogress = {
    start: function(){
      init()
      clear()
      value = LMARGIN
      $wrapper.animate({ opacity: 1 })
      $indicator.animate({ translateX: '0%' }, 0)
      setTimeout(function(){
        anim()
        trickle()
      },0)
    },
    inc: function(delta){
      if(value<RMARGIN) value+=delta||.05
      anim()
    },
    set: function(newValue){
      init()
      clear()
      value = newValue
      anim()
      trickle()
    },
    done: function(){
      init()
      clear()
      value = 1
      anim()
      setTimeout(function(){$wrapper.animate({ opacity: 0 })}, 100)
    },
    color: function(color){
      init()
      $indicator.css({ backgroundColor: color })
    }
  }
})(Zepto)
