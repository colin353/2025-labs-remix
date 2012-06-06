<?php $c = $c->getSubEntity() ?>

<?if(!$ajax):?>

<script src=<?=base_url()?>media/jquery.filedrop.js ></script>



<script>

$(document).ready(function() {	
	var dropbox = $('#entityinteractor');
		message = $('.message', dropbox);
	
	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'pic',
		maxfiles: 5,
    	maxfilesize: 10,
		url: '<?=base_url()?>collaborate/system/upload',
		
		uploadFinished:function(i,file,response){
			if(response != parseInt(response)) {
				alert('Something went wrong in the file upload!');
				return;
			}
			$("div.overlay, div.overform").fadeIn('slow');
			$("#blob_id").val(response);
			
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Your browser does not support HTML5 file uploads!');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select 5 at most! (configurable)');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 2mb (configurable).');
					break;
				default:
					alert("jesus");
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			return true;
		},
		
		uploadStarted:function(i, file, len) {
			
		},
		
		progressUpdated: function(i, file, progress) {
		}
    	 
	});
});

function ajaxSubmitEntityInteractor(x,d) {
	$.post("<?=base_url()?>collaborate/system/postcomment",
		{
			message:$("input#entityinteractor_message").val(),
			context:$("input#entityinteractor_context").val()		
		},function() {
			$.post("<?=base_url()?>collaborate/timeline/display/"+$("#entityinteractor_context").val(),
				{
					ajax:true
				},
				function(r) {
					$("div#timelinecontainer").html(r);
					$("input#entityinteractor_message").val('');
				}
			);
		}
	);
	
	return false;
}

function ajaxSubmitSearch() {
	$.post("<?=base_url()?>collaborate/timeline/display/"+$("#entityinteractor_context").val()+"/"+$("input#search").val(),
			{
				ajax:true
			},
			function(r) {
				$("div#timelinecontainer").html(r);
			}
	);
	
	return false;
}

function ajaxSubmitCaption() {
	$.post("<?=base_url()?>collaborate/system/uploadCaption",
		{
			caption: $("#captiontext").val(),
			blob_id: $("#blob_id").val(),
			context: $("input#entityinteractor_context").val()
		},
	function() {
		$("div.overlay, div.overform").fadeOut('slow');
		$("#blob_id").val(0);
		ajaxSubmitSearch();
	}
	);
	
	return false;
}
	
</script>

<form onsubmit="return ajaxSubmitSearch()">
<input type=text name=search id=search placeholder="Search for something" />
<input type=submit value=search style="display:none;" />
</form>

<div class=mainentitycontainer>
<?=$c->renderEntity()?>
</div>
<hr>

<div id=timelinecontainer>


<?endif?>

<?if(!empty($c->searchKeywords)): ?>
	<span>Searched for: <?=$c->searchKeywords;?></span>
<?endif?>

<?php
$ents = $c->getSubEntities(true);
if(empty($ents)):?>

<p>Nothing here yet...</p>

<?else: foreach($ents as $e):?>
	<div class=entitycontainer onclick=doEntity(<?=$e->entity?>) ><?=$e->renderMinorEntity()?></div>
<?endforeach;endif; ?>

</div>

<?if(!$ajax):?>

</div>

<div class=entityinteractor id=entityinteractor>
<form onsubmit="return ajaxSubmitEntityInteractor('postComment')">
<input type=text id=entityinteractor_message placeholder="Write a comment, or drag and drop a file!" />
<input type=submit value=Post />
<input type=hidden id=entityinteractor_context value=<?=$c->id?> />
</form>
</div>

<div class=overlay ></div>
<div class=overform>
<h3>You uploaded a file!</h3>
<p>Give the file a useful caption.</p>
<form onsubmit="return ajaxSubmitCaption()" >
<p><label>Caption</label><input type=text id=captiontext style="width: 300px;" /></p>
<input type=hidden id=blob_id />
<input type=submit value=Finish! />
</form>
</div>

<div class=entityinteractorspacer></div>

<?endif?>