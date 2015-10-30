<div class="form">

	<h3>Загрузка файлов и drag&drop</h3>
    <form action="/index.php/images/addajax" method="POST" enctype="multipart/form-data">
      Чтобы добавить картинки, выбери их в поле<br/><br/>
         <input type="file" name="my-pic" id="file-field" /><br/>
         <input type="hidden" value="" name="post_id" id="post_id" />
        или просто перетащи в область ниже &dArr;
    </form>
    <div id="img-container">
        <ul id="img-list"></ul>
    </div>

    <button id="upload-all">Загрузить все</button>
    <button id="cancel-all">Отменить все</button>
    
</div><!-- form -->