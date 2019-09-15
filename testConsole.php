<?php
  require dirname(__FILE__) . '/vendor/autoload.php';

  use gabrielmendonca\ConsoleFormatter;

  $formatter = new ConsoleFormatter();
  echo $formatter
    -> ln()
    -> ln()
    -> str(" >>> Hello, i'm a command line helper <<<")
    -> ln()
    -> color(ConsoleFormatter::COLOR_RED)
    -> separator()
    -> color() // reset to default color
    -> ln()

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
    -> str(' - extend size of text ')
    -> separator('-')

    -> ln()
    -> ln()

    -> background(ConsoleFormatter::COLOR_YELLOW)
    -> color(ConsoleFormatter::COLOR_RED)
    -> str(" Esta lib está em desenvolvimento ") -> ln()
    -> str(" Se gostou, você pode ajudar!!! ")
    -> background() -> color()
    -> ln()
    -> ln();
