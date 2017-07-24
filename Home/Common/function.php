<?php  

function cookie_check(){
	if (md5(cookie('username').C('SALT')) === cookie('coode')) {
		return 1;
	}else{
		return 0;
	}
}