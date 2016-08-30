var addEvent = function (el,type,fn) {
          if(window.addEventListener){
              el.addEventListener(type,fn,false)
          }
          else if(window.attacthEvent){
             el.attacthEvent('on'+type,fn)
          }
        }

        var btn = document.getElementById('moreBtn');
        var parent = document.getElementById('navArea');
        addEvent(btn,'click',function(){
          if(parent.style.display == 'block'){
            parent.style.display = 'none'
          }else{
            parent.style.display = 'block'
          }
        })

        var respon = function(){
          var cWidth = document.body.clientWidth;
          if(cWidth<640){
              parent.style.display='none'
          }else{
              parent.style.display='block'
          }
        }
        addEvent(window,'load',respon)
        addEvent(window,'resize',respon)