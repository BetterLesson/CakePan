#CakePan 

CakePan is a CakePHP view helper that renders Mustache templates. It will also load and process sub-templates!

### Why use Mustache templates in CakePHP?
<strong>Portability and scalability!</strong> If you have an app that uses lots of front-end coding, you only have to write your templates once. Mustache templates can be rendered in PHP, Javascript, Ruby, Scala, even C++! If you want to move to or from some other framework (Rails, Grails, Lithium etc.), you can be sure that your views and design won't have to be re-built.

For scalability, when the time comes, you can use templates with a more powerful engine like Scala, or just send JSON from any source, and render with Javascript. 

## Use

### install
First - make afolder called 'mustache' in your vendors folder. Add the Mustache PHP library to your app/vendor folder. from https://github.com/bobthecow/mustache.php/

Then, place this helper out into the views/helpers folder of your CakePHP project. 

### production
Write your elements in mustache format with the extension ".mustache" rather than ".ctp"!

The Mustache manual is here: http://mustache.github.com/

In your view - render an element using $this->Mustache->render('element', $params); just like you would render a CakePHP element. 
All the variable set by the controller are available, and merged with values passed into $params.

Sub-templates should follow the same naming convention. Mustache will pass the variables to the sub-template in the context that it's called. For example, a nested template for a blog post with comments might look like:

<pre>
<strong>/views/elements/posts/post.mustache :</strong>
{{#Post}}
  &lt;h2&gt;{{title}}&lt;/h2\&gt;
  &lt;div&gt;
    {{text}}
  &lt;/div&gt;
{{/Post}}
{{#Comment}}
  {{&gt;post/comment}}
{{/Comment}}


<strong>/views/elements/posts/comment.mustache :</strong>
&lt;div&gt;
&lt;h3&gt;{{#User}}{{name}}{{/User}} said: &lt;/h3&gt;
&lt;p&gt;{{text}}&lt;/p&gt;
&lt;/div&gt;
</pre>
In this example, the post/comment element is called within the context of one of the comments (which in this case belongs to a User)

## Todo
- Test suite