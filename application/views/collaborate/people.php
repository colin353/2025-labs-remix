<h2>People</h2>

<p>Current 2025 employees:</p>

<?if(empty($people)):?>
<p>No projects here!</p>
<?else: foreach($people as $p):?>
	<h3 onclick='window.location="<?=base_url()?>collaborate/timeline/display/1/<?=$p->name?>"'><?=$p->renderColourBox().$p->firstname." ".$p->lastname?></h3>
<?endforeach; endif;?>