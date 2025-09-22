<?PHP
SESSION_START();
include('database.php');

if(isset($_POST['Validação de e-mail para garantir que esteja em formato correto'])){

   $email = $_POST['email'];

   if(filter_var($email, FILTER_VALIDATE_EMAIL)){
       // E-mail válido
   } else {
       // E-mail inválido
   }

}
?>