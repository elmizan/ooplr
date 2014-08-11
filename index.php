<?php
require_once 'core/init.php';

$user = DB::getInstance()->get('users', array('username', '=', 'billy'));

if(!$user->count())
{
	echo 'No User';	
}
else
{
	echo $user->first()->username;
}	