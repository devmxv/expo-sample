<?php

class Marca {
	private $conn;
	private $tabla = "marca";

	//---propiedades, generalmente llamadas de BD
	public $id_marca;
	public $categoria;
	public $nombre;
	public $descripcion;
	public $stand;
	public $direccion;
	public $telefono;
	public $contacto;
	public $logo;
	public $rutaImg;

	public $tipo;

	//---métodos de clase


	//---constructor
	public function __construct($db){
		$this->conn = $db;
	}


	//---busqueda_expositor - Búsqueda directa de expositor
	public function busqueda_marca(){
		if($this->tipo == "marca"){
			//---como PDO omite % si se ponen directmanete, se tiene que concatenar % para que funcione
			$query = "SELECT * FROM " . $this->tabla . " WHERE nombre LIKE CONCAT('%', ?, '%')";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1,$this->nombre);
			$stmt->execute();

			$cuenta = $stmt->rowCount();
			if($cuenta >= 1){
				return $stmt;
			} else {
				return false;
			}

		} else {
			$query = "SELECT * FROM ". $this->tabla . " WHERE categoria LIKE '?' ";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1,$this->nombre);
			$stmt->execute();

			$cuenta = $stmt->rowCount();
			if($cuenta >= 1){
				return $stmt;
			} else {
				return false;
			}
		}
	}

	//---busqueda_alfabeto - Método que dependiendo la selección se muestran las marcas dentro de ese rango
	public function busqueda_alfabeto($rango){
		switch ($rango) {
			case 1:
				//---rango de búsqueda A-I
				$query = "SELECT * FROM " . $this->tabla . " WHERE nombre REGEXP '^[A-I] ORDER BY nombre ASC";
				$stmt = $this->conn->prepare($query);
				$stmt = execute();

				return $stmt;
				break;
			case 2:
				//---rango J-R
				$query = "SELECT * FROM " . $this->tabla . " WHERE nombre REGEXP '^[J-R] ORDER BY nombre ASC";
				$stmt = $this->conn->prepare($query);
				$stmt = execute();

				return $stmt;
				break;
			case 3:
				//---rango J-R
				$query = "SELECT * FROM " . $this->tabla . " WHERE nombre REGEXP '^[J-R] ORDER BY nombre ASC";
				$stmt = $this->conn->prepare($query);
				$stmt = execute();

				return $stmt;
				break;
			default:
				return 0;
				break;
		}
	}

	//--------------------------
	// busqueda_marca_tabla() - Función para buscar el id seleccionado
	//                          de la tabla de resultados
	//-------------------------
	public function busqueda_marca_tabla(){
		$query = "SELECT * FROM " . $this->tabla . " WHERE idmarca = ?";
		$stmt = $this->conn->prepare($query);
		$stmt = bindParam(1, $this->id_marca);
		$stmt->execute();

		return $stmt;
	}


	//---------------------------
	// busqueda_por_cat() : Método para obtener los registros de búsqueda
	//                      por categoría seleccionada
	//---------------------------
	public function busqueda_por_cat(){
		$query = "SELECT * FROM " . $this->tabla . " WHERE categoria = ?";
		$stmt = $this->conn->prepare($query);
		$stmt = bindParam(1, $this->categoria);
		$stmt->execute();

		return $stmt;
	}


	//---mostrar listado completo de marcas registradas
	public function obtener_directorio(){
		$query = "SELECT * FROM " . $this->tabla;
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	//---mostrar las opciones de búsuqeda de autocompletar
	public function opciones_busqueda(){
		$texto = '';
		$query = "SELECT * FROM " . $this->tabla ." ORDER BY nombre";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$cuenta = $stmt->rowCount();
		if($cuenta >= 1){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->nombre = $row['nombre'];
		}
	}

	//---opciones_categoria: Para mostrar los filtros por categoría
	public function opciones_categoria(){
		$query = "SELECT DISTINCT categoria FROM marca";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="' .$row["categoria"]. '">' .$row["categoria"]. '</option>';
		}
	}
}



?>