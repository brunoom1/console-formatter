<?php
  require dirname(__FILE__) . '/vendor/autoload.php';

  use gabrielmendonca\ConsoleFormatter;

  $formatter = new ConsoleFormatter();
  echo $formatter
    -> ln()
    -> str(" >>> Hello, i'm a command line helper <<<")
    -> color(ConsoleFormatter::COLOR_RED)
    -> separatorStyle1()
    -> color() // reset to default color

    -> tab ()
    -> color(ConsoleFormatter::COLOR_YELLOW)
    -> str("command")
    -> color() // reset to default color
    -> str(' - this is a description for command')
    -> ln()

    -> tab ()
    -> color(ConsoleFormatter::COLOR_YELLOW)
    -> str("command")
    -> color() // reset to default color
    -> str(' - this is a description for command')
    -> ln();
