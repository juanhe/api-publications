<?php
// 'user' object
class Posts{
 
    // database connection and table name
    private $conn;
    private $table_name = "posts";
 
    // object properties
    public $id;
    public $title;
    public $status;
    public $content;
    public $user_id;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
    // create new user record
    function create_post(){
        
        // insert query
        $query = "INSERT INTO " . $this->table_name . " SET
                    title = :title,
                    content = :content,
                    user_id = :user_id";
     
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->content=htmlspecialchars(strip_tags($this->content));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
     
        // bind the values
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':user_id', $this->user_id);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    
    
    // create new user record
    function update_post(){
        
        //Fecha y hora actuales
        $modified = date("Y-m-d H:i:s");
        $this->modified = $modified;
        
        // insert query
        $query = "UPDATE " . $this->table_name . "
                SET
                    title = :title,
                    content = :content,
                    modified = :modified,
                    user_id = :user_id
                    
                    
                WHERE id = :id";
     
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->content=htmlspecialchars(strip_tags($this->content));
        $this->modified=htmlspecialchars(strip_tags($this->modified));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
     
        // bind the values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':modified', $this->modified);
        $stmt->bindParam(':user_id', $this->user_id);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    
    // create new user record
    function delete_post(){
 
        // insert query
        $query = "UPDATE " . $this->table_name . "
                SET
                    status = 1
                    
                WHERE id = :id";
     
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind the values
        $stmt->bindParam(':id', $this->id);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    
    // check if given email exist in the database
    function validate_token(){
     
        // query to check if email exists
        $query = "SELECT nivel_de_acceso
                FROM users
                WHERE id= :id AND nivel_de_acceso = :nivel_de_acceso";
     
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nivel_de_acceso=htmlspecialchars(strip_tags($this->nivel_de_acceso));
     
        // bind given email value
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nivel_de_acceso', $this->nivel_de_acceso);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // return true because email exists in the database
            return true;
        }
     
        // return false if email does not exist in the database
        return false;
    }
    
}