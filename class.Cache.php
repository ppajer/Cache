<?php

 class Cache {

	private $path;
	private $expiry;
	private $data;

	public function __construct($path, $expiry, $update) {
		$this->path = $path;
		$this->expiry = $expiry;
		
		if ($this->needsUpdate()) {
			$this->writeFile(call_user_func($update));
		}

		$this->data = $this->readFile();
	}

	public function read() {
		return $this->data;
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
