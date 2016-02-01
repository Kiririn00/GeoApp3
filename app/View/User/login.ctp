<!-- this is view -->

<h2>Login</h2>

<?php
echo $this->Form->create('User',array('type' => 'post'));
echo $this->Session->flash();
?>

<div class="form-group">
<?php
echo $this->Form->input('PenName',array(
	'label' => false,
	'placeholder' => 'Enter PenName',
	'class' => 'form-control'
	));
?>
</div>

<div class="form-group">
<?php
echo $this->Form->input('Password',array(
	'type' => 'password',
	'label' => false,
	'placeholder' => 'Enter Password',
	'class' => 'form-control'
));
?>
</div>

<?php
//in future may be I will add forgot password system
echo $this->Form->end('Login');
?>

