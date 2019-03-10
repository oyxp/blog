<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2019/3/10
 * Time: 11:26 AM
 */

$username = 'Snail';
function test(&$username){
	$username = 'ZED';
    echo $username,PHP_EOL;
}
echo $username,PHP_EOL;
test($username);
echo $username,PHP_EOL;