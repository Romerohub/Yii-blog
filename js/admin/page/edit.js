$(document).ready(function(){
	//#Post_main_pic

	addMainPic();
	clickByImage();
	
	p = $('.popup__overlay')
	$('#popup__toggle').click(function() {
	    p.css('display', 'block');
	    getPostId();
	});
	p.click(function(event) {
	    e = event || window.event
	    if (e.target == this) {
	        $(p).css('display', 'none')
	    }
	});
	$('.popup__close').click(function() {
	    p.css('display', 'none');
	    return false;
	});

});

/*Добавляем главную картинку к посту*/
function addMainPic(){
	$('.addMainPic').click(function(){
		var parent_li = $(this).closest("li");
		var new_main_pic = parent_li.find('img').attr('src');
		$('#Page_main_pic').val(new_main_pic);
		//console.log($('#Page_main_pic'));
		$('#show_post_main_pic').html("<img width='85px' src='"+new_main_pic+"'>");
		return false;
	});
}

function clickByImage(){
		//Add image to post by click on need image
	$('.img-list li img').click(function(data){
		$('#Page_content').insertAtCaret("<img src='" + $(this).attr('src') + "'>");
	});
}

function getPostId(){
	
	note_type = $("#note_type").val();
	
	post_id = $("#post_id").val();
	if(post_id == ""){
		saveDraft();
	}
	//console.log(post_id);
	return false;	
}
/*Сохраняем черновик поста и получаем его id*/
function saveDraft(){
	//console.log("d3d");
	 $("#upload-all,#cancel-all").attr("disabled", "disabled");
	 
	$("#yw0").append('<input type="hidden" name="Draft" id="tmp_Draft_input" />');
	$.post("/index.php/pages/create/", $("#yw0").serialize(), function(data){
		
		post_id = data;
		$("#Post_id").val(data);
		$('#tmp_Draft_input').remove();
		 $("#upload-all,#cancel-all").removeAttr("disabled");
	});
	
	//
	
	return false;
	
}

/**Для вставки на место курсора напр:$('#thetext,#thearea').insertAtCaret("Текст для вставки");*/
jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                // Для браузеров типа Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                // Для браузеров типа Firefox и других Webkit-ов
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});