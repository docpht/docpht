/*!
 * jquery.key.js 0.2 - https://github.com/yckart/jquery.key.js
 * The certainly simpliest shortcut key event handler ever
 *
 * Copyright (c) 2013 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/02/09
*/
;(function ($, document) {
    var keys = {a:65,b:66,c:67,d:68,e:69,f:70,g:71,h:72,i:73,j:74,k:75,l:76,m:77,n:78,o:79,p:80,q:81,r:82,s:83,t:84,u:85,v:86,w:87,x:88,y:89,z:90,"0":48,"1":49,"2":50,"3":51,"4":52,"5":53,"6":54,"7":55,"8":56,"9":57,f1:112,f2:113,f3:114,f4:115,f5:116,f6:117,f7:118,f8:119,f9:120,f10:121,f11:122,f12:123,shift:16,ctrl:17,control:17,alt:18,option:18,opt:18,cmd:224,command:224,fn:255,"function":255,backspace:8,osxdelete:8,enter:13,"return":13,space:32,spacebar:32,esc:27,escape:27,tab:9,capslock:20,capslk:20,"super":91,windows:91,insert:45,"delete":46,home:36,end:35,pgup:33,pageup:33,pgdn:34,pagedown:34,left:37,up:38,right:39,down:40,"!":49,"@":50,"#":51,"$":52,"%":53,"^":54,"&":55,"*":56,"(":57,")":48,"`":96,"~":96,"-":45,_:45,"=":187,"+":187,"[":219,"{":219,"]":221,"}":221,"\\":220,"|":220,";":59,":":59,"'":222,'"':222,",":188,"<":188,".":190,">":190,"/":191,"?":191};
    $.key = $.fn.key = function (code, fn) {
        if (!(this instanceof $)) { return $.fn.key.apply($(document), arguments); }

        var i = 0,
            cache = [];

        return this.on({
            keydown: function (e) {
                var key = e.which;
                if (cache[cache.length - 1] === key) return;
                cache.push(key);

                i = key === code[i] || ( typeof code === 'string' && key === keys[code.split("+")[i]] ) ? i + 1 : 0;
                if ( i === code.length || ( typeof code === 'string' && code.split('+').length === i ) ) {
                    fn(e, cache);
                    i = 0;
                }
            },
            keyup: function () {
                i = 0;
                cache = [];
            }
        });
    };
})(jQuery, document);