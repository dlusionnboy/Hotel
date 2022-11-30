<?php

use CodeIgniter\Email\Email;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Email as ConfigEmail;

/**
 * @internal
 */
class EmailTest extends CIUnitTestCase{

    public function testKirimEmail(){
        $email = new Email( new ConfigEmail());
        $email->setFrom('syarifihsan17@gmail.com');
        $email->setTo('muhihsanrismawan@gmail.com');
        $email->setSubject('Testing Kirim Email');
        $email->setMessage('Hallo Selamat <b>bergabung</b>');

        $this->assertTrue($email->send());
      }
}