/**
 * Created by Vurt on 01.10.2015.
 */

(function($) {
    $(document).ready(function () {
        var arg = {};
        if($.cookie('action')){
            arg['action']=$.cookie('action');
        }else {
            arg['action']='versions';
            $.cookie('action','versions');
        }
        arg['user']='Vurt';
        arg['session']='qweqeqrqwe';
        init_page(arg);
        //=======================================================================================
        $(document).ajaxComplete(function(){
            var lineHeight = $('div#return-back').height();
            $('div#return-back p').css('line-height',lineHeight+'px');
            $('div#settings').css('line-height',lineHeight+'px');
            $('div#return-back p').css('font-size',lineHeight*1.5/3+'px');
            $('div#return-back').css('border-radius',lineHeight*0.09+'px');
            $('div#settings').css('border-radius',lineHeight*0.09+'px');
            $('div#content').css('border-radius',$('div#content').width()*0.02+'px');
            $('div#settings').css('font-size',lineHeight*1.5/3+'px');
            $('div#settings').css('width',$('div#settings').height()+'px');
            $('div.categorie-item').css('border-radius',$('div.categorie-item').width()*0.00675+'px');
            $('ul#categories.blist>li').css('border-radius',$('div.categorie-item').width()*0.00675+'px');
            $('div.version-item').css('border-radius', $('div.version-item').width() * 0.00675 + 'px');
            $('ul#versions.blist>li').css('border-radius', $('div.version-item').width() * 0.00675 + 'px');
                $('ul.version-local>li').css('min-width', $('ul.version-local>li').height() + 'px');
            $('li.pg').css('border-radius',$('li.pg').width()*0.00675+'px');
            $('div.blik').css('width',$('li.pg').width()-4+'px');
            $('div.blik').css('height',$('li.pg').height()-4+'px');
            $('ul.pglist-item li').each(function(){
                $(this).find('div.pg-indicator').css('width',parseInt($(this).find('div.pg-percent').html())-0.1+'%');
            });

            var x = document.createElement("AUDIO");
            if (x.canPlayType("audio/mpeg")) {
                x.setAttribute("src",$('[data-play]').attr('data-play'));
            } else {
                console('Your browser can\'t play mp3!');
            }

            $('ul#main.blist>li').css('border-radius',$('div.mi').width()*0.00675+'px');
            $('div.mi').css('border-radius',$('div.mi').width()*0.00675+'px');

            $('#foot-menu li').css('border-bottom-left-radius',$('#foot-menu li').height()*0.2+'px');
            $('#foot-menu li').css('border-bottom-right-radius',$('#foot-menu li').height()*0.2+'px');

            $('div.sq-letter').css('height',$('div.sq-letter').width()+'px');
            $('div.sq-letter').css('top',($('body').height()-$('div.sq-letter').height())/2+'px');
            var path=arg['action'].split('_');
            $('[data-link]').click(function(){
                if(path.length==3) {
                    arg['npage']=0;
                }
               $.cookie('action',$(this).attr('data-link'));
               arg['action']=$(this).attr('data-link');
               init_page(arg);
            });
            $('[data-label]').click(function(){
                var label= $(this).attr('data-label');
                $('ul#foot-menu li').each(function(){
                    $(this).attr('data-link',label+'_'+this.id);
                });
                $('ul#foot-menu').removeClass('hidden');
            });
            $('ul#main-letter').on("swipeleft",function(){
                var dst=$('li#bm-next').attr('data-letter');
                $('li#top-letter').hide("drop", { direction: "left" }, 600);
                $('li#bottom-letter').hide("drop", { direction: "left" }, 600);
                setTimeout(function(){
                    $.cookie('action',dst);
                    arg['action']=dst;
                    init_page(arg);
                },600);
            });
            $('#sq-letter').on("swipeleft",function(){
                var dst=$('li#bm-next').attr('data-letter');
                $('p#cat-counter i.fa-circle').addClass('ok');
                $('#sq-letter').hide("drop", { direction: "left" }, 600);
                setTimeout(function(){
                    $.cookie('action',dst);
                    arg['action']=dst;
                    init_page(arg);
                },600);
            });
            $('ul#main-letter').on("swiperight",function(){
                var dst=$('li#bm-prev').attr('data-letter');
                $('li#top-letter').hide("drop", { direction: "right" }, 600);
                $('li#bottom-letter').hide("drop", { direction: "right" }, 600);
                setTimeout(function(){
                    $.cookie('action',dst);
                    arg['action']=dst;
                    init_page(arg);
                },600);
            });
            $('#sq-letter').on("swiperight",function(){
                var dst=$('li#bm-prev').attr('data-letter');
                $('#sq-letter').hide("drop", { direction: "right" }, 600);
                setTimeout(function(){
                    $.cookie('action',dst);
                    arg['action']=dst;
                    init_page(arg);
                },600);
            });
            $('li#top-letter').hide().fadeIn(600);
            $('li#bottom-letter').hide().fadeIn(600);
            $('div#rotate-card').click(function(){
                var i=0;
                $('div#sq-letter').removeClass('mirror');
                (function(){
                    $('div#sq-letter').css('transform','rotateY('+i+'deg)');
                    i++;
                    if(i<=90){
                        setTimeout(arguments.callee,8);
                    }
                })();
                setTimeout(function(){
                    if($('ul.letter-content.lc1').hasClass('hidden')){
                        $('ul.letter-content.lc1').removeClass('hidden');
                        $('div#sq-letter').addClass('mirror');
                        $('ul.letter-content.lc2').addClass('hidden');
                    } else {
                        $('ul.letter-content.lc2').removeClass('hidden');
                        $('div#sq-letter').addClass('mirror');
                        $('ul.letter-content.lc1').addClass('hidden');
                    }
                    (function(){
                            $('div#sq-letter').css('transform','rotateY('+i+'deg)');
                            i++;
                            if(i<=180){
                                setTimeout(arguments.callee,8);
                            }
                            else{
                                $('ul.letter-content').css('transform','');

                            }
                    })();
                },900);

            });
            $('[data-letter]').click(function(){
                var dst=$(this).attr('data-letter');
                if(this.id=='bm-next'){
                    $('p#cat-counter i.fa-circle').addClass('ok');
                    $('li#top-letter').hide("drop", { direction: "left" }, 600);
                    $('li#bottom-letter').hide("drop", { direction: "left" }, 600);
                    $('#sq-letter').hide("drop", { direction: "left" }, 600);
                } else {
                    $('li#top-letter').hide("drop", { direction: "right" }, 600);
                    $('li#bottom-letter').hide("drop", { direction: "right" }, 600);
                    $('#sq-letter').hide("drop", { direction: "right" }, 600);
                }
                setTimeout(function(){
                    $.cookie('action',dst);
                    arg['action']=dst;
                    init_page(arg);
                },600);
            });
            $('i.fa.fa-play-circle-o[data-play]').click(function(){
                x.play();
            });
        });
    });
    function init_page(arg){
        $.post("http://auto.pokuponchik.com/engstud.php", arg, function (data){
            $('body#page').html(data);
        });
    }

})(jQuery);