<!-- this is View -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Register
			<small>After register you can create own article and comment in article</small>
		</h1>			
	</div>
</div>


<?php
	echo $this->Form->create('User',array(
		'enctype' => 'multipart/form-data'
	));
	echo $this->Session->flash();
?>

<div class="form-group">
	<label for="">Pen Name</label>
	<?php	
	echo $this->Form->input('User.Pen Name',array(
		'label' => false,
		'class' => 'form-control'
	));
	?>
</div>
<div class="form-group">
	<label for="">Password</label>
	<?php	
	echo $this->Form->input('User.Password',array(
		'label' => false,
		'class' => 'form-control',
		'type' => 'password'
	));
	?>
</div>
<div class="form-group">
	<label for="">Email</label>
	<?php	
	echo $this->Form->input('User.Email',array(
		'label' => false,
		'class' => 'form-control'
	));
	?>
</div>
<div class="form-group">
	<label for="">Display Image</label>
	<input type="file" name="DisplayImage" />
</div>

<?php 
	echo $this->Form->end('Register');
	
?>

