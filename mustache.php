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
 * Requires the Mustache.php library - available from:
 * https://github.com/bobthecow/mustache.php/
 * 
 * 
 * A few conventions:
 * 
 * Element: the name of the element - like you would use in CakePHP. 
 *  For example users/name corresponds to app/views/elements/users/name.mustache
 * 
 * Template: the text string from an element, which is read from the element file.
 *  This is what gets passed into Mustache for conversion to HTML
 * 
 * Partials: elements called within elements. To include an element call within
 *  your element, simply use the element convention in the proper context! 
 *  Mustache takes care of the Data context
 * 
 */


require_once ROOT . '/app/vendors/mustache/Mustache.php';

class MustacheHelper extends AppHelper {
    var $ext = 'mustache'; //Extention for the templates. 'mustache' unless noted otherwise
    var $partials = array(); //recursively load partials. Save as class variable so we don't need to double-load
   

    /** Returns the rednered template as HTML. 
     * All variables should be set to the view
     *
     * @param string $element - element location, no extention (e.g. 'users/course')
     * @return string - HTML from the Mustache template
     */
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
    
    
    /** Get the path to an element file. Will have the extension provided above
     *
     * @param string $element - relative path from the elements folder
     * @return string - system path to the element for PHP fread functions
     */
    private function _getElementPath( $element ) {
        return ROOT . DS . 'app' . DS . 'views' . DS . 'elements' . DS . $element . '.' . $this->ext;
    }
       
    
    /** Load an element file. Make sure it exists and debug a warning if not
     *
     * @param string - $element relative path from the elements folder
     * @return string - template string for rendering with Mustache
     */
    private function _loadTemplate( $element ) {
        $path = $this->_getElementPath( $element );
        
        //fail nicely if we have a bad file
        if(!file_exists( $path ) ) {
            debug("Bad template  called in mustache: $element<br />"); 
            return '';
        }

        //read the file contents
        $template_file = fopen( $path, 'r' );
        $template = fread ( $template_file, filesize( $path ) );
        
        //load any partials
        $this->_loadPartials( $template );
        return $template;
    }
    
    
    /** Loads partials recursively from an element. 
     * Allows sub-template rendering
     *
     * @param string $template - template string.
     */
    private function _loadPartials( $template ) {
        //Extract names of any partials from the template
        preg_match_all( '/\{\{[\s]*\>[\s]*(.*)[\s]*\}\}/', $template, $partials );

        //iterate through the partials - add them to the partials list if they haven't been added before
        foreach($partials[1] as $partial ) {
            if( !isset( $this->partials[ $partial ]) ) {
                $this->partials[ $partial ] = $this->_loadTemplate( $partial );
            }
        }
     }


}