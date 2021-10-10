<?php
//Objeto User
class User{
 
    //Conexion a DB
    private $conn;
    private $table_name = "users";
 
    //Propiedades del objeto
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $access_level;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
//Nuevo Usuario
function create(){
 
    //query
    $query = "INSERT INTO " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                password = :password,
                access_level = :access_level";
 
    //prepararmos el query
    $stmt = $this->conn->prepare($query);
 
    //sanitize
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->access_level=htmlspecialchars(strip_tags($this->access_level));
 
    //Unimos los valores
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':access_level', $this->access_level);
 
    //Encriotamos la contraseña
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password_hash);
 
    //Ejecutamos
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
 
//Verificamos si existe el email
function emailExists(){
 
    //query
    $query = "SELECT id, firstname, lastname, password, access_level
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";
 
    //Preparamos el query
    $stmt = $this->conn->prepare( $query );
 
    //sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
 
    //Enlazamos el valor de email
    $stmt->bindParam(1, $this->email);
 
    //ejecutamos
    $stmt->execute();
 
    //Contamos las filas
    $num = $stmt->rowCount();
 
    //Validamos que no este vacio
    if($num>0){
 
        //Tomamos los valores
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        //asignamos los valosres a las propiedades del objeto
        $this->id = $row['id'];
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->password = $row['password'];
        $this->access_level = $row['access_level'];
 
        return true;
    }
 
    return false;
}
 
    //Actualizar usuario
    public function update(){
     
        //Validar password
        $password_set=!empty($this->password) ? ", password = :password" : "";
     
        //Si no hay password no se actualiza
        $query = "UPDATE " . $this->table_name . "
                SET
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email
                    {$password_set}
                WHERE id = :id";
     
        //query
        $stmt = $this->conn->prepare($query);
     
        //sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->access_level=htmlspecialchars(strip_tags($this->access_level));
     
        //Unimos los valores
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':access_level', $this->access_level);
     
        //Encriptamos el password
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }
     
        //Unimos los valores
        $stmt->bindParam(':id', $this->id);
     
        //ejecutamos
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    

    
}