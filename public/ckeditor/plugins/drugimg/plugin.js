CKEDITOR.plugins.add( 'drugimg', {
    icons: 'drugimg',
    init: function( editor ) {
        //Plugin logic goes here.
        
        editor.addCommand( 'drugimg', {
            exec: function( editor ) {
                $('.imgArea-job:visible').hide(); //Job用の画像エリアを隠す
                
                $('.imgArea').find('#dropArea').find('img').remove(); //dropArea内の画像はOpen時に全て消す
                
                
            	$('.container-fluid').append('<div class="plugBack"></div>'); //白背景追加
                $('.plugBack').css({ height:$(window).height() });         
                //.plugBackのcssはdbd.cssに入れている
				
                $('html,body').css({overflow:'hidden'});
                
                $('.imgArea').addClass('plug')//display:blockを含むclass
                			.append('<button style="margin-right:1em;" class="addBtn btn btn-success">O K</button>')
                            .append('<button class="closeBtn btn btn-default">キャンセル</button>');
                //$('.plug').css({top:0, left:0});
                //$('.plug').find('.preImg').hide();
                
                $('.addBtn').click(function(){
                	//var str = $('code.addCode').text(); //コードエリア内に書き出すソースをテキストとして取得する
                    /* *** */
                    var posi = $('#position').val(), //selectBoxの値を取る
                    	size = $('#size').val();
                    var link = $('code.addCode').text(); //コードエリアに画像のリンクを入れている
                    
                    var str = '<img src="' + link + '" class="' + posi + ' ' + size + '">';
                    
                    /* *** */
                    editor.insertHtml( str ); //エディタに入れる
                    backAll();
                    return false;
                });
                
                $('.closeBtn').click(function(){
                	backAll();
                    return false;
                }); 
                                
                function backAll() {
                	$('.imgArea').removeClass('plug').find('#del_btn').hide();
                    $('#codeArea').find('code').empty(); //CodeArea内のソースコードを消す

                    $('.addBtn').remove();
                    $('.closeBtn').remove();
                    $('.plugBack').remove();
                    $('html,body').css({overflow:'visible'});
                    $('.imgArea-job:hidden').show();
                }
            }
        });
        
        editor.ui.addButton( 'Drugimg', {
            label: 'addImage',
            command: 'drugimg',
            toolbar: 'others'
        });
        
        
    }
});