<?php

	require_once "./Vertex.class.php";
	require_once "./Color.class.php";

	class Vector {

		private $_x = 0;
		private $_y = 0;
		private $_z = 0;
		private $_w = 0.0;
		static $verbose = false;

		function __construct($arr)
		{
			if (isset($arr['dest']) && $arr['dest'] instanceof Vertex) {
				if (isset($arr['orig']) && $arr['orig'] instanceof Vertex) {
					$orig_coords = array('x' => $arr['orig']->read_x(), 'y' => $arr['orig']->read_y(), 'z' => $arr['orig']->read_z());
					$orig = new Vertex($orig_coords);
				}
				else {
					$orig = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
				}
				$this->_x = $arr['dest']->read_x() - $orig->read_x();
				$this->_y = $arr['dest']->read_y() - $orig->read_y(); 
				$this->_z = $arr['dest']->read_z() - $orig->read_z();

			}

			if (Vector::$verbose)
				print($this->__toString() . " constructed\n");
		}

		function __toString()
		{
			return (sprintf("Vector( x:%0.2f, y:%0.2f, z:%0.2f, w:%0.2f )", $this->_x, $this->_y, $this->_z, $this->_w));
		}

		static function doc() {
			if (file_exists("./Vector.doc.txt"))
				return(file_get_contents("./Vector.doc.txt"));
			return "";
		}

		function __destruct() {
			if (Vector::$verbose)
				print($this->__toString() . " destructed\n");
		}


		/*   Magnitude of a vector: The length of the vector (Sum of x, y, z squares).   */
		function magnitude() {
			$x = $this->_x;
			$y = $this->_y;
			$z = $this->_z;
			return (float)sqrt(($x * $x) + ($y * $y) + ($z * $z));
		}

		/*   Normalize a vector: Change vector's length to 1, turning it into unit vector. The direction doesn't change.   */
		function normalize() {
			$mag = $this->mag;
			if ($mag == 1)
				return (clone $mag);
			else {
				return $this->div($this->magnitude());
			}
		}

		/*   Sum vector of two vectors   */
		function add(Vector $rhs) {
			$sum = new Vector(array('dest' => new Vertex(array(
				'x' => $this->_x + $rhs->read_x(),
				'y' => $this->_y + $rhs->read_y(),
				'z' => $this->_z + $rhs->read_z())
			)));
			return ($sum);
		}

		/*   Difference vector of two vectors.   */
		function sub(Vector $rhs) {
			$diff = new Vector(array('dest' => new Vertex(array(
				'x' => $this->_x - $rhs->read_x(),
				'y' => $this->_y - $rhs->read_y(),
				'z' => $this->_z - $rhs->read_z())
			)));
			return ($diff);
		}

		/*   Division of vector by a given value   */
		function div($k) {
			$div = new Vector(array('dest' => new Vertex(array(
				'x' => $this->_x / $k,
				'y' => $this->_y / $k,
				'z' => $this->_z / $k)
			)));
			return ($div);
		}

		/* Opposite vector */
		function opposite() {
			$opp = new Vector(array('dest' => new Vertex(array(
				'x' => $this->_x * (-1),
				'y' => $this->_y * (-1),
				'z' => $this->_z * (-1) )
			)));
			return ($opp);
		}

		/* Product (or multiplication) of vector by scalar-value */
		function scalarProduct($k) {
			$scale = new Vector(array('dest' => new Vertex(array(
				'x' => $this->_x * $k,
				'y' => $this->_y * $k,
				'z' => $this->_z * $k )
			)));
			return ($scale);
		}

		/* Product (or multiplication) of vectors x1*x2 + y1*y2 + z2 * z2 */
		function dotProduct(Vector $rhs) {
			$dot = (float)(
				$this->_x * $rhs->read_x() +
				$this->_y * $rhs->read_y() +
				$this->_z * $rhs->read_z()
			);
			return ($dot);
		}

		/* The cosine of the angle between two nonzero vectors is equal to the dot product of the vectors divided by the product of their lengths. */
		function cos(Vector $rhs) {
			if ($this->magnitude() == 'norm' || $rhs->magnitude() == 'norm')
				return (0);
			else
			{
				$len_prod = ($this->magnitude() * $rhs->magnitude());
				return ((float)($this->dotProduct($rhs) / $len_prod));
			}
		}


		public function crossProduct(Vector $rhs)
		{
			return new Vector(array('dest' => new Vertex(array(
				'x' => $this->_y * $rhs->read_z() - $this->_z * $rhs->read_y(),
				'y' => $this->_z * $rhs->read_x() - $this->_x * $rhs->read_z(),
				'z' => $this->_x * $rhs->read_y() - $this->_y * $rhs->read_x()
			))));
		}

		function read_x()
		{
			return $this->_x;
		}

		function read_y()
		{
			return $this->_y;
		}

		function read_z()
		{
			return $this->_z;
		}

		function read_w()
		{
			return $this->_w;
		}
	}
?>