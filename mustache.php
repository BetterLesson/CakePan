<?php
require_once ROOT . '/app/vendors/mustache/Mustache.php';

class MustacheHelper extends AppHelper {
    var $ext = 'mustache'; //so we don't get them by accident!
    var $path = '';

    function element( $element ){
        try {
            $V = ClassRegistry::getObject('view');
            $M = new Mustache;

            $this->path = $this->getElementPath( $element );
                

            $template_file = fopen( $this->path, 'r' );

            //return $M->render('Hello {{planet}}', array('planet' => 'World!'));

            $template = fread ( $template_file, filesize( $this->path ) );
        
       
            $result = $M->render( $template, $V->viewVars );
            
        } catch ( Exception $e ) {
            debug( $e );
            return false;
        }
        
        return $result;
        
    }
    
    private function getElementPath( $element ) {
        return ROOT . DS . 'app' . DS . 'views' . DS . 'elements' . DS . $element . '.' . $this->ext;
    }

}