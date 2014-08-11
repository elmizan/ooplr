<?php

function escape($string){
	return htmlentities($string, ENT_QOUTES, 'UTF-8');
}