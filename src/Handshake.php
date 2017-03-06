<?php

class Handshake {

	private $domains = array();

	private function setup(){
		$this->domains[0] = array('hostname' => 'yahoo.com', 'name' => 'Yahoo');
		$this->domains[1] = array('hostname' => 'msn.com', 'name' => 'MSN');
		$this->domains[2] = array('hostname'=>'ssb.epcc.edu','name'=>'SSB');
	}

	private function sanitize($versions) {
		$cleaned = array();
		foreach($versions as $v) {
			$c = str_replace(array("|",":"," "),"",$v);
			array_push($cleaned, $c);
		}
		return $cleaned;
	}

	private function showHandshakeResults($info){
		$tls0 = $tls1 = $tls2 = FALSE;
		if(in_array('TLSv1.0', $info['versions'])){
			$tls0 = TRUE;
		}
		if(in_array('TLSv1.1', $info['versions'])){
			$tls1 = TRUE;
		}
		if(in_array('TLSv1.2', $info['versions'])){
			$tls2 = TRUE;
		}
		if($tls0 == TRUE && $tls1 == TRUE && $tls2 == TRUE) {
			echo 'PASS: ' . $info['host'] . PHP_EOL; 
		} else {
			echo 'FAILURE: ' . $info['host'] . PHP_EOL;
		}
	}

	public function scanHost() {
		foreach($this->domains as $d){
			$name = isset($d['name']) ? $d['name'] : null;
			$host = isset($d['hostname']) ? $d['hostname'] : null;
			$output = "";
			if($host){
				try {
					shell_exec('clear');
					echo "Testing $name ($host)..." . PHP_EOL;
					$nmap = exec("nmap --script ssl-enum-ciphers -p 443 $host",$output);

				} catch (Exception $e) {
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			}
			$versionGrep = preg_grep("/TLSv1\.\d{1,}:$/",$output);
			$versions = $this->sanitize($versionGrep);
			$this->showHandshakeResults(array('host' => $host, 'versions' => $versions));
		}
	}

	function __construct(){
		$this->setup();
	}

}

?>