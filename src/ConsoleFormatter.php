<?php
namespace gabrielmendonca;

class ConsoleFormatter {

  private $lines = [];

  /**
   * Guarda referência para as linhas onde serão colocados os separadores
   */
  private $separator_lines = [];
  /**
   * Guarda o caracter utilizado para separador
   */
  private $separator_line_char = [];

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

  public function __construct () {
    $this->lines[] = "";
  }

  /**
   * mount a color string
   * @param int $indexColor - value between [0...7]
   * @param int $type - value between [0,1] - Define 0 for foreground and 1
   * for background
   * @param boolean $strong - [true | false]
   * @return int $color
   */
  private function mountColor (int $indexColor = 7, int $type = self::TYPE_FOREGROUND, bool $strong = false ) {
    $dec = 30;
    $dec = $type === self::TYPE_BACKGROUND ? 40: $dec;
    $dec = $strong ? $dec === 40 ? 100 : 90 : $dec;

    return $dec + $indexColor;
  }

  /**
   * Resolve code of color
   * @param int $indexColor - inteiro que define a cor a ser atribuida
   * @param int $type - inteiro que define qual o tipo, 0 - normal, 1 - background
   * @param boolean $strong - verdadeiro ou falso
   * @return string $string_formated_color
   */
  private function resolveColor (int $indexColor = 7, int $type = 0, bool $strong = false) {
    return chr(self::SCAPE_CHAR) . "[" . $this->mountColor($indexColor, $type, $strong) . "m";
  }

  /**
   * Retorna o código de cor por nome
   * @param string $name - nome da cor, para retornar o código
   * @return int $codigoCor - código da cor passada ou cor de reset se não existir
   */
  private function getColorByName ($name = "") {
    if (in_array($name, $this->colors)) {
      $flip = array_flip($this->colors);
      return $flip[$name];
    }

    return self::COLOR_RESET;
  }

  /**
   * Adiciona cor para buffer
   * @param string $colorName - nome da cor
   * @return ConsoleFormatter
   */
  public function color ($color = self::COLOR_WHITE) {
    /* reverse keys to values */
    $color = $this->getColorByName($color);
    return $this->str($this->resolveColor($color));
  }

  /**
   * Adicionar cor ao background
   * @param string $colorName - nome da cor
   * @return ConsoleFormatter
   */
  public function background($color = "") {
    /* reverse keys to values */
    $color = $this->getColorByName($color);
    return $this->str($this->resolveColor($color, 1));
  }

  /**
   * Adicionar conteúdo ao buffer
   * @param string $string - conteúdo para buffer
   * @return ConsoleFormatter
   */
  public function str($string) {

    $total_lines = count($this->lines);
    $this->lines[$total_lines - 1] .= $string;

    if(strstr($string, "\n") !== false) {
      // has searched new line
      array_push($this->lines, "");
    }
    return $this;
  }

  /**
   * Criar separador de linha e adiciona no buffer
   * @return ConsoleFormatter
   */
  public function separator ($separator_char = "=") {

    $current_line = count($this->lines) - 1;

    $this->str("\n");
    $count_line = count($this->lines) - 1;
    $this->str("\n");
    $this->str("\n");

    // grava a referência
    $this->separator_lines[] = &$this->lines[$count_line];
    $this->separator_line_char[] = $separator_char;

    return $this;
  }

  /**
   * Adiciona quebra de linha ao buffer
   * @return ConsoleFormatter
   */
  public function ln() {
    return $this->str("\n");
  }

  /**
   * Adiciona tab ao buffer
   * @return ConsoleFormatter
   */
  public function tab() {
    return $this->str('  ');
  }

  private function maxLineString () {
    $max = 0;
    foreach($this->lines as $line) {
      $totalLine = strlen($line);

      if ($totalLine > $max) {
        $max = $totalLine;
      }
    }
    return $max;
  }

  /**
   * Retorna string formatada
   */
  public function __toString () {

    // Add separator
    $maxLineString = $this->maxLineString();
    for($i = 0; $i < count($this->separator_lines); $i++) {
      for ($n = 0; $n < $maxLineString; $n++) {
        $this->separator_lines[$i] .= $this->separator_line_char[$i];
      }
    }

    $content = "";
    foreach($this->lines as $line){
      $content .= $line;
    }

    return $content;
  }

}
