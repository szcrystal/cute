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
                $(t.opts.all).animate({ scrollTop:0 }, 1200, 'easeOutExpo');
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
        
        autoComplete: function() {
           
            var data = [];
           
           	function addTagOnArea(target, text, groupId, val=0) {
           		var $tagArea = $(target).siblings('.tag-area');
           		var bool = true;
           
                $tagArea.find('.text-danger').remove();
           
                $tagArea.find('span').each(function(){
                	var preTag = $(this).text();

                	if(text == preTag) {
                    	bool = false;
                    }
                });
           
           		if(bool) {
                	//$tagArea.append('<span data-text="'+text+'" data-group="'+groupId+'" data-value="'+val+'"><em>' + text + '</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>');
                    $tagArea.append('<span><em>' + text + '</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>');
           			//$tagArea.append('<input type="hidden" name="'+groupId+'[]" value="'+text+'">');
                    $tagArea.append('<input type="hidden" name="tags[]" value="'+text+'">');
                }
                else {
           			$tagArea.prepend('<p class="text-danger"><i class="fa fa-exclamation" aria-hidden="true"></i> 既に追加されているタグです</p>');
                }
           
                return bool;
            }
           
            $(document).delegate('.del-tag', 'click', function(e){
                var $span = $(e.target).parent('span');
//                if($span.data('value'))
//                	data[$span.data('group')].splice($span.data('value'), 0, $span.data('text')); //or push
                
                $span.next('input').remove(); //先にinputをremove
                $span.fadeOut(150).remove();
            });
           
           
            $('.tag-control').each(function(){
            	var group = $(this).attr('id');
                var tagList = $(this).siblings('span').text();
                //$('.panel-heading').text(tagList);

                data[group] = tagList.split(',');
                var $tagInput = $('#' + group);
                
                $tagInput.autocomplete({
                    source: data[group],
                    autoFocus: true,
                    delay: 50,
                    minLength: 1,
                    
                    select: function(e, ui){
                    	var $num = data[group].indexOf(ui.item.value); //配列内の位置
                        var bool = addTagOnArea(e.target, ui.item.value, group, $num);
                        if(bool) {
//                        	if($num != -1)
//                            	data[group].splice($num, 1); //リストから削除
	                        
                            ui.item.value = '';
                        }
                    },
                    
                    response: function(e, ui){
                    	//$('.panel-heading').text(ui.content['label']);
                    	//if(ui.content == '') {
                        	$(e.target).siblings('.add-btn:hidden').fadeIn(50).css({display:'inline-block'});
                            //console.log('response');
                        //}
                        //else {
                        //	$(e.target).siblings('.add-btn').fadeOut(100);
                        //}
                        
                        //$(this).autocomplete('widget')
                    },
                    close: function(e, ui){
                    	/*
                    	if($(e.target).val().length > 1) {
                        	$(e.target).siblings('.add-btn').fadeIn(100).css({display:'inline-block'});
                        }
                        */
                    },
                    focus: function(e, ui){
						//console.log(ui.item);
                    },
                    search: function(e, ui){
                    },
                    change: function(e, ui) {
                    	console.log(ui);
                    },
                    
            	}); //autocomplete

                
                $tagInput.next('.add-btn').on('click keydown', function(event){
                	//console.log(event.which);
                	if (event.which == 1 || event.which == 13) {
                        var texts = $('#' + group).val();
                        
                        var bool = addTagOnArea('#' + group, texts, group);
                        if(bool) {
                        	$tagInput.val('');
                        	$(this).fadeOut(100);
                        }
                    }
                });
                
                $tagInput.on('keydown keyup', function(event){ //or keypress
                	if(event.which == 13) {//40
                    	if(event.type=='keydown') { // && $('.ui-menu').is(':hidden')
                        	var texts = $(this).val();
                            if(texts != '') {
                        		if(addTagOnArea(this, texts, group)) { //tag追加
                             		$(this).val('');
                                    //$(this).next('.add-btn:visible').fadeOut(50);
                                }
                             
                                $('.ui-autocomplete').hide();                             
                            }
                        }
                    	event.preventDefault();
                    }
                    
                    //if($(this).val().length < 2) { //event.which == 8 &&
                    if(event.type=='keyup' && $(this).val().length < 1) {
                		$(this).next('.add-btn').fadeOut(10);
                        $(this).siblings('.tag-area').find('.text-danger').remove();
                	}
                    
                    if(event.which != 13 && event.which != 8 && $(this).val().length > 0) {
                    	$(this).siblings('.add-btn:hidden').fadeIn(50).css({display:'inline-block'});
                    }
                });
            
            }); //each function
           
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
           
           
            //Thumbnail Upload
            $('.thumb-file').on('click', function(){
            	var $th = $(this);
                $th.on('change', function(e){
                	var file = e.target.files[0],
                    reader = new FileReader(),
                    $preview = $(this).parents('.thumb-wrap').find('.thumb-prev');
                    //t = this;

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
                        $th.parents('.thumb-wrap').children('.thumb-choice-hidden').val(0);
                    	$th.parents('.thumb-wrap').children('.thumb-success-hidden').val(1);
                        
                        console.log($th.parents('.thumb-wrap').children('.thumb-choice-hidden').val());
                        console.log($th.parents('.thumb-wrap').children('.thumb-success-hidden').val());
                    };
                })(file);

                reader.readAsDataURL(file);
                });
            	
            });
           
           
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
                      
                      	//console.log(e.target);
                      
                        //既存のプレビューを削除
                        $preview.empty();
                        // .prevewの領域の中にロードした画像を表示するimageタグを追加
                        $preview.append($('<video>').attr({
                            //id:'mv',
                            src: e.target.result,
                            width: "100%",
                            controls: "1",
                            //class: "mv",
                            //preload: "auto",
                            //autoplay: 1,
                            //title: file.name
                        }));
                        
