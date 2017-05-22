(function($) {

var exe = (function() {

	return {
    
		opts: {
            crtClass: 'crnt',
            btnID: '.top_btn',
            all: 'html, body',
            animEnd: 'webkitAnimationEnd MSAnimationEnd oanimationend animationend', //mozAnimationEnd
            transitEnd: 'webkitTransitionEnd MSTransitionEnd otransitionend transitionend', //mozTransitionEnd 
        },
        
        scrollFunc: function() {
            var t = this,
                tb = $(t.opts.btnID);
            
            tb.css('display','none').on('click', function() {
                $(t.opts.all).animate({ scrollTop:0 }, 500, 'linear'); //easeOutExpo
            });

            $(document).scroll(function(){

                if($(this).scrollTop() < 200)
                    tb.fadeOut(200);
                else 
                    tb.fadeIn(300);
            });
            
        },
        
        
        isAgent: function(user) {
            if( navigator.userAgent.indexOf(user) > 0 ) return true;
        },
        
        isLocal: function() {
        	if( location.port == 8006 ) return true;
        },
        
        isSpTab: function(arg) {

        	var spArr = ['iPhone','iPod','Mobile ','Mobile;','Windows Phone','IEMobile'];
            var tabArr = ['iPad','Kindle','Sony Tablet','Nexus 7','Android Tablet'];
            var arr = [];
            
            if(arg == 'sp')
            	arr = spArr;
            
            else if(arg == 'tab')
            	arr = tabArr;
            
            else
            	arr = spArr.concat(tabArr);
            
        	
            var th = this;
            var bool = false;
            
            arr.forEach(function(e, i, a) {
            	if(th.isAgent(e)) {
                	bool = true;
                    return; //Exit
                }
            });
            
            return bool;
        },
        
        toggleSp: function() {
        	$('.navbar .fa-search').on('click', function(){
            	$('.searchform').slideToggle(150);
            });
           
            var t;
            $('.navbar .fa-bars').on('click', function(){
            	var $leftbar = $('#left-bar');
                
                var h = $(window).height();
                $leftbar.find('.panel-body').css({height:h-60});

            	if($leftbar.is(':visible')) {
                	$leftbar.stop().animate({left:'-200px'}, 80, 'linear', function(){
                    	$(this).hide(0);
                        $('html,body').css({position:'static'}).scrollTop(t);
                    });
                }
                else {
                	t = $(window).scrollTop();
            		$leftbar.show(50, function(){
                    	$(this).stop().animate({left:0}, 100);
                        $('html,body').css({position:'fixed', top:-t}); //overflow:'hidden',
                    });
                }
                //$('.navbar-brand').text(t);
            });
        },
        
        
        put: function(tag, argText) {
            $(tag).text(argText);
            console.log("CheckText is『 %s 』" , argText);
        },
        
        
        addClass: function() {
        	//$('.add-item').find('.item-panel').eq(0).addClass('first-panel');
            $('.item-panel').eq(0).css({border:'2px solid green'});
        },
        
        nl2br: function(str) {
            str = str.replace(/\r\n/g, "<br>");
            str = str.replace(/(\n|\r)/g, "<br>");
            return str;
        },
        
        
        
        
        eventItem: function() {
           
            //Link Check Btn
            $('.subm-check').on('click', function(e){
            	e.preventDefault();
                
            	var url = $(this).parent('div').find('.link-url').val(); //input type=text
                var $frame = $(this).parent('div').find('.link-frame');
                //console.log(url);
                
                $.ajax({
                    url: '/script/addLink.php',
                    type: "POST",
                    cache: false,
                    data: {
                      url: url,
                    },
                    //dataType: "json",
                    success: function(resData){
                    	//console.log(resData.image[0]);
                        $frame.html(resData).slideDown(100);
                    },
                    error: function(xhr, ts, err){
                        //resp(['']);
                    }
                });
            });
           
           
           
           
           	//Thumbnail URL check
            $('.thumb-check').on('click', function(e){
            	e.preventDefault();
            	
                var imgUrl = $(this).prevAll('input').val();
                var $prevFrame = $(this).parents('.thumb-wrap').find('.thumb-prev');
                var $th = $(this);
                var img = new Image();
                img.src = imgUrl;
                //console.log(img);
                
                img.onerror = function(){
                	$prevFrame.empty();
                    $prevFrame.append('<span class="no-img text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 画像が見つかりません</span>');
                    
                    $th.parents('.thumb-wrap').children('.thumb-choice-hidden').val(0);
                    $th.parents('.thumb-wrap').children('.thumb-success-hidden').val(0);
                    //console.log('Error');
                }
                
                img.onload = function(){
                	$prevFrame.empty();
                	$prevFrame.append('<img src="'+ imgUrl +'">');
                    
                    $th.parents('.thumb-wrap').children('.thumb-choice-hidden').val(1);
                    $th.parents('.thumb-wrap').children('.thumb-success-hidden').val(1);
                    
                    console.log($th.parents('.thumb-wrap').children('.thumb-choice-hidden').val());
                	console.log($th.parents('.thumb-wrap').children('.thumb-success-hidden').val());
                }
                
            });
            //---------
           
           	//Image File load Btn
            $('.img-file').on('click', function(){
            	var $th = $(this);
                $th.on('change', function(e){
                	var file = e.target.files[0],
                    reader = new FileReader(),
                    $preview = $(this).parents('.item-image').find('.preview');
                    t = this;

                    // 画像ファイル以外の場合は何もしない
                    if(file.type.indexOf("image") < 0){
                      return false;
                    }

                    // ファイル読み込みが完了した際のイベント登録
                    reader.onload = (function(file) {
                      return function(e) {
                        //既存のプレビューを削除
                        $preview.empty();
                        // .prevewの領域の中にロードした画像を表示するimageタグを追加
                        $preview.append($('<img>').attr({
                                  src: e.target.result,
                                  width: "100%",
                                  //class: "preview",
                                  title: file.name
                        }));
                        //console.log(file.name);
                        $th.nextAll('.image-choice-hidden').val(0);
                        $th.nextAll('.image-success-hidden').val(1);
                        
                      };
                	})(file);

                	reader.readAsDataURL(file);
                });
            	
            });
           
           	//Image url check
            $('.img-check').on('click', function(e){
            	e.preventDefault();
            	
                var imgUrl = $(this).prev('input[type="text"]').val();
                var $prevFrame = $(this).parents('.item-image').find('.preview');
                var $th = $(this);
                var img = new Image();
                img.src = imgUrl;
                //console.log(img);
                
                img.onerror = function(){
                	$prevFrame.empty();
                    $prevFrame.append('<span class="no-img text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 画像が見つかりません</span>');
                    
                    $th.nextAll('.image-choice-hidden').val(0);
                    $th.nextAll('.image-success-hidden').val(0);
                }
                
                img.onload = function(){
                	$prevFrame.empty();
                	$prevFrame.append('<img src="'+ imgUrl +'">');
                    $prevFrame.find('img').attr('width', '170px');
                    
                    $th.nextAll('.image-choice-hidden').val(1);
                    $th.nextAll('.image-success-hidden').val(1);
                    
                }
                
            });
           
           
           
           
            //$('.linksel-wrap').find('span').live('click', function(e){
            $(document).delegate('.linksel-wrap span', 'click', function() {
            	var $img = $(this).parent('div').prev('.linkimg-wrap').find('img:visible');
                var num;
                if($(this).is(':first-child')) {
                	if($img.prev().is('img')) {
                		$img.fadeOut(100);
                    	num = $img.prev('img').fadeIn(100).data('count');
                    }
                }
                else {
                	if($img.next().is('img')) {
                    	$img.fadeOut(100);
                		num = $img.next('img').fadeIn(100).data('count');
                    }
                }
                
                $(this).siblings('small').find('em').eq(0).text(num);
            });
        
        },
        
        
        mypagePost: function() {
        	var preventEvent = true;
           
            //Video Upload
            $('.video-file').on('click', function(){
            	var $th = $(this);
                var second = $th.data('sec');
                //console.log($th.data('sec'));
                
                $th.on('change', function(e){
                	var file = e.target.files[0],
                    reader = new FileReader(),
                    $preview = $(this).parents('.thumb-wrap').find('.thumb-prev');
                    
                    $th.next('.help-block').find('strong').text('');

                    // 画像ファイル以外の場合は何もしない
//                    if(file.type.indexOf("video") < 0){
//                      return false;
//                    }

                    // ファイル読み込みが完了した際のイベント登録
                    reader.onload = (function(file) {
                      return function(e) {
                      
                      	console.log(e.target);
                      
                        //既存のプレビューを削除
                        $preview.empty();
                        // .prevewの領域の中にロードした画像を表示するimageタグを追加
                        $preview.append($('<video>').attr({
                                //id:'mv',
                                src: e.target.result,
                                width: "100%",
                                controls: "1",
                                class: "mv",
                                preload: "auto",
                                //title: file.name
                        }));
                        
//                        var $mv = $preview.find('video');
//                        
////                        $mv[0].addEventListener('durationchange', function(){
////                            console.log(this.duration);
////                        });
//                        
//                        $mv.on('durationchange', function(){
//                        	//console.log($(this)[0].duration);
//                            var duration = $(this)[0].duration;
//                            
//                            if(duration < second-1) {
//                            	var str = '撮影動画の秒数が少なすぎます。';
//                            	$th.next('.help-block').find('strong').text(str);
//                            }
//                            else if(duration > second+2) {
//                            	var str = '撮影動画の秒数が長すぎます。';
//                            	$th.next('.help-block').find('strong').text(str);
//                            }
//                            
//                        });
                        
                        
                        
                        //console.log(file.name);
                        //$th.parents('.thumb-wrap').children('.thumb-choice-hidden').val(0);
                    	//$th.parents('.thumb-wrap').children('.thumb-success-hidden').val(1);
                        
                        //console.log($th.parents('.thumb-wrap').children('.thumb-choice-hidden').val());
                        //console.log($th.parents('.thumb-wrap').children('.thumb-success-hidden').val());
                        };
                    })(file);

                	reader.readAsDataURL(file);
                });
            	
            });
           
           
           	//Check
        	$('button#mvUp').on('click', function(e){
            	$('.help-block').find('strong').text('');
                $th = $(this);
                
            	if(preventEvent) {
                    e.preventDefault();
                    var action = $(this).parents('form').attr('action');
                    //console.log(action);
                    
                    
                    var errors = [];
                    
                    var atc = '<i class="fa fa-exclamation-circle" aria-hidden="true"></i> ';
                    var at = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ';
                    var hisu = atc + '動画をUPして下さい';
                    var hisuT = atc + '入力して下さい';
                    var leng = atc + '20文字以内で入力して下さい';
                    var mvsmall = atc + '撮影動画の秒数が少なすぎます。';
                    var mvlarge = atc + '撮影動画の秒数が長すぎます。';
                    
                    
                    function outputError (id, str, num) {
                        $(id).eq(num).next('.help-block').find('strong').html(str);
                        $('.all-wrap').eq(num).slideDown(300);
//                        $th.next('.help-block').find('strong').fadeOut(150, function(){
//                        	$(this).html(at + '入力内容にエラーがあります。').fadeIn(150);
//                            $('.all-wrap').eq(num).slideDown(300);
//                        });
                        return str;
                    }
                    
                    var l = $('input.count').length;
                    //console.log(l);
                    var n = 0;
                    
                    //l= 1;
                    //subtext
                    while(n < l) {
                    	
                        var temps = 0;
                        
                        /*if($('input.subtext').eq(n).val() == '') {
                            errors.push(outputError('input.subtext', hisu, n));
                        }
                        else */
                        if($('input.subtext').eq(n).val().length > 21) {
                            errors.push(outputError('input.subtext', leng, n));
                            temps++;
                        }
                        
                        if($('input.video-file').eq(n).val() == '') {
                            errors.push(outputError('input.video-file', hisu, n));
                            temps++;
                        }
                        else { //撮影動画の秒数を確認
                        
                            var $mv = $('.thumb-wrap').eq(n).find('video.mv');
                            var duration = $mv[0].duration;
                            //console.log(duration);
                            var second = $('input.video-file').eq(n).data('sec');
                            
                            if(duration < second-1) { //少ない場合　誤差-1
                                errors.push(outputError('input.video-file', mvsmall, n));
                                temps++;
                            }
                            else if(duration > second+2) { //少ない場合 誤差+2
                                errors.push(outputError('input.video-file', mvlarge, n));
                                temps++;
                            }
                        }
                        
                        if(!temps) {
                        	$('.all-wrap').eq(n).slideUp(100);
                        }
                        
                        n++;
                    }
                    
                    //url
//                    if($('input#movie_url').val() == '') {
//                    	errors.push(outputError('movie_url', hisu));
//                    }
//                    else if($('input#movie_url').val().length > 255) {
//                    	errors.push(outputError('movie_url', leng));
//                    }
                    //url unique
//                    var urls = $('.movie-url').text();
//                    var urlArr = urls.split(',');
//                    var url = $('input#movie_url').val();
//                    if(url.slice(-1) == '/') {
//                    	url = url.slice(0, -1);
//                    }
//                    $.each(urlArr, function(key, elem) {
//                    	if(url == elem) {
//                        	errors.push(outputError('movie_url', '既存の動画サイトです'));
//                        	return false;
//                        }
//                    });
//                    
//                    
//                    if(!$('select#cate_id').val()) {
//                    	$('select#cate_id').next('.help-block').find('strong').text('選択してください');
//                    	errors.push('選択してください');
//                    }
                    
                    //console.log(errors.length);
                    
//                    $('body').append($('<div>').attr(
//                    	{
//                            class: "waiting",
//                        }
//                    ));

					//errors = [];
                    
                    if(!errors.length) { //Errorがなければ
						
                        var h = $(window).height();
                        $('.waiting').css({height:(h+100), paddingTop:h/2}).fadeIn(300);

						var form = $('#postMv').get()[0];
                        var formData = new FormData( form ); // FormData オブジェクトを作成
                        
                        $.ajax({
                            url: '/contribute',
                            type: "POST",
                            cache: false,
                            data: formData,
                            processData: false,
                            contentType: false,
                            //dataType: "json",
                            success: function(resData){
                                //console.log(resData.image[0]);
                                //$('body').html(resData).slideDown(100);
                                //history.pushState(resData, null, '/contribute/2');
                            	var q;
                               	if(resData == 1) {
                                    q=1;
                                }
                                else if(resData == 303) {
                                    q=300;
                                }
                                else {
                                    q=500;
                                }
                               
                                location.href="/contribute/finish?state=" + q;
                               
                            },
                            error: function(xhr, ts, err){
                                //resp(['']);
                            }
                        });
                        
                        return false;
                        
//                    	preventEvent = false;
//                		$(this).trigger('click');
                    }
                    else {
                        $th.next('.help-block').find('strong').fadeOut(150, function(){
                        	$(this).html(at + '入力内容にエラーがあります。').fadeIn(150);
                        });
                        
                        $('h4').next('div').find('strong').fadeOut(150, function(){
                        	$(this).html(at + '入力内容にエラーがあります。').fadeIn(150);
                        });
                        
                        $('html,body').animate({ scrollTop:0 }, 300, 'linear');
                        
                    }
                }
                
            });
        },
        
        animFunc: function() {
           
            $('.second').on('click', function(e){
            	console.log('click');
            	$(this).next('.all-wrap').slideToggle(300);
            });
           
        },
        
        
        
        
    } //return

})();


 
$(function(e){ //ready
    
    //exe.autoComplete();
    
    exe.scrollFunc();
    exe.toggleSp();
  
  	//exe.addClass();
  
    //exe.addItem();
    //exe.eventItem();
  
  	var set = 1;
  
    if(set) {
    	exe.mypagePost();
    }
  
    exe.animFunc();

});



})(jQuery);
