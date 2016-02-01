<!-- This is View -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Edit Profile 
			<small>You can edit your profile at this page</small>
		</h1>			
	</div>
</div>

	<?php
	echo $this->Form->create(array(
		'enctype' => 'multipart/form-data',
		'type' => 'post'	
	));
	?>
	Pen Name
	<?php
	echo $this->Form->input('Pen Name',array(
		'value' => $UserData['User']['pen_name'],
		'label' => false,
		'class' => 'form-control'
	));
	?>
	Password
	<?php
	echo $this->Form->input('Password',array(
		'value' => $UserData['User']['password'],
		'label' => false,
		'class' => 'form-control'

	));
	?>
	Email
	<?php
	echo $this->Form->input('Email',array(
		'value' => $UserData['User']['email'],
		'label' => false,
		'class' => 'form-control'

	));
	?>

	<br/>
	Current Display Image
	<br/>
	<?php
		echo $this->Html->image($UserData['User']['display_image_name'],array(
			'id' => 'article_image'
		));	
	?>
	<br/>

	New Image
	<input type="file" name="display_image" ><br/>


	<?php 
	echo $this->Form->end('Update');
	?>

