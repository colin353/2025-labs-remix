<h2>People</h2>

<p>Current 2025 employees:</p>

<?foreach($people as $p):?>
	<h3><?=$p->renderColourBox().$p->firstname." ".$p->lastname?></h3>
<?endforeach?>