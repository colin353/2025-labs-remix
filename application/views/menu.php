<?php 

if(!isset($menu)) 

if(isLoggedIn()) 
	$menu = array(
			'projects'	=>'collaborate/projects',
			'people' 	=>'collaborate/people'
	);
else 
	$menu = array(
			'contact'	=>'welcome/contact',
			'latest' 	=>'welcome/latest',
			'people' 	=>'welcome/people',
			'about 2025' 	=>'welcome/about',
			'login'		=>'welcome/login'
	);

?>


<ul>

<?if(!empty($menu)) foreach($menu as $name=>$url):?>
	
	<li>
		<a href=<?=base_url().$url?>>
			<?if($name == $selected):?>
				<strong><?=$name?></strong>
			<?else:?>
				<?=$name?>
			<?endif?>
		</a>
	</li>
<?endforeach?>

</ul>