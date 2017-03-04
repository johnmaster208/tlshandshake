<?php
 
class TLSHandshakeTest extends PHPUnit_Framework_TestCase {
  public function testDomainListHasDomains(){
  	$testArray = array(
  		'hostname' => 'MikeyMouse.house',
  		'name' => 'Disney'
  	);
  	//test for NULL
  	$this->assertNotEmpty($testArray['hostname']);
  	$this->assertNotEmpty($testArray['name']);
  	//test for pattern-matching
  	$this->assertRegExp("/[\w]+\.[\w]+/",$testArray['hostname']);
  	$this->assertRegExp("/[\w]+/",$testArray['name']);
  }

  public function testSanitizeText(){
  	$testVersions = array(
  		'|       TLSv1.0:',
  		'|       TLSv1.2:',
  		'|       TLSv1.1:',
  	);
  	$trimVerticalBar = str_replace("|","",$testVersions[0]);
  	$this->assertEquals('       TLSv1.0:',$trimVerticalBar);
  	$trimColon = str_replace(":","",$testVersions[1]);
  	$this->assertEquals('|       TLSv1.2',$trimColon);
  	$trimSpaces = str_replace(" ", "", $testVersions[1]);
  	$this->assertEquals('|TLSv1.2:',$trimSpaces);
  	$trimAll = str_replace(array("|",":"," "),"",$testVersions[2]);
  	$this->assertEquals('TLSv1.1',$trimAll);
  }

  public function testHandshakePass() {
  	$v0 = TRUE;
  	$v1 = TRUE;
  	$v2 = TRUE;
  	$this->assertTrue($v0 == TRUE && $v1 == TRUE && $v2 == TRUE);
  	$v0 = FALSE;
  	$v1 = TRUE;
  	$v2 = TRUE;
  	$this->assertFalse($v0 == TRUE && $v1 == TRUE && $v2 == TRUE);
  	$v0 = TRUE;
  	$v1 = FALSE;
  	$v2 = TRUE;
  	$this->assertFalse($v0 == TRUE && $v1 == TRUE && $v2 == TRUE);
  	$v0 = TRUE;
  	$v1 = TRUE;
  	$v2 = FALSE;
  	$this->assertFalse($v0 == TRUE && $v1 == TRUE && $v2 == TRUE);
  }
 
}