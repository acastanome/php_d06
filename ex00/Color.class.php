<?php
    class Color {
        public $red = 0;
        public $green = 0;
        public $blue = 0;
        public static $verbose = False;

        public function __construct(array $kwargs) {
            if (isset($kwargs['rgb']))
            {
                $this->red = intval($kwargs['rgb']) >> 16 & 255;
                $this->green = intval($kwargs['rgb']) >> 8 & 255;
                $this->blue = intval($kwargs['rgb']) & 255;
            }
            else
            {
                $this->red = intval($kwargs['red']);
                $this->green = intval($kwargs['green']);
                $this->blue = intval($kwargs['blue']);
            }
            if (Color::$verbose)
                print($this->__toString() . " constructed.\n");
        }

        public function __toString() {
            return(sprintf('Color( red: %3d, green: %3d, blue: %3d )', $this->red, $this->green, $this->blue));
        }

        public static function doc() {
            if (file_exists("./Color.doc.txt"))
                return(file_get_contents("./Color.doc.txt"));
        }

        public function add(Color $color) {
            return new Color(array('red'=>$this->red + $color->red, 'green'=>$this->green + $color->green, 'blue'=>$this->blue + $color->blue));
        }

        public function sub(Color $color) {
            return new Color(array('red'=>$this->red - $color->red, 'green'=>$this->green - $color->green, 'blue'=>$this->blue - $color->blue));
        }

        public function mult($mult) {
            return new Color(array('red'=>$this->red * $mult, 'green'=>$this->green * $mult, 'blue'=>$this->blue * $mult));
        }

        public function __destruct() {
            if (Color::$verbose)
                print($this->__toString() . " destructed.\n");
        }
    }