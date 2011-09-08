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