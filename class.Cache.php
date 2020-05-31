<?php

 class Cache {

	private $path;
	private $expiry;
	private $data;

	public function __construct($path, $expiry, $update = null) {
		$this->path = $path;
		$this->expiry = $expiry;
		
		if ($update) {
			if (!is_callable($update) {
				throw new Exception('Cache::__construct requires its third parameter to be callable');
			}
			if ($this->needsUpdate()) {
				$this->write(call_user_func($update));
			}
		}

		$this->data = $this->readFile();
	}

	public function read() {
		return $this->data;
	}
	 
	public function write($data) {
		$this->data = $data;
		return $this->writeFile($data);
	}

	private function needsUpdate() {
		if (!file_exists($this->path)) {
			return true;
		}
		return ((time() - filemtime($this->path)) > $this->expiry);
	}

	private function readFile() {
		return file_get_contents($this->path);
	}

	private function writeFile($input) {
		return file_put_contents($this->path, $input);
	}
}

?>
