<?php
namespace gabrielmendonca;

class ConsoleFormatter {

  private $count_line = 0;
  private $content = "";
  private $current_line = "";

  /** styles **/
  const ST_RESET = 'reset';
  const ST_BOLD = 'bold';
  const ST_UNDERLINE = 'underline';
  const ST_INVERSE = 'inverse';

  /** colors names **/
  const COLOR_BLACK = 'black';
  const COLOR_RED = 'red';
  const COLOR_GREEN = 'green';
  const COLOR_YELLOW = 'yellow';
  const COLOR_BLUE = 'blue';
  const COLOR_MAGENTA = 'magenta';
  const COLOR_CYAN = 'cyan';
  const COLOR_WHITE = 'white';

  /** types **/
  const TYPE_FOREGROUND = 0;
  const TYPE_BACKGROUND = 1;

  /** scape char **/
  const SCAPE_CHAR = 0x1B;
  const COLOR_RESET = "0";

  public $styles = [
    self::ST_RESET => 0,
    self::ST_BOLD => 1,
    self::ST_UNDERLINE => 4,
    self::ST_INVERSE => 7
  ];

  public $colors = [
    self::COLOR_BLACK,
    self::COLOR_RED,
    self::COLOR_GREEN,
    self::COLOR_YELLOW,
    self::COLOR_BLUE,
    self::COLOR_MAGENTA,
    self::COLOR_CYAN,
    self::COLOR_WHITE
  ];

  public function __constructor () {
    $this->content = "";
  }

  /**
   * mount a color string
   * @param int $indexColor - value between [0...7]
   * @param int $type - value between [0,1] - Define 0 for foreground and 1
   * for background
   * @param boolean $strong - [true | false]
   */
  private function mountColor (int $indexColor = 7, int $type = self::TYPE_FOREGROUND, bool $strong = false ) {
    $dec = 30;
    $dec = $type === self::TYPE_BACKGROUND ? 40: $dec;
    $dec = $strong ? $dec === 40 ? 100 : 90 : $dec;

    return $dec + $indexColor;
  }

  private function resolveColor (int $indexColor = 7, int $type = 0, bool $strong = false) {
    return chr(self::SCAPE_CHAR) . "[" . $this->mountColor($indexColor, $type, $strong) . "m";
  }

  private function getColorByName ($name = "") {
    if (in_array($name, $this->colors)) {
      $flip = array_flip($this->colors);
      return $flip[$name];
    }

    return self::COLOR_RESET;
  }

  public function color ($color = self::COLOR_WHITE) {
    /* reverse keys to values */
    $color = $this->getColorByName($color);
    return $this->str($this->resolveColor($color));
  }

  public function background($color = "") {
    /* reverse keys to values */
    $color = $this->getColorByName($color);
    return $this->str($this->resolveColor($color, 1));
  }

  public function str($string) {
    $this->content .= $string;
    $this->current_line = $this->content;

    if(strstr($string, "\n") !== false) {
      // has searched new line
      $this->current_line = '';
    }

    return $this;
  }

  public function separatorStyle1 () {
    $str = "\n";
    for($i = 0; $i < strlen($this->current_line); $i++) {
      $str .= "=";
    }
    $str .= "\n";

    $this->str($str);

    return $this;
  }

  public function ln() {
    return $this->str("\n");
  }

  public function tab() {
    return $this->str('  ');
  }

  public function __toString () {
    return $this->content;
  }

}
