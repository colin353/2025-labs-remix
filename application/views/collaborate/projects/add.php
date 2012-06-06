<h2>Create new project</h2>

<p>Create a new project. Give it a cool-sounding name!</p>

<form action=<?=base_url()?>collaborate/projects/create method=post >
<p><label>Project Name</label><input style="width: 250px;" type=text name="name" /></p>

<p><input type=submit value="Create Project" /></p>
</form>