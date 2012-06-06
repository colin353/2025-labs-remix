<h2>Projects <span class=subtext><a href=<?=base_url()?>collaborate/projects/add>+ add new project</a></span></h2>

<p>Current 2025 projects:</p>


<?if(empty($projects)):?>
<p>No projects here!</p>
<?else: foreach($projects as $p):?>
	<div onclick=doEntity(<?=$p->entity?>)>
		<h3><?=$p->name?></h3>
		<p><?=$p->description?></p>
	</div>
<?endforeach; endif;?>