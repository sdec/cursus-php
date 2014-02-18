<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * Description of registerTest
 *
 * @author David
 */
class RegisterTest extends PHPUnit_Extensions_SeleniumTestCase {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://127.0.0.1:81/");
    }
    
    function testRegisterError_inputTooShortAndPasswordsDoNotMatch() {
        $this->open("cursus-php/web-basic/profile/register.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "123");
        $this->type("id=firstname", "1");
        $this->type("id=lastname", "1");
        $this->type("id=password", "123");
        $this->type("id=passwordConfirm", "321");
        $this->type("id=email", "firstname.lastname@student.khleuven.be");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTitle("Registreren - Afspraken planner"); //Page should not have switched!
        $this->verifyTextPresent("Het gebuikersnaam veld moet minstens 4 karakters lang zijn");
        $this->verifyTextPresent("Het voornaam veld moet minstens 2 karakters lang zijn");
        $this->verifyTextPresent("Het familienaam veld moet minstens 2 karakters lang zijn");
        $this->verifyTextPresent("Het paswoord veld moet minstens 4 karakters lang zijn");
        $this->verifyTextPresent("Het paswoord & paswoord confirmatie veld moeten hetzelfde zijn");
    }
    
    function testRegister_Success() {
        $this->open("cursus-php/web-basic/profile/register.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "MyUsername");
        $this->type("id=firstname", "firstname");
        $this->type("id=lastname", "lastname");
        $this->type("id=password", "password");
        $this->type("id=passwordConfirm", "password");
        $this->type("id=email", "firstname.lastname@student.khleuven.be");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTextPresent("Registratie compleet");
    }
    
    function testRegisterError_UsernameAlreadyExists() {
        $this->open("cursus-php/web-basic/profile/register.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "MyUsername");
        $this->type("id=firstname", "firstname");
        $this->type("id=lastname", "lastname");
        $this->type("id=password", "password");
        $this->type("id=passwordConfirm", "password");
        $this->type("id=email", "firstname.lastname@student.khleuven.be");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTextPresent("Deze gebruikersnaam bestaat al");
    }

}

?>