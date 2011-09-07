<?php
/** Mustache view helper for CakePHP
 * 
 * 2011 BetterLesson Inc.
 * Andrew Drane
 * Jonathan Hendler
 * 
 * Process Mustache templates into your CakePHP application.
 * Figures out sub-templates
 * 
 * 
 * A few conventions
 * 
 * element: the name of the element - like you would use in CakePHP. 
 * For example users/name corresponds to app/views/elements/users/name.mustache
 * 
 * template: the text from an element
 * 
 * partials: elements called within elements. To include an element call within
 * your element, simply use the element convention in the proper context
 * 
 * 
 * 
 */


require_once ROOT . '/app/vendors/mustache/Mustache.php';

class MustacheHelper extends AppHelper {
    var $ext = 'mustache'; //so we don't get them by accident!
    var $path = '';
    var $partials = array(); //recursively load partials. Save as class variable so we don't need to double-load
    
//    var $cp = "<li>
//        {{name}}
//</li>";

    function element( $element ){
        try {
            //return $M->render('Hello {{planet}}', array('planet' => 'World!'));
            $template = $this->_loadTemplate( $element );
        
            $V = ClassRegistry::getObject('view');
            $M = new Mustache( $template, $V->viewVars, $this->partials );

            $result = $M->render();
            
        } catch ( Exception $e ) {
            debug( $e );
            return false;
        }
        
        return $result;
    }
    
    private function _getElementPath( $element ) {
        return ROOT . DS . 'app' . DS . 'views' . DS . 'elements' . DS . $element . '.' . $this->ext;
    }
    
    
    //@TODO
    //load template
    
    /** Load an element file. Make sure it exists and debug a warning if not
     *
     * @param type $element
     * @return type 
     */
    private function _loadTemplate( $element ) {
        $path = $this->_getElementPath( $element );
        
        if(!file_exists( $path ) ) {
            debug("Bad template  called in mustache: $element<br />");
            return '';
        }

        $template_file = fopen( $path, 'r' );
        $template = fread ( $template_file, filesize( $path ) );
        
        //load any partials
        $this->_loadPartials( $template );
        return $template;
    }
    
    /** Loads partials recursively from the elements
     *
     * @param type $template 
     */
    private function _loadPartials( $template ) {
        //Extract any partials from the 
        preg_match_all( '/\{\{[\s]*\>[\s]*(.*)[\s]*\}\}/', $template, $partials );

        
        foreach($partials[1] as $partial ) {
            if( !isset( $this->partials[ $partial ]) ) {
                $this->partials[ $partial ] = $this->_loadTemplate( $partial );
            }
        }
     }
    
    //load partials -- recursive!!

}