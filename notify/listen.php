<?php

$e = $argv[1];

$c=0;$k=0;

while(file_exists("events/".$e.'-'.(++$c)));

touch("events/".$e.'-'.$c);

while(file_exists("events/".$e.'-'.$c) && ++$k != 1000)  usleep(100000); // Die if nothing after 5 minutes

if($k == 1000) {
		echo "NO...";
		unlink("events/".$e.'-'.$c);
		return;
}
// Everything worked! Yay

echo "OK";
	