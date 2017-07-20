 <?php
   
  class Conexao {
   
      public static $instance;
   
      private function __construct() {
          //
      }
   
      public static function getInstance() {
          if (!isset(self::$instance)) {
              self::$instance = new PDO('mysql:host=localhost;port=3307;dbname=pet_bicho_ensaboado', 'root', '');
              self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
          }
   
          return self::$instance;
      }
   
  }
   
  ?>