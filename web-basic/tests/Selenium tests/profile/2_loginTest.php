<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * Description of registerTest
 *
 * @author David
 */
class LoginTest extends PHPUnit_Extensions_SeleniumTestCase {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://127.0.0.1:81/");
    }
    
    function testLoginError_inputTooShort() {
        $this->open("cursus-php/web-basic/profile/login.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "123");
        $this->type("id=password", "123");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTitle("Log in - Afspraken planner"); //Page should not have switched!
        $this->verifyTextPresent("Het gebuikersnaam veld moet minstens 4 karakters lang zijn");
        $this->verifyTextPresent("Het paswoord veld moet minstens 4 karakters lang zijn");
    }
    
    function testLoginError_wrongUsernameAndPasswordCombination() {
        $this->open("cursus-php/web-basic/profile/login.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "1234");
        $this->type("id=password", "1234");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTitle("Log in - Afspraken planner"); //Page should not have switched!
        $this->verifyTextPresent("Foutieve gebruikersnaam/paswoord combinatie!");
    }
    
    function testLogin_inputTooLong() {
        $this->open("cursus-php/web-basic/profile/login.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "abcdefghijabcdefghijabcdefghijabcdefghij");
        $this->type("id=password", "abcdefghijabcdefghijabcdefghijabcdefghij");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTextPresent("U bent nu ingelogd."); //Our HTML limit should cut away all the overflowing chars
        //We use assert instead of verify here because our next tests depends on us logging in sucessfully!
    }
    
    function testLogout_Success() {
        $this->open("cursus-php/web-basic/profile/login.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "pigee");
        $this->type("id=password", "1234");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTextPresent("U bent nu uitgelogd."); //Our HTML limit should cut away all the overflowing chars
        $this->open("cursus-php/web-basic/profile/logout.php");
        $this->waitForPageToLoad("20000");
        $this->assertTextPresent("U bent nu uitgelogd");
        //We use assert instead of verify here because our next test depends on us logging out sucessfully!
    }
    
    function testLogin_Success() {
        $this->open("cursus-php/web-basic/profile/login.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "MyUsername");
        $this->type("id=password", "password");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->verifyTextPresent("U bent nu ingelogd.");
    }

}

?>