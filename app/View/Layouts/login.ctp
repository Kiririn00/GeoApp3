<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());
//check session
$user = $this->Session->read('user_type');
debug($user);

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('1-col-portfolio');	

		echo $this->Html->script('jquery-1.9.1.min');
		echo $this->Html->script('bootstrap.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	
	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">	
		<!-- make grouped in midle displat -->
		<div class="container">
			<!-- navigation -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" 
							data-target="#bs-example-navbar-collapse-1">
			    	<span class="sr-only">Toggle navigation</span>
			    	<span class="icon-bar"></span>
			    	<span class="icon-bar"></span>
			    	<span class="icon-bar"></span>
				</button>
				<?php
				echo $this->Html->link('GeoApp',
					array(
						'action' => 'Home',
					),
					array(
						'class' => 'navbar-brand'		
					)
				);	
		       	       	?>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<!-- no login case -->
					<?php if($UserId==""){ ?>	
						<li>
							<?php
							echo $this->Html->link('Login Page',array(
							'controller' => 'User',
							'action' => 'Login'
							));

							?>
						</li>
						<li>
							<?php	
							echo $this->Html->link('Register',array(
								'controller' => 'User',
								'action' => 'Register'
							));
							?>	
					    	</li>
						<!-- login case -->
					<?php } else{ ?>
						<li>
							<?php
							echo $this->Html->link('New Article',array(
							'action' => 'NewArticle'
							));
							?>
						</li>
						<li>
							<?php
							echo $this->Html->link('Locate Current Location',array(
								'controller' => 'Location',
								'action' => 'CurrentLocation'
							));
					       	       	?>	
						</li>
						<li>
							<?php
						  	echo $this->Html->link('Search Location',array(
								'controller' => 'Location',
								'action' => 'SearchLocation'
							));	
					       	 	?>
						</li>
						<li>
							<?php	
							echo $this->Html->link('My page',array(
								'controller' => 'User',
								'action' => 'UserPage',$UserId
								),
								array(
									'id' => 'menu_link'
								)
							);
							?>	
						</li>
						<li>
							<?php
								echo $this->Html->link('Logout',array(
									'controller' => 'User',
									'action' => 'Logout'
								));
							?>
						
						</li>
							


					<?php } ?>	
				</ul>
			</div><!-- end /.collapse -->		
	</nav><!-- end navigation -->		
	<div class="container">		
			<div id="body">

				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
			</div>
	</div><!-- / .container -->	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
