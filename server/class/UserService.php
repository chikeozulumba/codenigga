<?php
class UserLogin
{
  protected $email;    
  protected $password; 

  protected $db;      
  protected $user;      
  protected $errors;      

  public function __construct(PDO $db, $email, $password) 
  {
      $this->db = $db;
      $this->email = $email;
      $this->password = $password;
  }

  public function Login () 
  {
    if ($this->ValidateEmail() == 'true' && $this->ValidatePassword() == 'true') {
      $user = $this->credentials();
      return $user;
    } else {
      return 'false';
    }
  }

  private function credentials()
  {
    $args = $this->db->prepare('SELECT * FROM users WHERE email=?');
    $args->execute(array($this->email));
    if ($args->rowCount() > 0) {
      $user = $args->fetch(PDO::FETCH_ASSOC);
      if ($user->password == $this->password) {
        return $user;
      } else {
        return 'Wrong password';        
      }
          return $user;
    }
    return 'false';
  }

  private function ValidateEmail() 
  {
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      return 'true';
    } else {
      return 'false';
    } 
    return 'false';
  }

  private function ValidatePassword() 
  {
    if (!empty($this->password)) {
      if (strlen($this->password) < 6) {
        return 'Password format incorrect, not less than 6 characters';
      } else {
        return 'true';
      }
    } else {
      return 'Password field cannot be empty';
    }
    return 'false';
  }

  
}

class UserRegister {
  protected $user = []; 
  protected $name;    
  protected $email; 
  protected $phone; 
  protected $state; 
  protected $pin; 
  protected $date; 

  protected $db;         
  protected $errors;  

   public function __construct(PDO $db, $user) 
  {
      $this->db = $db;
      $this->user = $user;
      $this->name = $user['name'];
      $this->email = $user['email'];
      $this->phone = $user['phone'];
      $this->state = $user['state'];
      $this->pin = $user['pin'];
      $this->date = $user['date'];
  }

  public function Register() 
  {
      if ($this->validatePhone()  == 'true' && $this->validateEmail() == 'true' &&  $this->validateDate() == 'true') {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $args = $this->db->prepare('INSERT INTO customers (name, email, phone, state, pin, date) VALUES(:name, :email, :phone, :state, :pin, :date)');
        $args->execute(array(
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "state" => $this->state,
            "pin" => $this->pin,
            "date" => $this->date
        ));
        $customers = $this->db->prepare('SELECT * FROM customers');
        $customers->execute();
        // $result = $customers->setFetchMode(PDO::FETCH_ASSOC); 
        return json_encode($customers->fetchAll());
      } else {
        return $this->errors;
      }
  }

  private function validatePhone() 
  {
    if(!preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', trim($this->phone))) {
          $this->errors =  'Please enter a valid phone number';
    } else {
          return 'true';
    }
  }
  
  public function validateEmail() 
  {
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $args = $this->db->prepare('SELECT * FROM customers WHERE email=?');
      $args->execute(array($this->email));
      if ($args->rowCount() > 0) {
        return $this->errors =  'Email already exists.';
      } else {
        return 'true';
      }
    } else {
      return $this->errors =  'Invalid email';
    } 
    return $this->errors =  'Invalid email address';
  }
  
  private function validateDate() 
  {
    if($this->date <= date("Y-m-d") && $this->date != '' ) {
      return 'true';
    } else {
      return $this->errors =  'Invalid date';
    }
  }  
}


class UserProfile {
  protected $data = []; 
  protected $db;               
  protected $errors;  

   public function __construct(PDO $db) 
  {
      $this->db = $db;
  }
   public function getData() 
  {
      $customers = $this->db->prepare('SELECT * FROM customers');
      $users = $this->db->prepare('SELECT * FROM users');
      $transactions = $this->db->prepare('SELECT sum(price) FROM transactions');
        $customers->execute();
        $users->execute();
        $transactions->execute();
        
        $Cresult =$customers->fetchAll(); 
        $Uresult = $users->fetchAll();
        $Tresult = $transactions->fetchAll();

        $load = $this->data = [
          'customers' => count($Cresult),
          'users' => count($Uresult),
          'transactions' => count($Tresult),
        ];

        return json_encode($load);
  }
}