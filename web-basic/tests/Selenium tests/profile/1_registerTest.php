<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * Description of registerTest
 *
 * @author David
 */
class RegisterTest extends PHPUnit_Extensions_SeleniumTestCase {

    function setUp() {
        $this->setBrowser("*chrome");
        $this->setBrowserUrl("http://127.0.0.1:81/");
    }
    
    /*//ZELFS I.E. heeft dit als default in HTML ingebouwd
     * function testRegisterError_PleaseFillInField() { //UNNESSECARY because our HTML 'required' tag forces the user to fill this in
        $this->open("cursus-php/web-basic/profile/register.php");
        $this->waitForPageToLoad("20000");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTitle("Registreren - Afspraken planner"); //Page shouldn't have switched!
    }
    
     * //ZELFS I.E. heeft dit als default in HTML ingebouwd
    function testRegisterError_InvalidEmail() { //UNNESSECARY because our HTML 'email' tag validates this input prior to sending it to the server!
        $this->open("cursus-php/web-basic/profile/register.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "MyUsername");
        $this->type("id=firstname", "firstname");
        $this->type("id=lastname", "lastname");
        $this->type("id=password", "password");
        $this->type("id=passwordConfirm", "password");
        $this->type("id=email", "firstname");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->assertTitle("Registreren - Afspraken planner"); //Page should not have switched!
    }*/
    
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
    
    function testRegister_inputTooLong() {
        $this->open("cursus-php/web-basic/profile/register.php");
        $this->waitForPageToLoad("20000");
        $this->type("id=username", "abcdefghijabcdefghijabcdefghijabcdefghij");
        $this->type("id=firstname", "abcdefghijabcdefghijabcdefghijabcdefghij");
        $this->type("id=lastname", "abcdefghijabcdefghijabcdefghijabcdefghij");
        $this->type("id=password", "abcdefghijabcdefghijabcdefghijabcdefghij");
        $this->type("id=passwordConfirm", "abcdefghijabcdefghijabcdefghijabcdefghij");
        $this->type("id=email", "abcdefghijabcdefghij.abcdefghijabcdefghij@student.khleuven.be");
        $this->click("name=submit");
        $this->waitForPageToLoad("20000");
        $this->verifyTextPresent("Registratie compleet"); //Our HTML limit should cut away all the overflowing chars
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
        /*$this->click("link=Ok");
        $this->waitForPageToLoad("30000");
        $this->type("id=username", "MyUsername");
        $this->type("id=password", "password");
        $this->click("name=submit");
        $this->waitForPageToLoad("30000");
        $this->click("link=Ok");
        $this->waitForPageToLoad("30000");
        $this->click("id=themes");
        $this->click("link=Log uit");
        $this->waitForPageToLoad("30000");
        $this->click("link=Ok");
        $this->waitForPageToLoad("30000");*/
        //$this->assertTextPresent("U bent nu uitgelogd");
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