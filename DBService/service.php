<?php
	include "includes/conn.php"; // Incluyo el script con la clase de la conexión a la base de datos.
	
	$conn = new Conn(); // Creo una nueva conexión.
	header("Content-Type:application/json"); // Codifico en JSON.

	switch(true) // Hago un switch a la solicitud que llega.
	{
		case isset($_GET["create"]): // Si es create.
			$already = false; // Uso la variable $already para verificar si hay datos repetidos.
			$name = $_GET["name"]; // Recibo todos los datos que vienen por GET en Variables.
            $surname = $_GET["surname"];
			$phone = $_GET["phone"];
			$email = $_GET["email"];
			$pass = $_GET["pass"];
			$bday = $_GET["bday"];
			$gender = $_GET["gender"];
			$img = $_GET["img"];
			$path = "";
			$hash = password_hash($pass, PASSWORD_DEFAULT); // Cifro la contraseña.

			$stmt = $conn->prepare("SELECT phone, email FROM contacto"); // Preparo la consulta SQL a la conexión $conn.
			$stmt->execute(); // La Ejecuto.
			while($row = $stmt->fetch(PDO::FETCH_OBJ)) // Mientras haya resultados, los asigno a la variable $row.
			{
				if ($email == $row->email || $phone == $row->phone) // Si el email o el teléfono enviados para registrarse están en la base de datos.
				{
					$already = true; // Pongo $already a true.
					break; // Salgo del case.
				}
			}

			if (!$already) // Si $already es false
			{
				$sql = "INSERT INTO contacto (name, surname, phone, email, pass, bday, gender, path) VALUES('$name', '$surname', '$phone', '$email', '$hash', '$bday', '$gender', '$path')";
				$stmt = $conn->prepare($sql);
				$stmt->execute(); // Creo la consulta para insertar, la preparo y la ejecuto.
				$id = $conn->lastInsertId(); // Recojo en la variable $id la id de la fila insertada.
				if($id) // Si todo ha ido bien
				{
					if ($img != "") // Verifico si el usuario subió una imagen.
					{
						$ruta = "users/" . $id; // Asigno a la variable $ruta la ruta donde se guardaará la imagen de lusurio.
						if (!is_dir($ruta)) // Si no existe el directorio con el nombre de la ruta.
						{
							mkdir($ruta, 0777, true); // Lo creo.
						}
						$path = $ruta . "/" . $img; // Asigno a la variable $path la ruta con la $ruta/Nombre de la foto.
						rename("tmp/" . $img, $path); // Con rename muevo la imagen a la ruta $path.
					}
					else // Si el usuario no subió una imagen.
					{
						if ($gender == 0) // Verifco el genero del usuario, 0 es Femenino.
						{
							$path = "img/female.jpg"; // Asigno a $path la imagen con contorno femenino.
						}
						else // Si el genero es 1, masculino.
						{
							$path = "img/male.jpg"; // Asigno a $path la imagen con contorno masculino.
						}
					}
					$stmt = $conn->prepare("UPDATE contacto SET path='$path' WHERE id=$id;"); // Preparo una consulta para Actualizar la tabla.
					$stmt->execute(); // La Ejecuto.

					response(200, "Se Ha Agregado Correctamente El Usuario: ", $name); // Paso a la función response el códdigo 200, el mensajes y el dato.
				}
				else // Si hubo un fallo de conexión con la base de datos.
				{
					response(300, "Algo Ha Fallado, No Se Ha Podido Agregar el Usuario: ", $name); // Paso a la función response el códdigo 300, el mensajes y el dato.
				}
			}
			else // Si $already está a true.
			{
				response(300, "El Teléfono o la Dirección de E-mail ya Están Registrados, No Se Ha Podido Agregar el Usuario: ", $name); // Los datos ya están en la base de datos, email o teléfono.
			}
			break;
		case isset($_GET["read"]): // Si la soplicitud es read.
			$id = $_GET["id"]; // Recibo la ID.
			if($id != "") // Si no está vacía.
			{
				$sql = $conn->prepare("SELECT * FROM contacto WHERE id=:id"); // Solicito todos los datos del usuario con id $id.
				$sql->bindValue(':id', $id);
				$sql->execute();
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$stmt = $sql->fetchAll();

				if (count($stmt) > 0) // Si lo encuentra.
				{
					response(200, "El Usuario con ID: $id es: ", $stmt); // Envio a la función response el código 200 el mensaje y los datos de la base de datos.
				}
				else // Si no encuentra ningún resultado
				{
					response(300, "No Existe el Usuario con ID: $id", ""); // Es que no existe el usuario con esa ID.
				}
			}
			else // Si la ID viene vacía.
			{
				$sql = $conn->prepare("SELECT * FROM contacto"); // Solicito todos los resultados de la base de datos.
				$sql->execute();
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$stmt = $sql->fetchAll();

				if (count($stmt) > 0) // Si hay resultados.
				{
					response(200, "Esta es la Lista Completa de Usuarios: ", $stmt); // Envio a la función response el código 200 el mensaje y los datos de la base de datos.
				}
				else
				{
					response(300, "No Hay Datos Aun en la Base de Datos", ""); // Si no encuentra nada es que aun no hay ningún dato en la base de datos.
				}
			}
			break;
		case isset($_GET["update"]): // Si llega la solicitud update.
			$already = false; // Uso la variable $already para verificar si se repiten datos unicos como email o teléfono.
			$id = $_GET["id"];
			$name = $_GET["name"];
            $surname = $_GET["surname"];
			$phone = $_GET["phone"];
			$email = $_GET["email"];
			$pass = $_GET["pass"];
			if ($pass != "") // Si el usuario cambió la contraseña.
			{
				$hash = password_hash($pass, PASSWORD_DEFAULT); // La cifro.
			}
			$bday = $_GET["bday"];
			$gender = $_GET["gender"];
			$path = $_GET["path"];

			$stmt = $conn->prepare("SELECT id, phone, email FROM contacto"); // Solicito la ID phone e email de toda la base de datos.
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_OBJ)) // Miestras haya resultados los asigno a la variable $row.
			{
				if ($id != $row->id) // Verifico que la id del usuario a modificar no sea la que estoy comparando.
				{
					if ($email == $row->email || $phone == $row->phone) // Verifico si el email o el teléfono modificados están en la base de datos.
					{
						$already = true; // Si alguno ya está pone $already a true.
					}
				}
				else // Si estoy verificando los datos de la ID del usuario.
				{
					$old_email = $row->email; // Asigno a la variable $old_email el email que estaba en la base de datos.
					$old_phone = $row->phone; // Asigno a la variable $old_phone el teléfono que estaba en la base de datos.
				}
			}

			if (!$already) // Si $already es false.
			{
				if ($email == $old_email) // Verifico si el email es el mismo que ya estaba.
				{
					if ($phone == $old_phone) // Verifico si el teléfono es el mismo que ya estaba.
					{
						$sql = "UPDATE contacto SET name='$name', surname='$surname', pass='$hash', bday='$bday', gender='$gender', path='$path' WHERE id=$id;";
						// Preparo la consulta para modificar con la nueva contraseña pero sin email ni phone ya que el usuario no los cambió y como son claves únicas
						// no se puede volver a insertarlos en la base de datos.
					}
					else // Si el teléfono es diferente, el usuario lo cambió y ya se verifico que no está repetido en la base de datos.
					{
						$sql = "UPDATE contacto SET name='$name', surname='$surname', phone='$phone', pass='$hash', bday='$bday', gender='$gender', path='$path' WHERE id=$id;";
					}
				}
				else if ($phone == $old_phone) // Si el email es distinto pero el phone es el mismo.
				{
					$sql = "UPDATE contacto SET name='$name', surname='$surname', email='$email', pass='$hash', bday='$bday', gender='$gender', path='$path' WHERE id=$id;";
				}
				else // Si es distinto el email y el teléfono.
				{
					$sql = "UPDATE contacto SET name='$name', surname='$surname', phone='$phone', email='$email', pass='$hash', bday='$bday', gender='$gender', path='$path' WHERE id=$id;";
				}
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				if($stmt->rowCount() > 0) // Si se modificó el dato
				{
					response(200, "Se Ha Modificado Correctamente El Usuario: ", $name); // Mensaje de usuario modificado
				}
				else // Si no.
				{
					response(300, "No Existe El Usuario con ID: ", $id); // Es que la ID introducida no está en la base de datos.
				}
			}
			else // Si $already está a true.
			{
				response(300, "El Teléfono o la Dirección de E-mail ya Están Registrados, No Se Ha Podido Modificar el Usuario: ", $name); // Email o phone repetidos.
			}
			break;
		case isset($_GET["delete"]): // Si la solicitud es delete.
			$id = $_GET["id"];
			$sql = "DELETE FROM contacto WHERE id=:id"; // Borra el usuario por la ID.
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			if($stmt->rowCount() > 0) // Verifico si se ha modificado la cantidad de filas.
			{
				$ruta = "users/" . $id; // Asigno a la varible $ruta la ruta users/id.
				if (is_dir($ruta)) // Si es un directorio.
				{
					foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($ruta, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $path)
					{
						$path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
					}
					// hago un foreach para buscar todos los archivos del usuario y borrarlos recursivamente.
					chdir("users"); // Cambio a la carpeta users.
					rmdir($id); // Borro la carpeta del usuario que es su ID.
				}
                $sql = "SET @count = 0; UPDATE contacto SET id = @count:= @count + 1; ALTER TABLE contacto AUTO_INCREMENT = 1;"; // Arreglo los índices de las facturas.
                $stmt = $conn->prepare($sql);
                $stmt->execute();
				response(200, "Se Ha Borrado Correctamente El Usuario con ID: ", $id); // Envio la respuesta que se ha borrado el usuario.
			}
			else // Si no se modificó la cantidad de filas.
			{
				response(300, "No Existe El Usuario con ID: ", $id); // El usuario con esa ID no existe.
			}
			break;
		case isset($_GET["login"]): // Si llega una solicitud de login.
			$email = $_GET["email"]; // Asigno a la variable $email el contenido de $_GET["email"], el email del usuario.
			$pass = $_GET["pass"]; // Asigno a la varible $pass la contraseña.
			$ok = false; // Asgino falso a la variable $ok, la uso para saber si la contraseña del usuario es la correcta.

			$sql = "SELECT * FROM contacto WHERE email='$email'"; // Preparo la consulta, solicito todos los datos del usuario con email $email.
			$stmt = $conn->prepare($sql);
			$stmt->execute(); // Ejecuto la consulta.
            if ($stmt->rowCount() > 0)
            {
                $row = $stmt->fetch(PDO::FETCH_OBJ); // Asigno el resultado a la variable $row.
                if (password_verify($pass, $row->pass)) // Verifico si la decodificación del contenido de la fila pass es igual al password introducido por el usurio $pass.
                {
                    $ok = true; // Si coincide $ok es true.
                }
            }
			if ($ok) // Si $ok está a true.
			{
				response(200, "Bienvenido Usuario: ", array($row->id, $row->name, $row->surname, $row->phone, $email, $pass, $row->bday, $row->gender, $row->path));
				// devuelvo un array con la ID el nombre, el email, la contraseña, la fecha, el genero y la ruta de la imagen.
			}
			else // Si $ok está a false.
			{
				response(300, "No se ha Encontrado el E-mail: ", $email . " en la Base de Datos o la Contraseña no es Correcta."); // Datos incorrectos.
			}
			break;
		case isset($_GET["forget"]): // Si la solicitud es forget, olvido de contraseña.
			$email = $_GET["email"]; // Recibo el email.
			$stmt = $conn->prepare("SELECT email FROM contacto WHERE email='$email'"); // Solicito el email que coincida con el enviado por el usuario.
			$stmt->execute(); // Ejecuto la consulta.
			$user = $stmt->fetch(PDO::FETCH_OBJ);
			if ($user->email == $email) // Si está en la base de datos.
			{
				$hash = password_hash("1111", PASSWORD_DEFAULT); // Codifico la cadena 1111 en la variable $hash.
				$sql = "UPDATE contacto SET pass='$hash' WHERE email='$email'"; // Hago un udate a la base de datos a la columna pass con el $hash a la dirección del email del usuario.

				$stmt = $conn->prepare($sql);
				$stmt->execute();

				response(200, "Se Ha Creado la Contraseña Provisoria 1111, Logueate y Cámbiala Inmediatamente", "Gracias por Usar Este Servicio.");
				// Informo que se ha asignado la contraseña 1111 que entre y la cambie.
			}
			else // Si el email no está en la base de datos.
			{
				response(300, "No se ha Encontrado el E-mail: ", $email); // No se ha encontrado el email.
			} 
			break;
	}

	function response($status, $message, $data) // Función response recibe tres parametros, el estado (status), un mensaje y los datos solicitados/esperados.
	{
		header("HTTP/1.1 $status $message");
		$response['status'] = $status;
		$response['message'] = $message;
		$response['data'] = $data;

		$json_response = json_encode($response); // Asigna a la varible $json_response la codificación en JSON del array $response.
		echo $json_response; // Lo devuelve al cliente que hizo la llamada, index.php o forget.php.
	}
?>