 <?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/inc/jarvisConfig.php");
    class Conexao {
        public static $instance;

        private function __construct() {
        //
        }

        public static function getInstance() {
            if (!isset(self::$instance)) {
                self::$instance = new PDO('mysql:host='.HOST_BD.';port='.PORT_BD.';dbname='.NAME_BD, USER_BD, KEY_BD);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            }
            return self::$instance;
        }
    }
?>