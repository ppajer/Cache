<?php

interface ICache {
	public function write($data) : bool;
	public function read() : string;
	public function isExpired() : bool;
}

?>
