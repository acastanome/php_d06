<?php

    require_once "./Vector.class.php";
    require_once "./Vertex.class.php";
    require_once "./Color.class.php";

    class Matrix {

        private $_preset = 0;
		private $_scale = 0;
		private $_angle = 0;
		private $_vtc = 0.0;
		private $_fov = 0.0;
		private $_ratio = 0.0;
		private $_near = 0.0;
		private $_far = 0.0;

        const IDENTITY = "IDENTITY";
        const SCALE = "SCALE";
        const RX = "Ox ROTATION";
        const RY = "Oy ROTATION";
        const RZ = "Oz ROTATION";
        const TRANSLATION = "TRANSLATION";
        const PROJECTION = "PROJECTION";

        private $_matrix = array();
		static $verbose = false;

        function __construct($arr)
		{
			if (isset($arr)) {
				if (isset($arr['preset']))
                    $this->_preset = $arr['preset'];
				if (isset($arr['scale']))
                    $this->_preset = $arr['scale'];
				if (isset($arr['angle']))
                    $this->_preset = $arr['angle'];
				if (isset($arr['vtc']))
                    $this->_preset = $arr['vtc'];
				if (isset($arr['fov']))
                    $this->_preset = $arr['fov'];
				if (isset($arr['ratio']))
                    $this->_preset = $arr['ratio'];
				if (isset($arr['near']))
                    $this->_preset = $arr['near'];
				if (isset($arr['far']))
                    $this->_preset = $arr['far'];
                $this->_createMatrix();
			}

			if (Vector::$verbose) {
                if ($this->_preset == Self::IDENTITY)
                    print($this->__toString() . " instance constructed\n");
                else
                    print($this->__toString() . " preset instance constructed\n");
            }
            $this->_choose();
		}

		function __toString()
		{
			return (sprintf("M | vtcX | vtcY | vtcZ | vtxO\n-----------------------------\nx | %0.2f | %0.2f | %0.2f | %0.2f\ny | %0.2f | %0.2f | %0.2f | %0.2f\nz | %0.2f | %0.2f | %0.2f | %0.2f\nw | %0.2f | %0.2f | %0.2f | %0.2f\n)", $this->_matrix[0], $this->_matrix[1], $this->_matrix[2], $this->_matrix[3], $this->_matrix[4], $this->_matrix[5], $this->_matrix[6], $this->_matrix[7], $this->_matrix[8], $this->_matrix[9], $this->_matrix[10], $this->_matrix[11], $this->_matrix[12], $this->_matrix[13], $this->_matrix[14], $this->_matrix[15]));
		}

		static function doc() {
			if (file_exists("./Matrix.doc.txt"))
				return(file_get_contents("./Matrix.doc.txt"));
			return "";
		}

        function __destruct() {
			if (Matrix::$verbose)
				print($this->__toString() . " instance destructed\n");
		}

        private function _createMatrix() {
			for ($i = 0; $i < 16; $i++)
                $this->matrix[$i] = 0;
		}

        private function _choose()
        {
            switch ($this->_preset) {
                case (self::IDENTITY) :
                    $this->identity(1);
                    break;
                case (self::TRANSLATION) :
                    $this->translation();
                    break;
                case (self::SCALE) :
                    $this->identity($this->_scale);
                    break;
                case (self::RX) :
                    $this->rotation_x();
                    break;
                case (self::RY) :
                    $this->rotation_y();
                    break;
                case (self::RZ) :
                    $this->rotation_z();
                    break;
                case (self::PROJECTION) :
                    $this->projection();
                    break;
            }
        }

        private function _identity($scale) {
            $this->matrix[0] = $scale;
            $this->matrix[5] = $scale;
            $this->matrix[10] = $scale;
            $this->matrix[15] = 1;
		}
    }
?>