//                        var $mv = $preview.find('video');
//                        $mv[0].currentTime = 1;
//                        $mv[0].play();
                        
//                        
//                        $mv[0].addEventListener('durationchange', function(){
//                            //console.log(this.duration);
//                            this.currentTime = 1;
//                            this.play();
//                        });
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
           
        },
        
        
        mypagePost: function() {
        	var preventEvent = true;
           
        	$('input#keep, input#open, input#preview, input#drop').on('click', function(e){
            	$('.help-block').find('strong').text('');
                
            	if(preventEvent) {
                    e.preventDefault();
                    var action = $(this).parents('form').attr('action');
                    console.log(action);
                    var errors = [];
                    var hisu = '必須項目です';
                    var leng = '255文字以内で入力して下さい';
                    
                    function outputError (id, str) {
                        $('input#'+id).next('.help-block').find('strong').text(str);
                        return str;
                    }
                    
                    //title
                    if($('input#title').val() == '') {
                    	errors.push(outputError('title', hisu));
                    }
                    else if($('input#title').val().length > 255) {
                    	errors.push(outputError('title', leng));
                    }
                    //site
                    if($('input#movie_site').val() == '') {
                    	errors.push(outputError('movie_site', hisu));
                    }
                    else if($('input#movie_site').val().length > 255) {
                    	errors.push(outputError('movie_site', leng));
                    }
                    //url
                    if($('input#movie_url').val() == '') {
                    	errors.push(outputError('movie_url', hisu));
                    }
                    else if($('input#movie_url').val().length > 255) {
                    	errors.push(outputError('movie_url', leng));
                    }
                    //url unique
                    var urls = $('.movie-url').text();
                    var urlArr = urls.split(',');
                    var url = $('input#movie_url').val();
                    if(url.slice(-1) == '/') {
                    	url = url.slice(0, -1);
                    }
                    $.each(urlArr, function(key, elem) {
                    	if(url == elem) {
                        	errors.push(outputError('movie_url', '既存の動画サイトです'));
                        	return false;
                        }
                    });
                    
                    
                    if(!$('select#cate_id').val()) {
                    	$('select#cate_id').next('.help-block').find('strong').text('選択してください');
                    	errors.push('選択してください');
                    }
                    
                    //console.log(errors.length);
                    
                    if(!errors.length) {
                    	preventEvent = false;
                		$(this).trigger('click');
                    }
                }
                
            });
        },
        
        
    } //return

})();


$(function(e){ //ready
    
    exe.autoComplete();
    
    exe.scrollFunc();
    exe.toggleSp();
  
  	//exe.addClass();
  
    //exe.addItem();
    exe.eventItem();
    //exe.mypagePost();

});



})(jQuery);
