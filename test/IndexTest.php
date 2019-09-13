<?php
  require dirname(__DIR__) . "/vendor/autoload.php";

  use PHPUnit\Framework\TestCase;
  use gabrielmendonca\ConsoleFormatter;

  class IndexText extends TestCase{

    /**
     * @test
     */
    public function testarNovaInstancia () {
      $cf = new ConsoleFormatter();
      $this->assertTrue($cf instanceOf ConsoleFormatter );
    }

  }
