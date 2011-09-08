#CakePan 

CakePan is a CakePHP view helper that renders Mustache templates.

It will load and render sub-templates as well

## Use

### install
First - make afolder called 'mustache' in your app/vendors folder. Add the Mustache PHP library to your app/vendor folder. from https://github.com/bobthecow/mustache.php/

Then, place this helper out into the app/views/helpers folder of your CakePHP project. 

### production
Write your elements in mustache format with the extension ".mustache" rather than ".ctp"!

The Mustache manual is here: http://mustache.github.com/

In your view - render an element using $this->Mustache->render('element'); just like you would render a CakePHP element. Make sure all the variables you need are set in the controller.

Sub-templates should follow the same naming convention. 